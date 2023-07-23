<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Comment as ModelsComment;

class Comment extends BaseController
{
    public function create()
    {
        $commentData = $this->request->getPost();
        $validation = service('validation');

        $rule = [
            'task_id' => 'required|integer|is_not_unique[task.id]',
            'comment' => 'required|string',
        ];

        $validation->setRules(
            $rule,
            customValidationErrorMessage()
        );

        if (!$validation->run($commentData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $data = [
            'task_id'    => $commentData['task_id'],
            'user_id' => session()->get('user_id'),
            'text'       => $commentData['comment'],
        ];

        $commentModel = new ModelsComment();

        $commentModel->insert($data);

        return $this->handleResponse([]);
    }

    public function update()
    {
        $commentData = $this->request->getPost();
        $validation = service('validation');

        $rule = [
            'comment_id' => 'required|integer|is_not_unique[comment.id]',
        ];

        $validation->setRules(
            $rule,
            customValidationErrorMessage()
        );

        if (!$validation->run($commentData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $data = [
            'id'    => $commentData['comment_id'],
            'text'  => $commentData['text'],
        ];

        $commentModel = new ModelsComment();

        $commentModel->save($data);

        return $this->handleResponse([]);
    }

    public function delete()
    {
        $commentData = $this->request->getPost();
        $validation = service('validation');

        $rule = [
            'comment_id' => 'required|is_not_unique[comment.id]'
        ];

        $validation->setRules(
            $rule,
            customValidationErrorMessage()
        );

        if (!$validation->run($commentData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $commentModel = new ModelsComment();

        $commentModel->delete($commentData['comment_id']);

        return $this->handleResponse([]);
    }
}
