<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Task as ModelsTask;

class Task extends BaseController
{
    public function index()
    {
        //
    }

    public function create()
    {
        $taskRawData = $this->request->getPost();
        $validation = service('validation');

        $rule = [
            'task_name'         => 'required|string|min_length[5]|max_length[512]',
            'choose_section'    => 'required|integer|is_not_unique[section.id]',
            'task_descriptions' => 'string',
        ];
        if ($taskRawData['assignee']) {
            $rule['assignee']  = 'is_not_unique[user.id]';
        }

        $validation->setRules(
            $rule,
            customValidationErrorMessage()
        );

        if (!$validation->run($taskRawData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $data = [
            'section_id'    => $taskRawData['choose_section'],
            'title'         => $taskRawData['task_name'],
            'descriptions'  => $taskRawData['task_descriptions'],
            'priority'      => 'normal',
            'created_by'    => session()->get('user_id'),
        ];

        if ($taskRawData['assignee'])
        {
            $data['assignee'] = $taskRawData['assignee'];
        }

        $taskModel = new ModelsTask();
        $taskID = $taskModel->insert($data);

        return $this->handleResponse(['task_id' => $taskID]);
    }
    public function delete()
    {
        $taskID = $this->request->getPost('task_id');

        //comment

        //attachment

        $taskModel = new ModelsTask();
        $taskModel->delete($taskID);
        return $this->handleResponse();
    }

}
