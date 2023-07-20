<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task as ModelsTask;
use App\Models\TaskAttachment;
use App\Models\TaskLog;
use App\Models\TaskStatus;
use App\Models\User;
use Carbon\Carbon;
use CodeIgniter\I18n\Time;
use Exception;

class Task extends BaseController
{
    public function index()
    {
        $segment = $this->request->getUri()->getSegments();
        array_shift($segment); //remove segment 0 (project), we don't need it
        $projectPrefix   = $segment[0];

        $projectModel     = new Project();
        $projectUserModel = new ProjectUser();
        $project = $projectModel->where('prefix', $projectPrefix)->first();
        if (!$project) {
            $data['backLink'] = '/project';
            return view('Error/NotFound', $data);
        }

        $projectUser   = $projectUserModel->select(['user_id', 'role'])->where('project_id', $project['id'])->find();
        $projectUserID = collect($projectUser)->pluck('user_id')->toArray();

        $userID = session()->get('user_id');

        if ($project['owner'] != $userID) {
            if (!in_array($userID, $projectUserID)) {
                $data['backLink']   = '/project';
                return view('Error/Forbidden', $data);
            }
        }

        $taskModel = new ModelsTask();
        $task      = $taskModel->where('task_key', $segment[2])->first();
        if (empty($task)) {
            $data['backLink']   = "/project/{$projectPrefix}";
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
            ->where('project_user.project_id', $project['id'])
            ->where('project_user.user_id !=', session()->get('user_id'))
            ->find();
        $data['assignees'] = $assignees;

        // Get all task status
        $taskStatusModel = new TaskStatus();
        $taskStatus = $taskStatusModel->where('task_status.project_id', $project['id'])
            ->orderBy('position', 'ASC')
            ->findAll();

        $taskLogModel = new TaskLog();

        $activities = $taskLogModel->select(['log', 'created_at'])
            ->where('task_id', $task['id'])
            ->orderBy('created_at', 'DESC')
            ->find();

        foreach ($activities as $key => $activity) {
            $time                           = new Time($activity['created_at']);
            $activities[$key]['created_at'] = $time->humanize();
        }

        $projectUser   = $projectUserModel->select(['user_id', 'role'])->where('project_id', $project['id'])->find();
        $userRole = collect($projectUser)->where('user_id', session()->get('user_id'))->first()['role'];

        $commentModel = new Comment();
        $comments = $commentModel
            ->select([
                'comment.id',
                'COALESCE(CONCAT(user.firstname, " ", user.lastname), user.username) as name',
                'user.photo',
                'user_id',
                'text',
                'comment.created_at'
            ])
            ->join('user', 'user.id = comment.user_id')
            ->where('task_id', $task['id'])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        foreach ($comments as $key => $comment) {
            $time                           = new Time($comment['created_at']);
            $comments[$key]['created_at'] = $time->humanize();
        }

        $task['status'] = (new TaskStatus)->select('title as status')->where('id', $task['task_status_id'])->first()['status'];

        $attachmentModel = new Attachment();
        $attachments = $attachmentModel->where('task_id', $task['id'])->find();

        $data['pager']       = $commentModel->pager;
        $data['userRole']    = $userRole;
        $data['project']     = $project;
        $data['task']        = $task;
        $data['taskStatus']  = $taskStatus;
        $data['activities']  = $activities;
        $data['attachments'] = $attachments;
        $data['comments']    = $comments;
        $data['title']       = 'Chi tiết công việc';
        return view('Task/Detail', $data);
    }

    public function create()
    {
        $taskRawData = $this->request->getPost();
        $validation = service('validation');

        $rule = [
            'project_id'    => 'required|integer|is_not_unique[project.id]',
            'name'          => 'required|string|min_length[5]|max_length[512]',
            'task_status'   => 'required|integer|is_not_unique[task_status.id]',
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
        $project = $projectModel->select('prefix')->where('id', $taskRawData['project_id'])->first();

        $taskModel = new ModelsTask();

        $taskKey = $taskModel->select('task_key')->join('task_status', 'task_status.id = task.task_status_id')
            ->join('project', 'project.id = task_status.project_id')
            ->where('project.id', $taskRawData['project_id'])
            ->orderBy('task.id', 'DESC')
            ->limit(1)
            ->first();

        $key = 0;

        if ($taskKey) {
            $key = explode('-', $taskKey['task_key']);
            $key = $key[1];
        }

        $userID = session()->get('user_id');

        $data = [
            'task_key'      => $project['prefix'] . '-' . ($key + 1),
            'task_status_id' => $taskRawData['task_status'],
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

        $files = $this->request->getFiles();

        $attachmentModel = new Attachment();

        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $file->move(ATTACHMENT_PATH);

                $type = collect(explode('.', $file->getName()))->last() ?? 'unknown';
                $attachmentModel->insert([
                    'name' => $file->getName(),
                    'task_id' => $taskID,
                    'type' => $type
                ]);
            }
        }

        unset($data);

        $taskLogModel = new TaskLog();
        $data = [
            'task_id' => $taskID,
            'log' => '<b>' . session()->get('name') . '</b> đã tạo mới công việc.',
        ];
        $taskLogModel->insert($data);

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
            'task_status'       => 'required|integer|is_not_unique[task_status.id]',
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
            'task_status_id' => $taskRawData['task_status'],
            'title'         => $taskRawData['name'],
            'descriptions'  => $taskRawData['descriptions'],
            'priority'      => $taskRawData['priority'],
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

        $files = $this->request->getFiles();

        $attachmentModel = new Attachment();

        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $file->move(ATTACHMENT_PATH);

                $type = collect(explode('.', $file->getName()))->last() ?? 'unknown';
                $attachmentModel->insert([
                    'name' => $file->getName(),
                    'task_id' => $taskRawData['task_id'],
                    'type' => $type
                ]);
            }
        }

        unset($data);

        $commentModel = new Comment();
        $data = [
            'task_id' => $taskRawData['task_id'],
            'user_id' => session()->get('user_id'),
            'text' => '<b>' . session()->get('name') . '</b> đã chỉnh sửa công việc.',
            'type' => SYSTEM_COMMENT_TYPE
        ];

        $commentModel = $commentModel->insert($data);

        return $this->handleResponse();
    }

    public function changeStatus()
    {
        $validation = service('validation');

        $rule = [
            'task_id'       => 'is_not_unique[task.id]',
            'status_id'       => 'is_not_unique[task_status.id]',
        ];
        $validation->setRules(
            $rule,
            customValidationErrorMessage()
        );

        if (!$validation->run($this->request->getPost())) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }

        $taskID = $this->request->getPost('task_id');
        $sectionID = $this->request->getPost('status_id');

        $taskModel = new ModelsTask();
        $taskModel->update($taskID, ['task_status_id' => $sectionID]);

        return $this->handleResponse();
    }

    public function delete()
    {
        $taskID = $this->request->getPost('task_id');

        $validation = service('validation');

        $rule = [
            'task_id' => 'required|is_not_unique[task.id]',
        ];
        $validation->setRules(
            $rule,
            customValidationErrorMessage()
        );

        if (!$validation->run($this->request->getPost())) {
            return $this->handleResponse(['errors' => $validation->getErrors()], 400);
        }
        //attachment

        $commentModel = new Comment();
        $comments     = $commentModel->select('id')->where('task_id', $taskID)->find();

        $taskLogModel = new TaskLog();
        $logs     = $taskLogModel->select('id')->where('task_id', $taskID)->find();

        $attachmentModel = new Attachment();
        $attachments     = $attachmentModel->select('id')->where('task_id', $taskID)->find();

        if ($comments) {
            $commentModel->delete(collect($comments)->pluck('id')->toArray());
        }

        if ($logs) {
            $taskLogModel->delete(collect($logs)->pluck('id')->toArray());
        }

        if ($attachments) {
            $attachmentModel->delete(collect($attachments)->pluck('id')->toArray());
        }

        $taskModel = new ModelsTask();
        $taskModel->delete($taskID);
        return $this->handleResponse();
    }

    public function removeAttachment()
    {
        $fileID = $this->request->getPost('attachment_id');
        $fileName = $this->request->getPost('file');

        $attachmentModel = new Attachment();
        $attachmentModel->delete($fileID);

        unlink(ATTACHMENT_PATH . $fileName);

        return $this->handleResponse();
    }
}
