<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Upload extends BaseController
{
    public function task_attachment()
    {
        return $this->handleResponse($this->request->getFiles());
    }
}
