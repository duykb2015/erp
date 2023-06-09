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
            'project.name as project_name',
            'project.photo as project_photo',
            'task_status.title as status_title',
            'task_status.position',
        ])->join('task_status', 'task_status.id = task.task_status_id')
            ->join('project', 'project.id = task_status.project_id')
            ->where('task_status.base_status != ', 3)
            ->where('assignee', session()->get('user_id'))
            ->find();

        $createdBy = $taskModel->select([
            'task.id',
            'task.title',
            'task.task_key',
            'project.id as project_id',
            'project.name as project_name',
            'project.photo as project_photo',
            'task_status.title as status_title',
            'task_status.position',
        ])->join('task_status', 'task_status.id = task.task_status_id')
            ->join('project', 'project.id = task_status.project_id')
            ->where('created_by', session()->get('user_id'))
            ->where('task_status.base_status != ', 3)
            ->find();

        $recentTasks = collect(array_merge($assignee, $createdBy))->unique();
        $recentTasks = $recentTasks->sortBy('position')->groupBy('status_title');
        $data['projects']    = $projects;
        $data['recentTasks'] = $recentTasks;
        $data['title']       = 'Không gian làm việc';
        return view('Home/index', $data);
    }
}
