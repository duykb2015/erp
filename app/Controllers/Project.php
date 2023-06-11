<?php

namespace App\Controllers;

use App\Models\Project as ModelsProject;

class Project extends BaseController
{

    public function index()
    {
        return view('Project/index');
    }

    public function create()
    {
        $validation = service('validation');
        $validation->setRules(
            [
                'project_name'         => 'required|string|min_length[5]|is_unique[project.name]',
                'project_key'          => 'required|string|min_length[1]',
                'project_descriptions' => 'string',
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
