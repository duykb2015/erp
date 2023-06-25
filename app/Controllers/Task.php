<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Task extends BaseController
{
    public function index()
    {
        //
    }

    public function create()
    {
        $task = $this->request->getPost();
        dd($task);
    }
}
