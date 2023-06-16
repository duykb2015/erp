<?php

namespace App\Controllers;

use App\Models\Project as ModelsProject;
use App\Models\ProjectUser;
use Carbon\Carbon;
use CodeIgniter\I18n\Time;

class Project extends BaseController
{
    public function list()
    {
        $projectModel = new ModelsProject();
        $now          = Carbon::now('Asia/Ho_Chi_Minh');
        
        $filter       = $this->request->getGet('dim');
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
        switch ($sort)
        {
            case 'oldest':
                $projectModel->orderBy('updated_at', 'ASC');
                break;

            default:
                $projectModel->orderBy('updated_at', 'DESC');
                break;   
        }

        $limit = $this->request->getGet('limit');
        switch ($limit)
        {
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
        if (10 <= count($projects))
        {
            $data['pager'] = $projectModel->pager;
        }

        $data['dim']   = $filter;
        $data['sort']  = $sort;
        $data['limit'] = $limit;
        return view('Project/List', $data);
    }

    public function detail()
    {
        $projectID = $this->request->getUri()->getSegment(2);

        if (!is_numeric($projectID)) {
            return view('Error/NotFound');
        }

        $projectModel     = new ModelsProject();
        $projectUserModel = new ProjectUser();

        $project     = $projectModel->find($projectID);
        if (!$project) {
            return view('Error/NotFound');
        }

        $projectUser = $projectUserModel->select('user_id')->where('project_id', $projectID)->findAll();

        $userID = session()->get('user_id');
        if ($project['owner'] != $userID) {
            if (!in_array($userID, $projectUser)) {
                return view('Error/Forbidden');
            }
        }

        $data = ['project' => $project];

        return view('Project/Index', $data);
    }

    public function create()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'project_name'         => 'required|string|min_length[5]|max_length[255]|is_unique[project.name]',
                'project_key'          => 'required|string|min_length[1]|max_length[10]',
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

        $result       = ['project_id' => $projectID];
        return $this->handleResponse($result);
    }
}
