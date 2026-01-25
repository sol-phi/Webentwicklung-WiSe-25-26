<?php

namespace App\Controllers;

use App\Models\BoardsModel;
use App\Models\PersonenModel;
use App\Models\SpaltenModel;
use App\Models\TaskartenModel;
use App\Models\TasksModel;

class Dashboard extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    // Tasks in Kartenansicht. $boardId wird in der URL als Parameter übergeben, und darauf kann mit AutoRouting direkt hier zugegriffen werden.
    public function getIndex($boardId = null)
    {
        // Es werden immer alle Boards für den Boards Dropdown geladen.
        // Zusätzlich wird gespeichert, welcher Board aktuell ausgewählt ist, fürs Filtern der Spalten und Tasks.
        $boardsModel = new BoardsModel();
        $data['boards'] = $boardsModel->getData();
        $data['selected_board'] = $boardsModel->getDataFromBoard($boardId);
        // Es werden immer alle Spalten geladen, die zu dem ausgewählten Board gehören.
        $spaltenModel = new SpaltenModel();
        $data['spalten'] = $spaltenModel->getDataFromBoard($boardId);
        // Es werden immer alle Tasks geladen, die zu dem ausgewählten Board gehören.
        // Welcher Task zu welcher Spalte gehört, wird in der View gefiltert.
        $tasksModel = new TasksModel();
        $data['tasks'] = $tasksModel->getDataFromBoard($boardId);
        // Damit in den Task-Cards das dazugehörige Icon der Taskart geladen werden kann.
        $taskartenModel = new TaskartenModel();
        $data['taskarten'] = $taskartenModel->getData();
        // Zum Anzeigen bei den Tasks dabei
        $personenModel = new PersonenModel();
        $data['personen'] = $personenModel->getDataFromBoard($boardId);

        // Abfangen von URL-Manipulationen: leitet zu dem ersten verfügbaren Board weiter, wenn kein gültiges Board ausgewählt ist.
        // $data['selected_board'] ist nicht gesetzt, wenn die $boardId ungültig ist.
        if (!isset($data['selected_board'])) {
            return redirect()->to(base_url('public/dashboard/' . $data['boards'][0]['id']));
        }

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/dashboard', $data);
        echo view('templates/footer');
    }
}
