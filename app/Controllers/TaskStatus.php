<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Task;
use App\Models\TaskStatus as ModelsTaskStatus;
use Exception;

class TaskStatus extends BaseController
{
    public function create()
    {
        $taskStatusData = $this->request->getPost();

        $validation = service('validation');
        $validation->setRules(
            [
                'project_id'   => 'required|integer|is_not_unique[project.id]',
                'task_status_name' => 'required|string|min_length[1]|max_length[255]',
            ]
        );

        if (!$validation->run($taskStatusData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $taskStatusModel = new ModelsTaskStatus();
        $taskStatus     = $taskStatusModel->select(['id', 'base_status', 'position'])
            ->where('project_id', $taskStatusData['project_id'])
            ->findAll();
        $taskStatus     = collect($taskStatus);

        $baseStatus3 = $taskStatus->where('base_status', '=', 3)->first();
        $lastStatus = $taskStatus->last();

        $data = [
            'project_id' => $taskStatusData['project_id'],
            'title' => $taskStatusData['task_status_name'],
            // The case where the section finish has been moved to a non-last position, ignore and do nothing.
        ];
        // In case the section finish is in the last position, we will swap them to make their state clear.
        // (if it's finished, it should be last)
        if ($lastStatus['position'] == $baseStatus3['position']) {
            $data['position'] = $baseStatus3['position'];
            $baseStatus3['position'] = $lastStatus['id'] + 1;

            $taskStatusModel->save($baseStatus3);
        } else {
            $data['position'] = $lastStatus['id'] + 1;
        }

        try {
            $taskStatusModel->insert($data);
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
                'section_id'   => 'required|integer|is_not_unique[task_status.id]',
                'section_name' => 'required|string|min_length[1]|max_length[255]|is_unique[task_status.title]',
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
                'section_id'   => 'required|integer|is_not_unique[task_status.id]',
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
