<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User as ModelsUser;
use Exception;

class User extends BaseController
{
    public function index()
    {
        $userModel = new ModelsUser();
        $user      = $userModel->find(session()->get('user_id'));
        $data['user'] = $user;
        return view('User/Profile', $data);
    }

    public function update()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'old_password' => 'string|max_length[50]',
                'new_password' => 'string|max_length[50]',
                'firstname'    => 'string|max_length[100]',
                'lastname'     => 'string|max_length[100]'
            ],
            customValidationErrorMessage()
        );

        if (!$validation->run($this->request->getPost())) {
            return redirectWithMessage(site_url('user'), $validation->getErrors());
        }

        $userModel = new ModelsUser();
        $user      = $userModel->find(session()->get('user_id'));

        $firstname = $this->request->getPost('firstname');
        if ($firstname) {
            $user['firstname'] = $this->request->getPost('firstname');
        }

        $lastname = $this->request->getPost('lastname');
        if ($lastname) {
            $user['lastname']  = $this->request->getPost('lastname');
        }

        if ($this->request->getPost('new_password')) {
            $_password = md5((string)$this->request->getPost('old_password'));

            if ($user['password'] !== $_password) {
                return redirectWithMessage(site_url('user'), 'Mật khẩu không chính xác');
            }

            $user['password'] = md5((string)$this->request->getPost('new_password'));
        }

        try {
            $userModel->save($user);
        } catch (Exception $e) {
            return redirectWithMessage(site_url('user'), $e->getMessage());
        }
        return redirectWithMessage(site_url('user'), 'success', 'success', FALSE);
    }
}
