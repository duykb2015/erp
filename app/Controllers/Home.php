<?php

namespace App\Controllers;

use App\Models\Project;
use CodeIgniter\I18n\Time;

class Home extends BaseController
{
    public function index()
    {
        $projectModel = new Project();
        $projects     = $projectModel->where('owner', session()->get('user_id'))->orderBy('id', 'DESC')->findAll(4);
        foreach ($projects as $key => $project)
        {
            $time                         = new Time($project['updated_at']);
            $projects[$key]['updated_at'] = $time->humanize();
        }

        $data = ['projects' => $projects];
        return view('Home/index', $data);
    }
}
