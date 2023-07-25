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
        $taskDoneStatus = $taskStatusModel->select(['id', 'base_status', 'position'])
            ->where('project_id', $taskStatusData['project_id'])
            ->where('base_status', 4)
            ->first();

        $data = [
            'project_id' => $taskStatusData['project_id'],
            'title' => $taskStatusData['task_status_name'],
            'position' => $taskDoneStatus['position']
        ];

        $taskDoneStatus['position'] += 1;
        $taskStatusModel->save($taskDoneStatus);

        try {
            $taskStatusModel->insert($data);
        } catch (Exception $e) {
            return $this->handleResponse(['errors' => $e->getMessage()], 500);
        }

        return $this->handleResponse([]);
    }

    public function update()
    {
        $taskStatusData = $this->request->getPost();

        $validation = service('validation');
        $validation->setRules(
            [
                'task_status_id'   => 'required|integer|is_not_unique[task_status.id]',
                'task_status_name' => 'required|string|min_length[1]|max_length[255]',
            ]
        );

        if (!$validation->run($taskStatusData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $taskStatusModel = new ModelsTaskStatus();
        $statusNameExist = $taskStatusModel->where('title', $taskStatusData['task_status_name'])->first();
        if ($taskStatusData['task_status_id'] != $statusNameExist['id']) {
            return $this->handleResponse(['errors' => ['task_status_name' => 'Trạng thái đã tồn tại']], 400);
        }


        $data = [
            'id' => $taskStatusData['task_status_id'],
            'title' => $taskStatusData['task_status_name'],
        ];

        try {
            $taskStatusModel->save($data);
        } catch (Exception $e) {
            return $this->handleResponse(['errors' => $e->getMessage()], 500);
        }

        return $this->handleResponse([]);
    }

    public function delete()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'task_status_id'   => 'required|integer|is_not_unique[task_status.id]',
            ]
        );

        if (!$validation->run($this->request->getPost())) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }
        $taskStatusID = $this->request->getPost('task_status_id');

        $taskStatusModel = new ModelsTaskStatus();
        $taskStatus = $taskStatusModel->find($taskStatusID);
        if (0 != $taskStatus['base_status']) {
            //Không cho xoá nếu đó là base section
            return $this->handleResponse(['errors' => 'Không thể xoá base section'], 400);
        }

        $taskModel = new Task();
        $tasks = $taskModel->where('task_status_id', $taskStatusID)->find();

        if (!empty($tasks)) {
            return $this->handleResponse(['errors' => 'Trạng thái đang chứa công việc, không thể xoá!'], 400);
        }

        try {
            $taskStatusModel->delete($taskStatusID);
        } catch (Exception $e) {
            return $this->handleResponse(['errors' => $e->getMessage()], 400);
        }

        return $this->handleResponse([]);
    }
}
