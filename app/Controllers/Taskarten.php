<?php

namespace App\Controllers;

use App\Models\TaskartenModel;

class Taskarten extends BaseController
{
    private TaskartenModel $taskartenModel;

    public function __construct()
    {
        $this->taskartenModel = new TaskartenModel();
    }

    public function getIndex(): string
    {
        $data['taskarten'] = $this->taskartenModel->getData();

        return view('templates/header').
               view('templates/navigation').
               view('pages/taskarten', $data).
               view('templates/footer');
    }
}