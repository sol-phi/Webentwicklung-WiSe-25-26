<?php

namespace App\Controllers;

use App\Models\TasksModel;

class Tasks extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    public function getIndex(): void
    {
        $tasksModel = new TasksModel();
        $data['tasks'] = $tasksModel->getData();

//        echo("<pre>");
//        var_dump($data['tasks']);
//        echo("<pre>");

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/tasks', $data);
        echo view('templates/footer');


    }


}
