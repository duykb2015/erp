<?php

namespace App\Controllers;

use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Project as ModelsProject;
use App\Models\ProjectUser;
use App\Models\RelationAttachment;
use App\Models\Task as ModelsTask;
use App\Models\TaskStatus;
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

        $projects = $projectModel->select([
            'project.id',
            'project.name',
            'project.prefix',
            'project.descriptions',
            'project.photo',
            'project.created_at',
            'project.updated_at',
        ])
            ->join('project_user', 'project_user.project_id = project.id')
            ->where('project_user.user_id', session()->get('user_id'))
            // ->withDeleted()
            ->paginate($limit);
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

        $taskModel = new ModelsTask();
        switch (ucfirst($view)) {
            case 'Index':
                $taskStatusModel = new TaskStatus();
                $taskStatus = $taskStatusModel->where('task_status.project_id', $projectID)->findAll();

                foreach ($taskStatus as $key => $status) {
                    $taskStatus[$key]['tasks'] = $taskModel->where('task.task_status_id', $status['id'])->findAll();
                }
                $data['taskStatus'] = collect($taskStatus)->sortBy('position')->toArray();

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

                $taskCount = $taskModel->select('COUNT(task.id) as number_of_task')
                    ->join('section', 'task_status.id = task.section_id')
                    ->join('project', 'project.id = task_status.project_id')
                    ->where('project.id', $projectID)
                    ->first();
                dd($taskCount);

                break;

            default:
                $data['backLink']   = '/project';
                return view('Error/NotFound', $data);
        }

        // $purgeDelete = true;
        // // if project containt task, cannot delete
        // if (!empty($taskCount) && 0 != $taskCount) {
        //     $purgeDelete = false;
        // }

        $data['project'] = $project;
        $data['title']   = $project['name'];

        return view('Project/' . ucfirst($view), $data);
    }

    public function create()
    {
        $projectData = $this->request->getPost();
        $validation = service('validation');
        $validation->setRules(
            [
                'project_name'         => 'required|string|min_length[5]|max_length[255]|is_unique[project.name]',
                'project_prefix'          => 'required|string|min_length[1]|max_length[10]|is_unique[project.prefix]',
                'project_descriptions' => 'string|max_length[512]',
                "project_status"       => 'in_list[' . implode(',', array_keys(PROJECT_STATUS)) . ']',
            ],
            customValidationErrorMessage()
        );

        if ($projectData['project_start_date']) {
            $rule['project_start_date']  = 'valid_date';
        }

        if ($projectData['project_due_date']) {
            $rule['project_due_date']  = 'valid_date';
        }

        if (!$validation->run($projectData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $startDate = NULL;
        $dueDate   = NULL;

        $dateStartPoint = Carbon::now()->subYear();
        $dateEndPoint = Carbon::createFromDate(2100, 01, 01);

        if ($projectData['project_start_date']) {
            $startDate = Carbon::createFromFormat('Y-m-d', $projectData['project_start_date'])->startOfDay();

            if ($startDate->lt($dateStartPoint) || $startDate->gt($dateEndPoint)) {
                return $this->handleResponse(['errors_datetime' => 'Vui lòng chọn một ngày bắt đầu hợp lệ'], 400);
            }
        }

        if ($projectData['project_due_date']) {
            $dueDate = Carbon::createFromFormat('Y-m-d', $projectData['project_due_date'])->endOfDay();

            if ($dueDate->gt($dateEndPoint)) {
                return $this->handleResponse(['errors_datetime' => 'Vui lòng chọn một kết thúc hợp lệ'], 400);
            }
        }

        if ($startDate && $dueDate) {
            if ($dueDate->lt($startDate) || $dueDate->lt(Carbon::now())) {
                return $this->handleResponse(['errors_datetime' => 'Ngày kết thúc phải lớn hơn hiện tại hoặc ngày bắt đầu'], 400);
            }
        }

        $owner = session()->get('user_id');
        $img   = makeImage(strtoUpper($projectData['project_name'][0]));

        $data = [
            'name'         => $projectData['project_name'],
            'prefix'       => $projectData['project_prefix'],
            'descriptions' => $projectData['project_descriptions'],
            'owner'        => $owner,
            'photo'        => $img,
            'status'       => $projectData['project_status']
        ];
        if ($startDate) {
            $data['start_at'] = $startDate->format('Y-m-d H:i:s');
        }

        if ($dueDate) {
            $data['due_at'] = $dueDate->format('Y-m-d H:i:s');
        }

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
                'base_status' => 1
            ],
            [
                'project_id' => $projectID,
                'title' => 'Đang thực hiện',
                'position' => 1,
                'base_status' => 2
            ],
            [
                'project_id' => $projectID,
                'title' => 'Hoàn thành',
                'position' => 2,
                'base_status' => 3
            ],
        ]);

        $taskStatusModel = new TaskStatus();
        $data->each(function ($item) use ($taskStatusModel) {
            $taskStatusModel->insert($item);
        });

        $result = ['project_id' => $projectID];
        return $this->handleResponse($result);
    }

    public function delete()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'project'  => 'required|integer|is_not_unique[project.id]',
                'password' => 'required|string|min_length[1]|max_length[255]',
                'purge_delete' => 'bool'
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

        $projectModel     = new ModelsProject();

        if (!$this->request->getPost('purge_delete')) {
            // Close project
            $projectModel->delete($projectID);
            return $this->handleResponse([]);
        }

        $projectUserModel = new ProjectUser();
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
