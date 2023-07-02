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
        $projects     = $projectModel->where('owner', session()->get('user_id'))->orderBy('id', 'DESC')->findAll(4);
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
                'section.title as section_name',
                'section.position',
            ])->join('section', 'section.id = task.section_id')
            ->join('project', 'project.id = section.project_id')
            ->where('assignee', session()->get('user_id'))->find();

        $createdBy = $taskModel->select([
                'task.id',
                'task.title', 
                'task.task_key',
                'project.id as project_id',
                'project.name as project_name',
                'project.photo as project_photo',
                'section.title as section_name',
                'section.position',
            ])->join('section', 'section.id = task.section_id')
            ->join('project', 'project.id = section.project_id')
            ->where('created_by', session()->get('user_id'))->find();

        $recentTasks = collect(array_merge($assignee, $createdBy))->unique();
        $recentTasks = $recentTasks->sortBy('position')->groupBy('section_name');
        $data['projects']    = $projects;
        $data['recentTasks'] = $recentTasks;
        $data['title']       = 'Không gian làm việc';
        return view('Home/index', $data);
    }
}
