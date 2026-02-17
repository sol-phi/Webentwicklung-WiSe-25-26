<?php

namespace App\Controllers;

use App\Models\BoardsModel;
use App\Models\PersonenModel;
use App\Models\SpaltenModel;
use App\Models\TaskartenModel;
use App\Models\TasksModel;

class Dashboard extends BaseController
{
    private BoardsModel $boardsModel;
    private SpaltenModel $spaltenModel;
    private TasksModel $tasksModel;
    private TaskartenModel $taskartenModel;
    private PersonenModel $personenModel;

    public function __construct()
    {
        $this->boardsModel = new BoardsModel();
        $this->spaltenModel = new SpaltenModel();
        $this->tasksModel = new TasksModel();
        $this->taskartenModel = new TaskartenModel();
        $this->personenModel = new PersonenModel();
    }

    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    // Tasks in Kartenansicht. $boardId wird in der URL als Parameter übergeben, und darauf kann mit AutoRouting direkt hier zugegriffen werden.
    public function getIndex($boardId = null)
    {
        // Es werden immer alle Boards für den Boards Dropdown geladen.
        // Zusätzlich wird gespeichert, welcher Board aktuell ausgewählt ist, fürs Filtern der Spalten und Tasks.
        $data['boards'] = $this->boardsModel->getData();
        $data['selected_board'] = $this->boardsModel->getDataFromBoard($boardId);
        // Es werden immer alle Spalten geladen, die zu dem ausgewählten Board gehören.
        $data['spalten'] = $this->spaltenModel->getDataFromBoard($boardId);
        // Es werden immer alle Tasks geladen, die zu dem ausgewählten Board gehören.
        // Welcher Task zu welcher Spalte gehört, wird in der View gefiltert.
        $data['tasks'] = $this->tasksModel->getDataFromBoard($boardId);
        // Damit in den Task-Cards das dazugehörige Icon der Taskart geladen werden kann.
        $data['taskarten'] = $this->taskartenModel->getData();
        // Zum Anzeigen bei den Tasks dabei
        $data['personen'] = $this->personenModel->getDataFromBoard($boardId);

        // Abfangen von URL-Manipulationen: leitet zu dem ersten verfügbaren Board weiter, wenn kein gültiges Board ausgewählt ist.
        // $data['selected_board'] ist nicht gesetzt, wenn die $boardId ungültig ist.
        if (!isset($data['selected_board'])) {
            return redirect()->to(base_url('public/dashboard/' . $data['boards'][0]['id']));
        }

        return view('templates/header').
               view('templates/navigation').
               view('pages/dashboard', $data).
               view('templates/footer');
    }
}
