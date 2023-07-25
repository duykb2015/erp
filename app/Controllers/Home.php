<?php

namespace App\Controllers;

use App\Models\Project;
use App\Models\Task as ModelsTask;
use CodeIgniter\I18n\Time;

class Home extends BaseController
{
    public function index()
    {
        $projectModel = new Project();
        $projects     = $projectModel->select([
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
            ->orderBy('project.id', 'DESC')
            ->findAll(4);
        foreach ($projects as $key => $project) {
            $time                         = new Time($project['updated_at']);
            $projects[$key]['updated_at'] = $time->humanize();
        }

        $taskModel = new ModelsTask();

        $assignee = $taskModel->select([
            'task.id',
            'task.title',
            'task.task_key',
            'project.id as project_id',
            'project.prefix as project_prefix',
            'project.name as project_name',
            'project.photo as project_photo',
            'task_status.title as status_title',
            'task_status.position',
        ])->join('task_status', 'task_status.id = task.task_status_id')
            ->join('project', 'project.id = task_status.project_id')
            ->where('task_status.base_status != ', 4)
            ->where('assignee', session()->get('user_id'))
            ->find();

        $recentTasks = collect(array_merge($assignee))->unique();
        $recentTasks = $recentTasks->sortBy('position')->groupBy('status_title');
        $data['projects']    = $projects;
        $data['recentTasks'] = $recentTasks;
        $data['title']       = 'Không gian làm việc';

        foreach ($this->notifications as $key => $notify) {
            $this->notifications[$key]['created_at'] = (new Time($notify['created_at']))->humanize();
        }

        $data['notifications'] = $this->notifications;
        $data['totalNotification'] = count($this->notifications);
        return view('Home/index', $data);
    }
}
