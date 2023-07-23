<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User as ModelsUser;
use CodeIgniter\Config\Services;
use Exception;

class User extends BaseController
{
    public function index()
    {

        $userModel = new ModelsUser();
        $user      = $userModel->find(session()->get('user_id'));
        $data['user'] = $user;

        $data['notifications'] = $this->notifications;
        $data['totalNotification'] = count($this->notifications);

        $data['title']   = 'Thông tin cá nhân';
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
            $displayName = $user['username'];
            if ($user['firstname'] && $user['lastname']) {
                $displayName = $user['firstname'] . ' ' .  $user['lastname'];
            }
            session()->set('name', $displayName);
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
        // $img = $userModel->find(session()->get('user_id'))['photo'];
        // @unlink(UPLOAD_PATH . $img);
        $userModel->update(session()->get('user_id'), ['photo' => $old_avatar]);

        return $this->handleResponse();
    }

    public function remove()
    {
        // $fileName = $this->request->getPost('file_name');
        // @unlink(UPLOAD_PATH . $fileName);
        return $this->handleResponse();
    }

    public function listUser()
    {
        if (ADMIN != session()->get('type')) {
            return redirect()->to('/');
        }

        $userModel = new ModelsUser();
        $users = $userModel->paginate(10);

        $projectModel = new Project();
        $taskModel = new Task();
        foreach ($users as $key => $user) {
            $users[$key]['projects'] = $projectModel->select([
                'project.id',
                'project.name',
                'project.descriptions',
                'project.prefix',
                'project.photo'
            ])->join('project_user', 'project.id = project_user.project_id')
                ->where('project_user.user_id', $user['id'])->find();

            $projectIds = collect($users[$key]['projects'])->pluck('id')->toArray();
            $projectIds = implode(',', $projectIds);

            $customWhere = "project.id IN ({$projectIds})";

            if ($projectIds) {
                $taskModel->where($customWhere);
            }
            
            $tasks = $taskModel->select('task.id')
                ->join('task_status', 'task_status.id = task.task_status_id')
                ->join('project', 'project.id = task_status.project_id')
                ->where('assignee', $user['id'])
                ->where('task_status.base_status <>', 3)
                ->find();

            $users[$key]['totalProject'] = count($users[$key]['projects']);
            $users[$key]['totalTask'] = count($tasks);
        }

        $data['pager'] = $userModel->pager;

        $data['users'] = $users;
        $data['title'] = 'Danh sách thành viên';
        return view('User/ListUser', $data);
    }

    public function grantModRole()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'user_id' => 'required|string|is_not_unique[user.id]',
            ],
            customValidationErrorMessage()
        );

        if (!$validation->run($this->request->getPost())) {
            return redirectWithMessage(site_url('auth/register'), $validation->getErrors());
        }

        $userModel = new ModelsUser();

        $userModel->update($this->request->getPost('user_id'), ['type' => MODERATOR]);

        return $this->handleResponse();
    }

    public function revokeModRole()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'user_id' => 'required|string|is_not_unique[user.id]',
            ],
            customValidationErrorMessage()
        );

        if (!$validation->run($this->request->getPost())) {
            return redirectWithMessage(site_url('auth/register'), $validation->getErrors());
        }

        $userModel = new ModelsUser();

        $userModel->update($this->request->getPost('user_id'), ['type' => USER]);

        return $this->handleResponse();
    }

    public function createAndAddToProject()
    {
        $userData = $this->request->getPost();

        $validation = service('validation');
        $validation->setRules(
            [
                'username'       => 'required|string|min_length[3]|max_length[100]|is_unique[user.username]',
                'email'       => 'required|string|is_unique[user.email]',
                'password'       => 'required|string|min_length[4]|max_length[50]',
                're_password' => 'required|string|min_length[4]|matches[password]',
                'firstname'   => 'string|max_length[100]',
                'lastname'       => 'string|max_length[100]',
                'project_id'  => 'required|is_not_unique[project.id]'
            ],
            customValidationErrorMessage()
        );

        if (!$validation->run($userData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $data = [

            'username'  => $this->request->getPost('username'),
            'password'  => md5((string)$this->request->getPost('password')),
            'email'        => $this->request->getPost('email'),
            'firstname' => $this->request->getPost('firstname'),
            'lastname'  => $this->request->getPost('lastname'),
            'photo'        => makeImage(strtoUpper($this->request->getPost('username')[0])),
            'type'         => USER
        ];

        $userModel = new ModelsUser();
        $userID = $userModel->insert($data);

        $projectUserModel = new ProjectUser();
        $data = [
            'project_id' => $userData['project_id'],
            'user_id' => $userID,
            'role' => MEMBER
        ];
        $projectUserModel->insert($data);

        return $this->handleResponse([]);
    }
}
