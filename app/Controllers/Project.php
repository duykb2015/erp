<?php

namespace App\Controllers;

use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Notification as ModelsNotification;
use App\Models\Project as ModelsProject;
use App\Models\ProjectLog;
use App\Models\ProjectUser;
use App\Models\Task as ModelsTask;
use App\Models\TaskAttachment;
use App\Models\TaskStatus;
use App\Models\User;
use Carbon\Carbon;
use CodeIgniter\I18n\Time;
use Config\Services;
use Exception;
use Notification;

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

        $status = $this->request->getGet('status');
        switch ($status) {
            case ACTIVE:
                $projectModel->where('status', ACTIVE);
                break;

            case INITIALIZE:
                $projectModel->where('status', INITIALIZE);
                break;

            case CLOSE:
                $projectModel->where('status', CLOSE)->withDeleted();
                break;

            default:
                $projectModel->whereIn('status', array_keys(PROJECT_STATUS))->withDeleted();
                break;
        }

        $projects = $projectModel->select([
            'project.id',
            'project.name',
            'project.prefix',
            'project.owner',
            'project.descriptions',
            'project.photo',
            'project.status',
            'project.created_at',
            'project.updated_at',
        ])
            ->join('project_user', 'project_user.project_id = project.id')
            ->where('project_user.user_id', session()->get('user_id'))
            // ->withDeleted()
            ->paginate($limit);

        $userModel = new User();
        $taskModel = new ModelsTask();

        foreach ($projects as $key => $project) {
            $time                         = new Time($project['updated_at']);
            $projects[$key]['updated_at'] = $time->humanize();
            $users = $userModel->select([
                'user.id',
                'COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as username',
                'user.email',
                'user.photo',
                'project_user.role'
            ])->join('project_user', 'project_user.user_id = user.id')
                ->where('project_user.project_id', $project['id'])->find();

            $tasks = $taskModel->select('task.id')
                ->join('task_status', 'task_status.id = task.task_status_id')
                ->join('project', 'project.id = task_status.project_id')
                ->where('project.id', $project['id'])->find();

            $projects[$key]['totalUser'] = count($users);
            $projects[$key]['totalTask'] = count($tasks);
            $projects[$key]['users'] = $users;
        }

        $data['projects'] = $projects;
        $data['pager'] = $projectModel->pager;

        foreach ($this->notifications as $key => $notify) {
            $this->notifications[$key]['created_at'] = (new Time($notify['created_at']))->humanize();
        }

        $data['notifications'] = $this->notifications;
        $data['totalNotification'] = count($this->notifications);

        $data['name']  = $name;
        $data['dim']   = $filter;
        $data['sort']  = $sort;
        $data['limit'] = $limit;
        $data['status'] = $status;
        $data['title'] = 'Danh sách dự án';
        return view('Project/List', $data);
    }

    public function detail()
    {
        $segment = $this->request->getUri()->getSegments();
        array_shift($segment); //remove segment 0 (project), we don't need it

        $projectPrefix = $segment[0];
        $view = $segment[1] ?? null;

        $allowedView = [
            'user',
            'setting',
            'log',
            'statistic'
        ];

        if (!empty($view) && !in_array($view, $allowedView)) {
            $data['backLink']   = "/project/{$projectPrefix}";
            return view('Error/NotFound', $data);
        }

        $projectModel     = new ModelsProject();
        $projectUserModel = new ProjectUser();

        $project = $projectModel->where('prefix', $projectPrefix)->first();
        if (!$project) {
            $data['backLink'] = '/project';
            return view('Error/NotFound', $data);
        }

        $projectUser = $projectUserModel->select([
            'user_id',
            'COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as name',
            'role'
        ])
            ->join('user', 'user.id = project_user.user_id')
            ->where('project_id', $project['id'])->find();
        $projectUserID = collect($projectUser)->pluck('user_id')->toArray();

        $data['projectUser'] = collect($projectUser)->filter(function ($item) {
            if (session()->get('user_id') == $item['user_id']) {
                return FALSE;
            }
            return $item;
        });

        $userID = session()->get('user_id');

        if ($project['owner'] != $userID) {
            if (!in_array($userID, $projectUserID)) {
                $data['backLink']   = '/project';
                return view('Error/Forbidden', $data);
            }
        }

        $userRole = collect($projectUser)->where('user_id', session()->get('user_id'))->first()['role'];

        $view ??= 'Index';

        $taskModel = new ModelsTask();
        switch (ucfirst($view)) {
            case 'Index':
                $taskStatusModel = new TaskStatus();
                $taskStatus = $taskStatusModel->where('task_status.project_id', $project['id'])->findAll();

                $filterUser = $this->request->getGet('user');
                $data['filterUser'] = $filterUser;

                foreach ($taskStatus as $key => $status) {
                    if (!empty($filterUser && is_numeric($filterUser))) {
                        $taskModel->where('task.assignee', $filterUser);
                    }
                    if ('unassigned' == $filterUser) {
                        $builderWhere = 'task.assignee IS NULL';
                        $taskModel->where($builderWhere);
                    }
                    $taskStatus[$key]['tasks'] = $taskModel->select(['*', 'task.id as id', 'COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as assignee_name', 'user.photo as user_photo'])
                        ->join('user', 'user.id = task.assignee', 'left')
                        ->where('parent_id = 0')
                        ->where('task.task_status_id', $status['id'])->findAll();
                    if (DONE != $status['base_status']) {
                        foreach ($taskStatus[$key]['tasks'] as $subKey => $task) {
                            if ($task['due_at']) {
                                $dueDate = Carbon::createFromDate($task['due_at']);
                                $dueDate->setLocale('vi');
                                $taskStatus[$key]['tasks'][$subKey]['due_at'] = $dueDate->diffForHumans();
                            }
                        }
                    }
                }
                $data['taskStatus'] = collect($taskStatus)->sortBy('position')->toArray();

                $whereRole = '"' . OWNER . '","' . LEADER . '"';
                $assignees = $projectUserModel->select([
                    'user.id as user_id',
                    'COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as name',
                ])->join('user', 'user.id = project_user.user_id')
                    ->where('project_user.project_id', $project['id'])
                    ->where('project_user.user_id !=', session()->get('user_id'))
                    ->where("project_user.role NOT IN({$whereRole})")
                    ->find();
                $data['assignees'] = $assignees;

                $reporters = $projectUserModel->select([
                    'user.id as user_id',
                    'COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as name',
                ])->join('user', 'user.id = project_user.user_id')
                    ->where('project_user.project_id', $project['id'])
                    ->where("project_user.role IN({$whereRole})")
                    ->find();
                $data['reporters'] = $reporters;

                break;

            case 'Setting':
                if (session()->get('user_id') != $project['owner']) {
                    $data['backLink']   = "/project/{$project['id']}";
                    return view('Error/Forbidden', $data);
                }
            case 'User':
                $members = $projectUserModel->select([
                    'project_user.id as project_user_id',
                    'user.id as user_id',
                    'COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as username',
                    'email',
                    'photo',
                    'role'
                ])->join('user', 'user.id = project_user.user_id')
                    ->where('project_user.project_id', $project['id'])
                    ->paginate(5);

                foreach ($members as $key => $member) {
                    if (session()->get('user_id') == $member['user_id']) continue;

                    $projectIDs = $projectUserModel->select('project_id as id')
                        ->where("user_id = ({$member['user_id']})")
                        ->groupBy('id')
                        ->find();

                    $projectIDs = collect($projectIDs)->filter(function ($id) use ($projectUserModel) {
                        $isJoinWith = $projectUserModel->where('project_id', $id)
                            ->where('user_id', session()->get('user_id'))
                            ->first();
                        if (!$isJoinWith) {
                            return FALSE;
                        }
                        return TRUE;
                    })->toArray();

                    $members[$key]['projects'] = $projectModel->find(collect($projectIDs)->pluck('id')->toArray());
                }

                $data['members'] = $members;

                $data['pager'] = $projectUserModel->pager;

                $data['owner'] = collect($members)->where('role', 'owner')->first();

                $project['start_at'] = explode(' ', $project['start_at'])[0];
                $project['due_at'] = explode(' ', $project['due_at'])[0];
                break;

            case 'Statistic':
                $taskStatusModel = new TaskStatus();
                $taskModel       = new ModelsTask();
                $taskStatus      = $taskStatusModel->where('project_id', $project['id'])->orderBy('position', 'ASC')->find();
                $statusDoneID    = NULL;

                $chartData['Trạng thái'] = 'Số lượng';

                foreach ($taskStatus as $key => $status) {
                    if (DONE == $status['base_status']) {
                        $statusDoneID = $status['id'];
                    }
                    $chartData[$status['title']] = $taskModel->select('COUNT(id) as count')
                        ->where('task_status_id', $status['id'])
                        ->first()['count'];
                }
                $data['chartData'] = json_encode($chartData);

                $teamStatistic = [];

                foreach ($projectUser as $user) {
                    $countDone = $taskModel->select('count(task.id) as total')
                        ->join('task_status', 'task_status.id = task.task_status_id')
                        ->join('project', 'project.id = task_status.project_id')
                        ->where('assignee', $user['user_id'])
                        ->where('task_status_id', $statusDoneID)
                        ->where('project.id', $project['id'])
                        ->first();

                    $countAll = $taskModel->select('count(task.id) as total')
                        ->join('task_status', 'task_status.id = task.task_status_id')
                        ->join('project', 'project.id = task_status.project_id')
                        ->where('assignee', $user['user_id'])
                        ->where('project.id', $project['id'])
                        ->first();

                    $percenComplete = 0;
                    if (0 != $countAll['total'] && 0 != $countDone['total']) {
                        $percenComplete = (float) number_format(($countDone['total'] / $countAll['total']) * 100, 2);
                    }

                    $teamStatistic[] = [
                        'name' => $user['name'],
                        'taskDone' => $countDone['total'],
                        'totalTask' => $countAll['total'],
                        'percentComplete' => $percenComplete
                    ];
                }

                $data['teamStatistic'] = $teamStatistic;
                break;

            case 'Log':
                $projectLog = (new ProjectLog())->where('project_id', $project['id'])->orderBy('id', 'DESC')->find();

                foreach ($projectLog as $key => $log) {
                    $time                           = new Time($log['created_at']);
                    $projectLog[$key]['created_at'] = $time->humanize();
                }

                $data['projectLog'] = $projectLog;
                break;

            default:
                $data['backLink']   = '/project';
                return view('Error/NotFound', $data);
        }
        foreach ($this->notifications as $key => $notify) {
            $this->notifications[$key]['created_at'] = (new Time($notify['created_at']))->humanize();
        }

        $data['notifications'] = $this->notifications;
        $data['totalNotification'] = count($this->notifications);

        $data['userRole'] = $userRole;
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
                'project_prefix'       => 'required|string|min_length[1]|max_length[10]|is_unique[project.prefix]',
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
            'role' => OWNER
        ];
        $projectUserModel->insert($data);
        unset($data);

        $userName = session()->get('name');
        (new ProjectLog)->insert([
            'project_id' => $projectID,
            'log' => "<b>$userName</b> đã khởi tạo dự án."
        ]);

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
                'title' => 'Sẵn sàng xem xét',
                'position' => 2,
                'base_status' => 3
            ],
            [
                'project_id' => $projectID,
                'title' => 'Hoàn thành',
                'position' => 2,
                'base_status' => 4
            ],
        ]);

        $taskStatusModel = new TaskStatus();
        $data->each(function ($item) use ($taskStatusModel) {
            $taskStatusModel->insert($item);
        });

        $result = ['project_prefix' => $projectData['project_prefix']];
        return $this->handleResponse($result);
    }

    public function inviteUser()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'project_id'     => 'required|integer|is_not_unique[project.id]',
                'project_prefix' => 'required|string|is_not_unique[project.prefix]',
                'user_id'        => 'required|integer|is_not_unique[user.id]',
            ],
            customValidationErrorMessage()
        );

        $projectPrefix = ($this->request->getPost('project_prefix'));

        if (!$validation->run($this->request->getPost())) {
            return redirectWithMessage(base_url("project/{$projectPrefix}/user"), $validation->getErrors());
        }

        $projectID = ($this->request->getPost('project_id'));
        $userID = ($this->request->getPost('user_id'));

        $cache = Services::cache();
        if ($cache->get("isAlreadyInvite_{$userID}")) {
            return redirectWithMessage(base_url("project/{$projectPrefix}/user"), "Lời mời đã được gửi đi cho người dùng này!");
        }
        $cache->save("isAlreadyInvite_{$userID}", TRUE, 864000);

        $project = (new ModelsProject())->select('name')->find($projectID);

        $projectUserModel = new ProjectUser();
        $data = [
            'user_id' => $userID,
            'project_id' => $projectID,
        ];

        $projectUser = $projectUserModel->where($data)->find();

        if ($projectUser) {
            return redirectWithMessage(base_url("project/{$projectPrefix}/user"), 'Người dùng đã tham gia dự án');
        }

        $notificationModel = new ModelsNotification();

        $notificationID = $notificationModel->insert([
            'title' => session()->get('name'),
            'message' => '',
            'sender_id' => session()->get('user_id'),
            'recipient_id' => $userID,
            'is_read' => FALSE
        ]);

        $data = [
            'project_id' => $projectID,
            'project_name' => $project['name'],
            'user_id' => $userID
        ];

        $notificationModel->update($notificationID, [
            'message' => Notification::inviteRequest(session()->get('name'), $data, $notificationID)
        ]);

        $cache = Services::cache();
        $cache->save('userSendInvite', session()->get('name'), 864000);

        return redirectWithMessage(base_url("project/{$projectPrefix}/user"), 'Đã gửi lời mời tới người dùng!', 'success', FALSE);
    }

    public function addUser()
    {
        $projectID = $this->request->getPost('project_id');
        $userID    = $this->request->getPost('user_id');

        $project = (new ModelsProject())->select('prefix')->find($projectID);

        $projectUserModel = new ProjectUser();

        $data = [
            'user_id' => $userID,
            'project_id' => $projectID,
        ];

        $projectUser = $projectUserModel->where($data)->find();
        if ($projectUser) {
            return $this->handleResponse(['errors' => 'Bạn đã tham gia dự án này!'], 400);
        }

        $data['role'] = MEMBER;
        $projectUserModel->insert($data);

        $member = (new User)->select('COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as name')
            ->find($userID);

        $cache = Services::cache();
        $userName = $cache->get('userSendInvite');

        $cache->delete('userSendInvite');
        $cache->delete("isAlreadyInvite_{$userID}");

        (new ProjectLog)->insert([
            'project_id' => $projectID,
            'log' => "<b>{$userName}</b> đã thêm <b>{$member['name']}</b> vào dự án."
        ]);

        return $this->handleResponse(['link' => base_url("project/{$project['prefix']}")]);
    }

    public function removeUser()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'project_user_id' => 'required|integer|is_not_unique[project_user.id]',
            ],
            customValidationErrorMessage()
        );

        if (!$validation->run($this->request->getPost())) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $type = $this->request->getPost('type');

        $projectUserID = $this->request->getPost('project_user_id');

        $projectUserModel = new ProjectUser();
        $projectUser = $projectUserModel->find($projectUserID);

        $taskModel = new ModelsTask();
        $tasks = $taskModel->join('task_status', 'task_status.id = task.task_status_id')
            ->join('project', 'project.id = task_status.project_id')
            ->where('task.assignee', $projectUser['user_id'])
            ->where('project.id', $projectUser['project_id'])
            ->find();

        if ($tasks) {
            return $this->handleResponse(['errors' => 'Thành viên đang có công việc chưa hoàn thành!']);
        }

        $projectUserModel->delete($projectUserID);

        $member = (new User)->select('COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as name')
            ->find($projectUser['user_id']);

        if ($type == 1) {
            $userName = session()->get('name');
            (new ProjectLog)->insert([
                'project_id' => $projectUser['project_id'],
                'log' => "<b>{$userName}</b> đã rời khỏi dự án."
            ]);
            return $this->handleResponse([]);
        }
        $userName = session()->get('name');
        (new ProjectLog)->insert([
            'project_id' => $projectUser['project_id'],
            'log' => "<b>{$userName}</b> đã xoá {$member['name']} khỏi dự án."
        ]);

        return $this->handleResponse([]);
    }

    public function findUser()
    {
        $email = $this->request->getPost('email');
        $project = $this->request->getPost('project');

        $projectUserModel = new ProjectUser();
        $userIDs = $projectUserModel->select('user_id')
            ->where('project_id', $project)
            ->find();

        $pluckIds = collect($userIDs)->pluck('user_id')->toArray();

        $userModel = new User();
        $user      = $userModel->select(['id', 'email as text'])
            ->like('email', $email)
            ->whereNotIn('id', $pluckIds)
            ->find();

        return $this->handleResponse(json_encode($user));
    }

    // public function setting()
    // {
    //     $data['title']   = 'Cài đặt';
    //     return view('Project/Setting', $data);
    // }

    public function saveSetting()
    {
        $projectID = $this->request->getPost('id');
        $projectPrefix = $this->request->getPost('prefix');

        $projectData = $this->request->getPost();

        $validation = service('validation');
        $validation->setRules(
            [
                'id'           => 'required|integer|is_not_unique[project.id]',
                'prefix'       => 'required|string|is_not_unique[project.prefix]',
                'name'         => 'required|string|min_length[5]|max_length[255]',
                'descriptions' => 'string|max_length[512]',
                'status'       => 'required|string'
            ],
            customValidationErrorMessage()
        );

        if ($projectData['start_at']) {
            $rule['project_start_date']  = 'valid_date';
        }

        if ($projectData['due_at']) {
            $rule['project_due_date']  = 'valid_date';
        }

        if (!$validation->run($projectData)) {
            return redirectWithMessage(base_url("project/{$projectPrefix}/setting"), $validation->getErrors());
        }

        $startDate = NULL;
        $dueDate   = NULL;

        $dateStartPoint = Carbon::now()->subYear();
        $dateEndPoint = Carbon::createFromDate(2100, 01, 01);

        if ($projectData['start_at']) {
            $startDate = Carbon::createFromFormat('Y-m-d', $projectData['start_at'])->startOfDay();

            if ($startDate->lt($dateStartPoint) || $startDate->gt($dateEndPoint)) {
                return redirectWithMessage(base_url("project/{$projectPrefix}/setting"), 'Vui lòng chọn một ngày bắt đầu hợp lệ');
            }
        }

        if ($projectData['due_at']) {
            $dueDate = Carbon::createFromFormat('Y-m-d', $projectData['due_at'])->endOfDay();

            if ($dueDate->gt($dateEndPoint)) {
                return redirectWithMessage(base_url("project/{$projectPrefix}/setting"), 'Vui lòng chọn một kết thúc hợp lệ');
            }
        }

        if ($startDate && $dueDate) {
            if ($dueDate->lt($startDate) || $dueDate->lt(Carbon::now())) {
                return redirectWithMessage(base_url("project/{$projectPrefix}/setting"), 'Ngày kết thúc phải lớn hơn hiện tại hoặc ngày bắt đầu');
            }
        }

        $data = [
            'name'         => $projectData['name'],
            'descriptions' => $projectData['descriptions'],
        ];

        if ($startDate) {
            $data['status'] = $projectData['status'];
        }

        if ($startDate) {
            $data['start_at'] = $startDate->format('Y-m-d H:i:s');
        }

        if ($dueDate) {
            $data['due_at'] = $dueDate->format('Y-m-d H:i:s');
        }

        $projectModel = new ModelsProject();

        $projectModel->update($projectID, $data);

        $userName = session()->get('name');
        (new ProjectLog)->insert([
            'project_id' => $projectID,
            'log' => "<b>{$userName}</b> cập nhật thông tin dự án."
        ]);

        return redirectWithMessage(base_url("project/{$projectPrefix}/setting"), 'success', 'success', FALSE);
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

        $userName = session()->get('name');
        (new ProjectLog)->insert([
            'project_id' => $projectID,
            'log' => "<b>{$userName}</b> đã thay đổi ảnh đại diện dự án."
        ]);

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

    public function delete()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'project'  => 'required|integer|is_not_unique[project.id]',
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

        $projectModel     = new ModelsProject();

        $projectUserModel = new ProjectUser();
        $taskStatusModel  = new TaskStatus();
        $taskModel        = new ModelsTask();
        $commentModel     = new Comment();
        $attachmentModel  = new Attachment();
        $relationAttachmentModel  = new TaskAttachment();

        try {

            $projectUsers = $projectUserModel->select('id')->where('project_id', $projectID)->find();
            $projectUserIds = collect($projectUsers)->pluck('id')->toArray();
            //Delete member
            if ($projectUserIds) {
                $projectUserModel->delete($projectUserIds);
            }

            $taskStatus   = $taskStatusModel->select('id')->where('project_id', $projectID)->find();
            $statusIds = collect($taskStatus)->pluck('id')->toArray();
            if ($statusIds) {
                $tasks = $taskModel->select('id')->whereIn('task_status_id', $statusIds)->find();

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
                    if (!empty($attachmentCommentIds)) {
                        $attachmentModel->delete($attachmentCommentIds);
                    }
                    $commentModel->delete($commentIds);
                    $taskModel->delete($taskIds);
                }
                $taskStatusModel->delete($statusIds);
            }

            $projectLog = (new ProjectLog())->where('project_id', $projectID)->find();
            if ($projectLog) {
                (new ProjectLog())->delete(collect($projectLog)->pluck('id')->toArray());
            }

            $projectModel->delete($projectID, true);
            return $this->handleResponse([]);
        } catch (Exception $e) {
            return $this->handleResponse(['errors' => $e->getMessage()], 500);
        }
    }

    public function changeRoleLeader()
    {
        $projectUserData = $this->request->getPost();

        $validation = service('validation');
        $validation->setRules(
            [
                'project_user_id' => 'required|integer|is_not_unique[project_user.id]',
                'project_id' => 'required|integer|is_not_unique[project.id]'
            ],
            customValidationErrorMessage()
        );

        if (!$validation->run($projectUserData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $projectUserModel = new ProjectUser();
        $projectUser = $projectUserModel->find($projectUserData['project_user_id']);

        $oldLeader = $projectUserModel->where('project_id', $projectUserData['project_id'])
            ->where('role', LEADER)->find();
        if ($oldLeader) {
            $projectUserModel->update(collect($oldLeader)->pluck('id')->toArray(), ['role' => MEMBER]);
        }

        $projectUserModel->update($projectUserData['project_user_id'], ['role' => LEADER]);

        $member = (new User)->select('COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as name')
            ->find($projectUser['user_id']);

        $userName = session()->get('name');
        (new ProjectLog)->insert([
            'project_id' => $projectUserData['project_id'],
            'log' => "<b>{$userName}</b> cấp quyền cho <b>{$member['name']}</b> làm trưởng nhóm."
        ]);

        return $this->handleResponse([]);
    }

    public function changeRoleMember()
    {
        $projectUserData = $this->request->getPost();

        $validation = service('validation');
        $validation->setRules(
            [
                'project_user_id' => 'required|integer|is_not_unique[project_user.id]',
            ],
            customValidationErrorMessage()
        );

        if (!$validation->run($projectUserData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $projectUserModel = new ProjectUser();
        $projectUser = $projectUserModel->find($projectUserData['project_user_id']);
        $projectUserModel->update($projectUserData['project_user_id'], ['role' => MEMBER]);

        $member = (new User)->select('COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as name')
            ->find($projectUser['user_id']);

        $userName = session()->get('name');
        (new ProjectLog)->insert([
            'project_id' => $projectUserData['project_id'],
            'log' => "<b>{$userName}</b> huỷ quyền trường nhóm của <b>{$member['name']}</b>."
        ]);

        return $this->handleResponse([]);
    }

    function activate()
    {
        $projectData = $this->request->getPost();

        $projectModel = new ModelsProject();
        $projectModel->withDeleted()->update($projectData['project_id'], [
            'status' => ACTIVE,
        ]);

        return $this->handleResponse([]);
    }

    function reOpen()
    {
        $projectData = $this->request->getPost();

        $projectModel = new ModelsProject();
        $projectModel->withDeleted()->update($projectData['project_id'], [
            'status' => ACTIVE,
            'deleted_at' => NULL
        ]);

        $userName = session()->get('name');
        (new ProjectLog)->insert([
            'project_id' => $projectData['project_id'],
            'log' => "<b>{$userName}</b> mở lại dự án."
        ]);

        return $this->handleResponse([]);
    }

    public function close()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'project_id'  => 'required|integer|is_not_unique[project.id]',
            ],
            customValidationErrorMessage()
        );

        if (!$validation->run($this->request->getPost())) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }
        $projectID = $this->request->getPost('project_id');

        $projectModel = new ModelsProject();
        $projectModel->update($projectID, ['status' => 'close']);
        $projectModel->delete($projectID);

        $userName = session()->get('name');
        (new ProjectLog)->insert([
            'project_id' => $projectID['project_id'],
            'log' => "<b>{$userName}</b> đóng dự án."
        ]);

        return $this->handleResponse([]);
    }
}
