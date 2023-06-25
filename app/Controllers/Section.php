<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Section as ModelsSection;
use Exception;

class Section extends BaseController
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
        $count = count($sectionModel->select('id')->where('project_id', $projectId)->findAll());

        $data = [
            'project_id' => $projectId,
            'title' => $section,
            'position' => $count
        ];

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
                'section_name' => 'required|string|min_length[1]|max_length[255]',
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

        $sectionModel = new ModelsSection();
        try {
            $sectionModel->delete($sectionID);
        } catch (Exception $e) {
            return $this->handleResponse(['errors' => $e->getMessage()], 500);
        }

        return $this->handleResponse([]);
    }
}
