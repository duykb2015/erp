<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Section as ModelsSection;
use App\Models\Task;
use Exception;

class TaskStatus extends BaseController
{
    public function create()
    {
        $projectId = $this->request->getPost('project_id');
        $section = $this->request->getPost('section_name');

        $validation = service('validation');
        $validation->setRules(
            [
                'project_id'   => 'required|integer|is_not_unique[project.id]',
                'section_name' => 'required|string|min_length[1]|max_length[255]',
            ]
        );

        if (!$validation->run($this->request->getPost())) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $sectionModel = new ModelsSection();
        $sections     = $sectionModel->select(['id', 'base_section', 'position'])->where('project_id', $projectId)->findAll();
        $sections     = collect($sections);
        $baseDoneSection = $sections->where('base_section', '=', 3)->first();
        $count = count($sections);

        $data = [
            'project_id' => $projectId,
            'title' => $section,
            // The case where the section finish has been moved to a non-last position, ignore and do nothing.
            'position' => $count
        ];
        // In case the section finish is in the last position, we will swap them to make their state clear.
        // (if it's finished, it should be last)
        if (NULL != $baseDoneSection) {
            if (($count - 1) == $baseDoneSection['position']) {
                $data['position'] = $baseDoneSection['position'];
                $baseDoneSection['position'] = $count;

                $sectionModel->save($baseDoneSection);
            }
        }

        try {
            $sectionModel->insert($data);
        } catch (Exception $e) {
            return $this->handleResponse(['errors' => $e->getMessage()], 500);
        }

        return $this->handleResponse([]);
    }

    public function update()
    {
        $sectionID = $this->request->getPost('section_id');
        $section = $this->request->getPost('section_name');

        $validation = service('validation');
        $validation->setRules(
            [
                'section_id'   => 'required|integer|is_not_unique[section.id]',
                'section_name' => 'required|string|min_length[1]|max_length[255]|is_unique[section.title]',
            ]
        );

        if (!$validation->run($this->request->getPost())) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $sectionModel = new ModelsSection();

        $data = [
            'id' => $sectionID,
            'title' => $section,
        ];

        try {
            $sectionModel->save($data);
        } catch (Exception $e) {
            return $this->handleResponse(['errors' => $e->getMessage()], 500);
        }

        return $this->handleResponse([]);
    }

    public function delete()
    {
        $sectionID = $this->request->getPost('section_id');

        $validation = service('validation');
        $validation->setRules(
            [
                'section_id'   => 'required|integer|is_not_unique[section.id]',
            ]
        );

        if (!$validation->run($this->request->getPost())) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        //Không cho xoá nếu đó là base section

        $sectionModel = new ModelsSection();
        $section = $sectionModel->find($sectionID);
        if (0 != $section['base_section']) {
            return $this->handleResponse(['errors' => 'Không thể xoá base section'], 400);
        }

        $taskModel = new Task();
        $tasks = $taskModel->where('section_id', $sectionID)->find();

        if (!empty($tasks)) {
            return $this->handleResponse(['errors' => 'Trạng thái đang chứa công việc, không thể xoá!'], 400);
        }

        try {
            $sectionModel->delete($sectionID);
        } catch (Exception $e) {
            return $this->handleResponse(['errors' => $e->getMessage()], 400);
        }

        return $this->handleResponse([]);
    }
}
