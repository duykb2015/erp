<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Comment;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task as ModelsTask;
use App\Models\Section as ModelsSection;
use App\Models\User;
use Carbon\Carbon;
use CodeIgniter\I18n\Time;

class Task extends BaseController
{
    public function index()
    {
        $segment = $this->request->getUri()->getSegments();
        array_shift($segment); //remove segment 0 (project), we don't need it
        $projectID    = $segment[0];

        $projectModel = new Project();
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

        $commentModel = new Comment();

        $activities = $commentModel->select(['text', 'created_at'])
            ->where('task_id', $segment[2])
            ->where('type', SYSTEM_COMMENT_TYPE)
            ->orderBy('created_at', 'DESC')
            ->find();

        foreach ($activities as $key => $activity) {
            $time                           = new Time($activity['created_at']);
            $activities[$key]['created_at'] = $time->humanize();
        }

        $comments = $commentModel
            ->select([
                'comment.id',
                'COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as name',
                'user.photo',
                'created_by',
                'text',
                'created_at'
            ])
            ->join('user', 'user.id = comment.created_by')
            ->where('task_id', $segment[2])
            ->where('comment.type', USER_COMMENT_TYPE)
            ->orderBy('created_at', 'DESC')
            ->find();

        foreach ($comments as $key => $comment) {
            $time                           = new Time($comment['created_at']);
            $comments[$key]['created_at'] = $time->humanize();
        }

        $data['project']    = $project;
        $data['task']       = $task;
        $data['sections']   = $sections;
        $data['activities'] = $activities;
        $data['comments']   = $comments;
        $data['title']      = 'Chi tiết công việc';
        return view('Task/Detail', $data);
    }

    public function create()
    {
        $taskRawData = $this->request->getPost();
        $validation = service('validation');

        $rule = [
            'project_id'    => 'required|integer|is_not_unique[project.id]',
            'name'          => 'required|string|min_length[5]|max_length[512]',
            'section'       => 'required|integer|is_not_unique[section.id]',
            'priority'      => 'in_list[' . implode(',', array_keys(TASK_PRIORITY)) . ']',
            'descriptions'  => 'string',
        ];
        if ($taskRawData['assignee']) {
            $rule['assignee']  = 'is_not_unique[user.id]';
        }

        if ($taskRawData['start_date']) {
            $rule['start_date']  = 'valid_date';
        }

        if ($taskRawData['due_date']) {
            $rule['due_date']  = 'valid_date';
        }

        $validation->setRules(
            $rule,
            customValidationErrorMessage()
        );

        if (!$validation->run($taskRawData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $startDate = NULL;
        $dueDate   = NULL;

        $dateStartPoint = Carbon::now()->subYear();
        $dateEndPoint = Carbon::createFromDate(2100, 01, 01);

        if ($taskRawData['start_date']) {
            $startDate = Carbon::createFromFormat('Y-m-d', $taskRawData['start_date'])->startOfDay();

            if ($startDate->lt($dateStartPoint) || $startDate->gt($dateEndPoint)) {
                return $this->handleResponse(['errors_datetime' => 'Vui lòng chọn một ngày bắt đầu hợp lệ'], 400);
            }
        }

        if ($taskRawData['due_date']) {
            $dueDate = Carbon::createFromFormat('Y-m-d', $taskRawData['due_date'])->endOfDay();

            if ($dueDate->gt($dateEndPoint)) {
                return $this->handleResponse(['errors_datetime' => 'Vui lòng chọn một kết thúc hợp lệ'], 400);
            }
        }

        if ($startDate && $dueDate) {
            if ($dueDate->lt($startDate) || $dueDate->lt(Carbon::now())) {
                return $this->handleResponse(['errors_datetime' => 'Ngày kết thúc phải lớn hơn hiện tại hoặc ngày bắt đầu'], 400);
            }
        }

        $projectModel = new Project();
        $project = $projectModel->select('key')->where('id', $taskRawData['project_id'])->first();

        $taskModel = new ModelsTask();

        $taskKey = $taskModel->select('task_key')->join('section', 'section.id = task.section_id')
            ->join('project', 'project.id = section.project_id')
            ->where('project.id', $taskRawData['project_id'])
            ->orderBy('task_key', 'DESC')
            ->limit(1)
            ->first();

        $key = 0;

        if ($taskKey) {
            $key = explode('-', $taskKey['task_key']);
            $key = $key[1];
        }

        $userID = session()->get('user_id');

        $data = [
            'task_key'      => $project['key'] . '-' . ($key + 1),
            'section_id'    => $taskRawData['section'],
            'title'         => $taskRawData['name'],
            'descriptions'  => $taskRawData['descriptions'],
            'priority'      => $taskRawData['priority'],
            'created_by'    => $userID,
        ];

        if ($taskRawData['assignee']) {
            $data['assignee'] = $taskRawData['assignee'];
        }

        if ($startDate) {
            $data['start_at'] = $startDate->format('Y-m-d H:i:s');
        }

        if ($dueDate) {
            $data['due_at'] = $dueDate->format('Y-m-d H:i:s');
        }

        $taskID = $taskModel->insert($data);

        unset($data);

        $commentModel = new Comment();
        $data = [
            'task_id' => $taskID,
            'created_by' => $userID,
            'text' => '<b>' . session()->get('name') . '</b> đã tạo mới công việc.',
            'type' => SYSTEM_COMMENT_TYPE
        ];

        $commentModel = $commentModel->insert($data);

        return $this->handleResponse(['task_id' => $taskID]);
    }

    public function update()
    {
        $taskRawData = $this->request->getPost();
        $validation = service('validation');

        $rule = [
            'task_id'       => 'is_not_unique[task.id]',
            'project_id'    => 'required|integer|is_not_unique[project.id]',
            'name'          => 'required|string|min_length[5]|max_length[512]',
            'section'       => 'required|integer|is_not_unique[section.id]',
            'priority'      => 'in_list[' . implode(',', array_keys(TASK_PRIORITY)) . ']',
            'descriptions'  => 'string',
        ];
        if ($taskRawData['assignee']) {
            $rule['assignee']  = 'is_not_unique[user.id]';
        }

        if ($taskRawData['start_date']) {
            $rule['start_date']  = 'valid_date';
        }

        if ($taskRawData['due_date']) {
            $rule['due_date']  = 'valid_date';
        }

        $validation->setRules(
            $rule,
            customValidationErrorMessage()
        );

        if (!$validation->run($taskRawData)) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $startDate = NULL;
        $dueDate   = NULL;

        $dateStartPoint = Carbon::now()->subYear();
        $dateEndPoint = Carbon::createFromDate(2100, 01, 01);
        // Handle datetime
        if ($taskRawData['start_date']) {
            $startDate = Carbon::createFromFormat('Y-m-d', $taskRawData['start_date']);

            if ($startDate->lt($dateStartPoint) || $startDate->gt($dateEndPoint)) {
                return $this->handleResponse(['errors_datetime' => 'Vui lòng chọn một ngày bắt đầu hợp lệ'], 400);
            }
        }

        if ($taskRawData['due_date']) {
            $dueDate = Carbon::createFromFormat('Y-m-d', $taskRawData['due_date']);

            if ($dueDate->gt($dateEndPoint)) {
                return $this->handleResponse(['errors_datetime' => 'Vui lòng chọn một kết thúc hợp lệ'], 400);
            }
        }

        if ($startDate && $dueDate) {
            if ($dueDate->lt($startDate) || $dueDate->lt(Carbon::now())) {
                return $this->handleResponse(['errors_datetime' => 'Ngày kết thúc phải lớn hơn hiện tại hoặc ngày bắt đầu'], 400);
            }
        }

        $taskModel = new ModelsTask();

        $data = [
            'id'            => $taskRawData['task_id'],
            'section_id'    => $taskRawData['section'],
            'title'         => $taskRawData['name'],
            'descriptions'  => $taskRawData['descriptions'],
            'priority'      => $taskRawData['priority'],
            'created_by'    => session()->get('user_id'),
        ];

        if ($startDate) {
            $data['start_at'] = $startDate->format('Y-m-d H:i:s');
        }

        if ($dueDate) {
            $data['due_at'] = $dueDate->format('Y-m-d H:i:s');
        }

        if ($taskRawData['assignee']) {
            $data['assignee'] = $taskRawData['assignee'];
        }

        $taskModel->save($data);

        return $this->handleResponse();
    }

    public function changeStatus()
    {
        $validation = service('validation');

        $rule = [
            'task_id'       => 'is_not_unique[task.id]',
            'section_id'       => 'is_not_unique[section.id]',
        ];
        $validation->setRules(
            $rule,
            customValidationErrorMessage()
        );

        if (!$validation->run($this->request->getPost())) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $taskID = $this->request->getPost('task_id');
        $sectionID = $this->request->getPost('section_id');

        $taskModel = new ModelsTask();
        $taskModel->update($taskID, ['section_id' => $sectionID]);

        return $this->handleResponse();
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
