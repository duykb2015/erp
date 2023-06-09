<?php

namespace App\Controllers;

class Project extends BaseController
{
    public function index()
    {
        return view('Home/index');
    }

    public function create()
    {
        dd($this->request->getPost('project_name')[0]);
        $img = makeImage(strtoUpper('C'));
    }
}
