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

    public function getIndex(): void
    {
        $data['taskarten'] = $this->taskartenModel->getData();

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/taskarten', $data);
        echo view('templates/footer');
    }
}