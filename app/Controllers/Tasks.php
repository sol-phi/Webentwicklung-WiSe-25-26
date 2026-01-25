<?php

namespace App\Controllers;

use App\Models\BoardsModel;
use App\Models\PersonenModel;
use App\Models\SpaltenModel;
use App\Models\TaskartenModel;
use App\Models\TasksModel;

class Tasks extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    // Wenn nur /tasks aufgerufen wird, wird man automatisch zur Card-Ansicht des ersten Boards weitergeleitet.
    // Tasks in Tabellenansicht, im Stil von den Board-, Spalten- und Personenansichten in der Navigation.
    public function getIndex()
    {
        // Boards geladen für den Fallback aufs erste verfügbare Board bei URL-Manipulationen bei Redirects zurück zu Cards, und zum Anzeigen
        $boardsModel = new BoardsModel();
        $data['boards'] = $boardsModel->getData();
        $tasksModel = new TasksModel();
        $data['tasks'] = $tasksModel->getData();
        // Folgende Daten geladen, damit dessen Bezeichnungen zu dem Task angezeigt werden können.
        $spaltenModel = new SpaltenModel();
        $data['spalten'] = $spaltenModel->getData();
        $taskartenModel = new TaskartenModel();
        $data['taskarten'] = $taskartenModel->getData();
        $personenModel = new PersonenModel();
        $data['personen'] = $personenModel->getData();

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/tasks', $data);
        echo view('templates/footer');
    }
}
