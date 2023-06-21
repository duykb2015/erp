<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User as ModelsUser;
use CodeIgniter\Config\Services;
use Config\Cache;
use Exception;
use Illuminate\Support\Facades\Validator;

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

    public function upload()
    {

        $avatar = $this->request->getFile('user_avatar');

        if (!$avatar->isValid() || $avatar->hasMoved()) {
            return false;
        }
        $newName = $avatar->getRandomName();
        $fileName = $newName;
        $avatar->move(UPLOAD_PATH, $newName);

        session()->set('avatar', $fileName);

        $userModel = new ModelsUser();
        $user      = $userModel->find(session()->get('user_id'));

        $cache = Services::cache();
        $cache->save('old-avatar', $user['photo'], 600);

        // @unlink(UPLOAD_PATH . $user['photo']);

        $userModel->update(session()->get('user_id'), ['photo' => $fileName]);

        return $this->handleResponse($fileName);
    }

    public function cancelUpload()
    {
        // $img = $this->request->getPost('img');

        $cache = Services::cache();
        $old_avatar = $cache->get('old-avatar');
        session()->set('avatar', $old_avatar);

        $userModel = new ModelsUser();
        $userModel->update(session()->get('user_id'), ['photo' => $old_avatar]);

        return $this->handleResponse();
    }

    public function remove()
    {

        return $this->handleResponse();
    }
}
