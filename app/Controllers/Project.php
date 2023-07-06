<?php

namespace App\Controllers;

use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Project as ModelsProject;
use App\Models\ProjectUser;
use App\Models\RelationAttachment;
use App\Models\Section as ModelsSection;
use App\Models\Task as ModelsTask;
use App\Models\User;
use Carbon\Carbon;
use CodeIgniter\I18n\Time;
use Config\Services;
use Exception;

class Project extends BaseController
{

    public function list()
    {
        $projectModel = new ModelsProject();
        $now          = Carbon::now('Asia/Ho_Chi_Minh');

        $name = $this->request->getGet('name');
        if ($name) {
            $projectModel->like('name', $name);
        }

        $filter = $this->request->getGet('dim');
        switch ($filter) {
            case 'today':
                $where = "updated_at BETWEEN '{$now->clone()->startOfDay()}' AND '{$now}'";
                $projectModel->where($where);
                break;

            case 'yesterday':
                $where = "updated_at BETWEEN '{$now->yesterday()}' AND '{$now->yesterday()->endOfDay()}'";
                $projectModel->where($where);
                break;

            case 'this_week':
                $where = "updated_at BETWEEN '{$now->clone()->startOfWeek()}' AND '{$now}'";
                $projectModel->where($where);
                break;

            case 'this_month':
                $where = "updated_at BETWEEN '{$now->clone()->startOfMonth()}' AND '{$now}'";
                $projectModel->where($where);
                break;

            case 'this_year':
                $where = "updated_at BETWEEN '{$now->clone()->startOfYear()}' AND '{$now}'";
                $projectModel->where($where);
                break;

            default:
                break;
        }

        $sort = $this->request->getGet('sort');
        switch ($sort) {
            case 'oldest':
                $projectModel->orderBy('updated_at', 'ASC');
                break;

            default:
                $projectModel->orderBy('updated_at', 'DESC');
                break;
        }

        $limit = $this->request->getGet('limit');
        switch ($limit) {
            case 25:
                $projectModel->limit(25);
                break;

            case 50:
                $projectModel->limit(50);
                break;

            case 100:
                $projectModel->limit(100);
                break;

            default:
                $limit = 10;
                $projectModel->limit(10);
                break;
        }

        $projects = $projectModel->where('owner', session()->get('user_id'))->paginate($limit);
        foreach ($projects as $key => $project) {
            $time                         = new Time($project['updated_at']);
            $projects[$key]['updated_at'] = $time->humanize();
        }

        $data['projects'] = $projects;
        if (10 <= count($projects)) {
            $data['pager'] = $projectModel->pager;
        }

        $data['name']  = $name;
        $data['dim']   = $filter;
        $data['sort']  = $sort;
        $data['limit'] = $limit;
        $data['title'] = 'Danh sách dự án';
        return view('Project/List', $data);
    }

    public function detail()
    {
        $segment = $this->request->getUri()->getSegments();
        array_shift($segment); //remove segment 0 (project), we don't need it

        $projectID = $segment[0];
        $view = $segment[1] ?? null;

        $allowedView = [
            'user',
            'setting'
        ];

        if (!is_numeric($projectID)) {
            $data['backLink']   = '/project';
            return view('Error/NotFound', $data);
        }

        if (!empty($view) && !in_array($view, $allowedView)) {
            $data['backLink']   = '/project//' . $projectID;
            return view('Error/NotFound', $data);
        }

        $projectModel     = new ModelsProject();
        $projectUserModel = new ProjectUser();

        $project     = $projectModel->find($projectID);
        if (!$project) {
            $data['backLink']   = '/project//' . $projectID;
            return view('Error/NotFound', $data);
        }

        $projectUser   = $projectUserModel->select('user_id')->where('project_id', $projectID)->find();
        $projectUserID = collect($projectUser)->pluck('user_id')->toArray();

        $userID = session()->get('user_id');

        if ($project['owner'] != $userID) {
            if (!in_array($userID, $projectUserID)) {
                $data['backLink']   = '/project';
                return view('Error/Forbidden', $data);
            }
        }

        $view ??= 'Index';

        switch (ucfirst($view)) {
            case 'Index':
                $taskModel    = new ModelsTask();
                $sectionModel = new ModelsSection();
                $sections = $sectionModel->where('section.project_id', $projectID)->findAll();

                foreach ($sections as $key => $section) {
                    $sections[$key]['tasks'] = $taskModel->where('task.section_id', $section['id'])->findAll();
                }
                $data['sections'] = collect($sections)->sortBy('position')->toArray();

                $assignees = $projectUserModel->select([
                    'user.id as user_id',
                    'COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as name',
                ])->join('user', 'user.id = project_user.user_id')
                    ->where('project_user.project_id', $projectID)
                    ->where('project_user.user_id !=', session()->get('user_id'))
                    ->find();
                $data['assignees'] = $assignees;

                break;

            case 'Setting':
            case 'User':
                $members = $projectUserModel->select([
                    'user.id as user_id',
                    'COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as username',
                    'email',
                    'photo',
                    'role'
                ])->join('user', 'user.id = project_user.user_id')
                    ->where('project_user.project_id', $projectID)
                    ->find();
                $data['members'] = $members;

                break;

            default:
                $data['backLink']   = '/project';
                return view('Error/NotFound', $data);
        }


        $data['project'] = $project;
        $data['title']   = $project['name'];

        return view('Project/' . ucfirst($view), $data);
    }

    public function create()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'project_name'         => 'required|string|min_length[5]|max_length[255]|is_unique[project.name]',
                'project_key'          => 'required|string|min_length[1]|max_length[10]|is_unique[project.key]',
                'project_descriptions' => 'string|max_length[512]',
            ],
            customValidationErrorMessage()
        );

        if (!$validation->run($this->request->getPost())) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $projectName         = $this->request->getPost('project_name');
        $projectKey          = $this->request->getPost('project_key');
        $projectDescriptions = $this->request->getPost('project_descriptions');


        $owner = session()->get('user_id');
        $img   = makeImage(strtoUpper($projectName[0]));

        $data = [
            'name'         => $projectName,
            'key'          => $projectKey,
            'descriptions' => $projectDescriptions,
            'owner'        => $owner,
            'photo'        => $img
        ];

        $projectModel = new ModelsProject();
        $projectID    = $projectModel->insert($data);
        unset($data);

        $projectUserModel = new ProjectUser();
        $data = [
            'project_id' => $projectID,
            'user_id' => session()->get('user_id'),
            'role' => 'leader'
        ];
        $projectUserModel->insert($data);
        unset($data);

        $data = collect([
            [
                'project_id' => $projectID,
                'title' => 'Khởi tạo',
                'position' => 0,
                'base_section' => 1
            ],
            [
                'project_id' => $projectID,
                'title' => 'Đang thực hiện',
                'position' => 1,
                'base_section' => 2
            ],
            [
                'project_id' => $projectID,
                'title' => 'Hoàn thành',
                'position' => 2,
                'base_section' => 3
            ],
        ]);

        $sectionModel = new ModelsSection();
        $data->each(function ($item) use ($sectionModel) {
            $sectionModel->insert($item);
        });

        $result = ['project_id' => $projectID];
        return $this->handleResponse($result);
    }

    public function delete()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'project'   => 'required|integer|is_not_unique[project.id]',
                'password' => 'required|string|min_length[1]|max_length[255]',
            ],
            customValidationErrorMessage()
        );

        if (!$validation->run($this->request->getPost())) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $projectID = $this->request->getPost('project');
        $userModel = new User();

        $user = $userModel->find(session()->get('user_id'));
        $md5Password = md5((string)$this->request->getPost('password'));

        if ($user['password'] !== $md5Password) {
            return $this->handleResponse(['errors' => 'Mật khẩu không chính xác'], 400);
        }


        $projectUserModel = new ProjectUser();
        $projectModel     = new ModelsProject();
        $sectionModel     = new ModelsSection();
        $taskModel        = new ModelsTask();
        $commentModel     = new Comment();
        $attachmentModel  = new Attachment();
        $relationAttachmentModel  = new RelationAttachment();

        try {

            $projectUsers = $projectUserModel->select('id')->where('project_id', $projectID)->find();
            $projectUserIds = collect($projectUsers)->pluck('id')->toArray();
            //Delete member
            $projectUserModel->delete($projectUserIds);

            $sections   = $sectionModel->select('id')->where('project_id', $projectID)->find();
            $sectionIds = collect($sections)->pluck('id')->toArray();

            $tasks = $taskModel->select('id')->whereIn('section_id', $sectionIds)->find();
            $taskIds = collect($tasks)->pluck('id')->toArray();
            if (!empty($taskIds)) {

                $attachmentTasks = $attachmentModel->select([
                    'attachment.id as attachment_id',
                    'attachment.name',
                    'relation_attachment.id as relation_attachment_id'
                ])->join('relation_attachment', 'relation_attachment.attachment_id = attachment.id')
                    ->join('task', 'task.id = relation_attachment.relation_id')
                    ->where('relation_attachment.relation_type', 'task')
                    ->whereIn('relation_attachment.relation_id', $taskIds)->find();

                $attachmentTaskIds         = collect($attachmentTasks)->pluck('attachment_id')->toArray();
                $relationAttachmentTaskIds = collect($attachmentTasks)->pluck('relation_attachment_id')->toArray();
                if (!empty($attachmentTaskIds)) {
                    $relationAttachmentModel->delete($relationAttachmentTaskIds);
                    $attachmentModel->delete($attachmentTaskIds);
                }

                $comments = $commentModel->select('id')->whereIn('task_id', $taskIds)->find();
                $commentIds = collect($comments)->pluck('id')->toArray();
                if (empty($commentIds)) {
                    return $this->handleResponse([]);
                }

                $attachmentComments = $attachmentModel->select([
                    'attachment.id as attachment_id',
                    'attachment.name',
                    'relation_attachment.id as relation_attachment_id'
                ])->join('relation_attachment', 'relation_attachment.attachment_id = attachment.id')
                    ->join('comment', 'comment.id = relation_attachment.relation_id')
                    ->where('relation_attachment.relation_type', 'comment')
                    ->whereIn('relation_attachment.relation_id', $commentIds)->find();

                $attachmentCommentIds         = collect($attachmentComments)->pluck('attachment_id')->toArray();
                $relationAttachmentCommentIds = collect($attachmentComments)->pluck('relation_attachment_id')->toArray();
                if (!empty($attachmentCommentIds)) {
                    $relationAttachmentModel->delete($relationAttachmentCommentIds);
                    $attachmentModel->delete($attachmentCommentIds);
                }
                $commentModel->delete($commentIds);
                $taskModel->delete($taskIds);
            }

            $sectionModel->delete($sectionIds);
            $projectModel->delete($projectID);
            return $this->handleResponse([]);
        } catch (Exception $e) {
            return $this->handleResponse(['errors' => $e->getMessage()], 500);
        }
    }

    public function addUser()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'project_id' => 'required|integer|is_not_unique[project.id]',
                'user_id'    => 'required|integer|is_not_unique[user.id]',
            ],
            customValidationErrorMessage()
        );

        $projectID = ($this->request->getPost('project_id'));
        $userID = ($this->request->getPost('user_id'));

        if (!$validation->run($this->request->getPost())) {
            return redirectWithMessage(base_url('project/') . $projectID . '/user', $validation->getErrors());
        }

        $projectUserModel = new ProjectUser();
        $data = [
            'user_id' => $userID,
            'project_id' => $projectID,
        ];

        $projectUser = $projectUserModel->where($data)->find();

        if ($projectUser) {
            return redirectWithMessage(base_url('project/') . $projectID . '/user', 'Người dùng đã tham gia dự án');
        }

        $data['role'] = 'member';
        $projectUserModel->insert($data);

        return redirectWithMessage(base_url('project/') . $projectID . '/user', 'success', 'success', FALSE);
    }

    public function findUser()
    {
        $email = $this->request->getPost('email');

        $userModel = new User();
        $user      = $userModel->select(['id', 'email as text'])->like('email', $email)->find();

        return $this->handleResponse(json_encode($user));
    }

    public function task()
    {
        $segment = $this->request->getUri()->getSegments();
        array_shift($segment); //remove segment 0 (project), we don't need it
        $projectID    = $segment[0];

        $projectModel = new ModelsProject();
        $project      = $projectModel->find($projectID);
        if (empty($project)) {
            $data['backLink']   = '/project//';
            return view('Error/NotFound', $data);
        }

        $taskModel = new ModelsTask();
        $task      = $taskModel->find($segment[2]);
        if (empty($task)) {
            $data['backLink']   = '/project//' . $projectID;
            return view('Error/NotFound', $data);
        }

        $task['start_at'] = $task['start_at'] ? Carbon::createFromDate($task['start_at'])->format('Y-m-d') : NULL;
        $task['due_at']   = $task['due_at']   ? Carbon::createFromDate($task['due_at'])->format('Y-m-d')   : NULL;
        
        $assigneeID         = $task['assignee'];
        $task['assigneeID'] = $assigneeID; 

        // Get current assignee name
        $userModel = new User();
        if ($assigneeID) { 
            $task['assignee'] = $userModel->select('COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as username')
                ->find($assigneeID)['username'];
        }

        // Get all assignees
        $projectUserModel = new ProjectUser();
        $assignees = $projectUserModel->select([
            'user.id as user_id',
            'COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as name',
        ])->join('user', 'user.id = project_user.user_id')
            ->where('project_user.project_id', $projectID)
            ->where('project_user.user_id !=', session()->get('user_id'))
            ->find();
        $data['assignees'] = $assignees;

        // Get all sections
        $sectionModel = new ModelsSection();
        $sections = $sectionModel->where('section.project_id', $projectID)->findAll();

        $data['project']  = $project;
        $data['task']     = $task;
        $data['sections'] = $sections;
        $data['title']    = 'Chi tiết công việc';
        return view('Task/Detail', $data);
    }

    public function setting()
    {
        $data['title']   = 'Cài đặt';
        return view('Project/Setting', $data);
    }

    public function saveSetting()
    {
        $projectID = $this->request->getPost('id');

        $validation = service('validation');
        $validation->setRules(
            [
                'id'           => 'required|integer|is_not_unique[project.id]',
                'name'         => 'required|string|min_length[5]|max_length[255]',
                'owner'        => 'required|is_not_unique[user.id]',
                'descriptions' => 'string|max_length[512]',
            ],
            customValidationErrorMessage()
        );

        if (!$validation->run($this->request->getPost())) {
            return redirectWithMessage(base_url('project/') . $projectID . '/setting', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'descriptions' => $this->request->getPost('descriptions'),
            'owner' => $this->request->getPost('owner'),
        ];

        $projectModel = new ModelsProject();

        $projectModel->update($projectID, $data);

        return redirectWithMessage(base_url('project/') . $projectID . '/setting', 'success', 'success', FALSE);
    }

    public function upload()
    {
        $projectID = $this->request->getUri()->getSegment(2);
        $avatar = $this->request->getFile('project_avatar');

        if (!$avatar->isValid() || $avatar->hasMoved()) {
            return false;
        }
        $newName = $avatar->getRandomName();
        $fileName = $newName;
        $avatar->move(UPLOAD_PATH, $newName);

        $projectModel = new ModelsProject();
        $project      = $projectModel->find($projectID);

        $cache = Services::cache();
        $cache->save('old-project-avatar', $project['photo'], 600);

        // @unlink(UPLOAD_PATH . $user['photo']);

        $projectModel->update($projectID, ['photo' => $fileName]);

        return $this->handleResponse($fileName);
    }

    public function cancelUpload()
    {
        $projectID = $this->request->getUri()->getSegment(2);

        $cache = Services::cache();
        $old_avatar = $cache->get('old-project-avatar');
        if (!$old_avatar) {
            return $this->handleResponse();
        }
        session()->set('avatar', $old_avatar);

        $projectModel = new ModelsProject();
        // $img = $projectModel->find($projectID)['photo'];
        // @unlink(UPLOAD_PATH . $img);
        $projectModel->update($projectID, ['photo' => $old_avatar]);

        return $this->handleResponse();
    }

    public function remove()
    {
        // $fileName = $this->request->getPost('file_name');
        // @unlink(UPLOAD_PATH . $fileName);
        return $this->handleResponse('success');
    }
}
