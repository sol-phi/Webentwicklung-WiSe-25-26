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
    public function getIndex()
    {
        return $this->getCards();
    }

    // Tasks in Tabellenansicht, im Stil von den Board-, Spalten- und Personenansichten in der Navigation.
    public function getTable(): void
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
        echo view('pages/tasks-table', $data);
        echo view('templates/footer');
    }

    // Tasks in Kartenansicht. $boardId wird in der URL als Parameter übergeben, und darauf kann mit AutoRouting direkt hier zugegriffen werden.
    public function getCards($boardId = null)
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
            return redirect()->to(base_url('public/tasks/cards/' . $data['boards'][0]['id']));
        }

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/tasks-cards', $data);
        echo view('templates/footer');
    }

    public function getMove($taskId, $newSpaltenId)
    {
        $tasksModel = new TasksModel();
        $tasksModel->updateSpalte($taskId, $newSpaltenId);

        return redirect()->back()->with('success', 'Task verschoben');
    }
}
