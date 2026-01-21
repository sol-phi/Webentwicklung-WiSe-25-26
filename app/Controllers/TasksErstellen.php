<?php

namespace App\Controllers;

use App\Models\BoardsModel;
use App\Models\SpaltenModel;
use App\Models\TasksModel;
use App\Models\TaskartenModel;
use App\Models\PersonenModel;

class TasksErstellen extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    // Falls von der Tabelle kommend. $tod0 und $taskId werden in der URL als Parameter übergeben, und darauf kann mit AutoRouting direkt hier zugegriffen werden.
    public function getTable($todo = null, $taskId = null)
    {
        // Es werden immer alle Spalten für den Spalten Dropdown geladen.
        $spaltenModel = new SpaltenModel();
        $data['spalten'] = $spaltenModel->getData();
        // Fürs Bearbeiten und Löschen wird der betroffene Task geladen.
        $tasksModel = new TasksModel();
        $data['selected_task'] = $tasksModel->getDataFromTask($taskId);
        // Es werden immer alle Taskarten für den Taskarten Dropdown geladen.
        $taskartenModel = new TaskartenModel();
        $data['taskarten'] = $taskartenModel->getData();
        // Es werden immer alle Personen für den Personen Dropdown geladen.
        $personenModel = new PersonenModel();
        $data['personen'] = $personenModel->getData();
        // Damit die Erstellen View weiß, von wo sie herkam.
        $data['table'] = "Table";

        // Abfangen von URL-Manipulationen: leitet zurück zu der Tabellenansicht weiter, wenn kein gültiger Task beim Erstellen/Löschen ausgewählt ist.
        // $data['selected_task'] ist nicht gesetzt, wenn die $taskId ungültig ist.
        // Update und Delete müssen eine *valide* TaskId besitzen, create darf überhaupt keine TaskId besitzen.
        if ((($todo == "update" || $todo == "delete") && !isset($data['selected_task']))  ||
            ($todo == "create" && isset($taskId)) ) {
            return redirect()->to(base_url('public/tasks/table'));
        }

        if ($todo == "create") {
            // Damit die Erstellen View weiß, welche Aktion gerade ausgeführt wird.
            $data['todo'] = "create";
        } elseif ($todo == "update" || $todo == "delete") {
            // Damit die entsprechenden Dropdowns mit den Daten zu dem dazugehörigen Task ausgefüllt werden können.
            $data['selected_spalte'] = $spaltenModel->getDataFromTask($taskId);
            $data['selected_taskart'] = $taskartenModel->getDataFromTask($taskId);
            $data['selected_person'] = $personenModel->getDataFromTask($taskId);
            // Damit die Erstellen View weiß, welche Aktion gerade ausgeführt wird.
            $data['todo'] = ($todo == "update") ? "update" : "delete";
        } else{ // Abfangen von URL-Manipulationen: leitet zurück zu der Tabellenansicht weiter, wenn Aktion keine der obigen drei ist.
            return redirect()->to(base_url('public/tasks/table'));
        }

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/tasks-erstellen', $data);
        echo view('templates/footer');
    }

    // Falls von den Cards kommend. $boardId, $tod0 und $taskId werden in der URL als Parameter übergeben, und darauf kann mit AutoRouting direkt hier zugegriffen werden.
    public function getCards($boardId = null, $todo = null, $taskId = null)
    {
        // Alle Boards geladen für den Fallback aufs erste verfügbare Board bei URL-Manipulationen, siehe unten.
        // Zusätzlich wird der gerade ausgewählte Board gespeichert, fürs korrekte Zurückleiten nach Abschließen der Aktion in der Erstellen View
        $boardsModel = new BoardsModel();
        $data['boards'] = $boardsModel->getData();
        $data['selected_board'] = $boardsModel->getDataFromBoard($boardId);
        // Es werden immer alle Spalten für den Spalten Dropdown geladen.
        $spaltenModel = new SpaltenModel();
        $data['spalten'] = $spaltenModel->getData();
        // Fürs Bearbeiten und Löschen wird der betroffene Task geladen.
        $tasksModel = new TasksModel();
        $data['selected_task'] = $tasksModel->getDataFromTask($taskId);
        // Es werden immer alle Taskarten für den Taskarten Dropdown geladen.
        $taskartenModel = new TaskartenModel();
        $data['taskarten'] = $taskartenModel->getData();
        // Es werden immer alle Personen für den Personen Dropdown geladen.
        $personenModel = new PersonenModel();
        $data['personen'] = $personenModel->getData();
        // Damit die Erstellen View weiß, von wo sie herkam.
        $data['cards'] = "Cards";

        // Abfangen von URL-Manipulationen: leitet zurück zu dem ersten verfügbaren Board auf der Cards-Ansicht weiter, wenn kein gültiger Task/Board beim Erstellen/Löschen ausgewählt ist.
        // $data['selected_task'] und $data['selected_board'] sind nicht gesetzt, wenn die entsprechenden $taskId oder $boardId ungültig sind.
        if (!isset($data['selected_board'])){
            return redirect()->to(base_url('public/tasks/cards/' . $data['boards'][0]['id']));
        } // Update und Delete müssen eine *valide* TaskId besitzen, create darf überhaupt keine TaskId besitzen.
        elseif ( (($todo == "update" || $todo == "delete") && !isset($data['selected_task'])) ||
                 ($todo == "create" && isset($taskId)) ) {
            return redirect()->to(base_url('public/tasks/cards/' . $data['selected_board']['id']));
        }

        if ($todo == "create") {
            // Damit die Erstellen View weiß, welche Aktion gerade ausgeführt wird.
            $data['todo'] = "create";
        } elseif ($todo == "update" || $todo == "delete") {
            // Damit die entsprechenden Dropdowns mit den Daten zu dem dazugehörigen Task ausgefüllt werden können.
            $data['selected_spalte'] = $spaltenModel->getDataFromTask($taskId);
            $data['selected_taskart'] = $taskartenModel->getDataFromTask($taskId);
            $data['selected_person'] = $personenModel->getDataFromTask($taskId);
            // Damit die Erstellen View weiß, welche Aktion gerade ausgeführt wird.
            $data['todo'] = ($todo == "update") ? "update" : "delete";
        } else{ // Abfangen von URL-Manipulationen: leitet zurück zu dem ersten verfügbaren Board auf der Cards-Ansicht weiter, wenn Aktion keine der obigen drei ist.
            return redirect()->to(base_url('public/tasks/cards/' . $data['selected_board']['id']));
        }

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/tasks-erstellen', $data);
        echo view('templates/footer');
    }

    // Beim Einreichen des Formulars gibt die View vier Parameter mit, einmal auf welche Ansicht wieder zurückgeleitet werden soll ($view),
    // und $boardId, $tod0 und $taskId. werden in der URL als Parameter übergeben, und darauf kann mit AutoRouting direkt hier zugegriffen werden.
    public function postSubmit($view = null, $boardId = null, $todo = null, $taskId = null)
    {
        // Validierung nur bei Create und Update
        if ($todo !== "delete") {
            $rules = config('MyRules')->taskserstellen;
            $errors = config('MyRules')->taskserstellen_errors;

            if (!$this->validate($rules, $errors)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        $data = [
            'Bezeichnung'      => $this->request->getPost('Bezeichnung'),
            'TaskartID'        => $this->request->getPost('TaskartID'),
            'PersonID'         => $this->request->getPost('PersonID'),
            'SpaltenID'        => $this->request->getPost('SpaltenID'),
            'SortID'           => $this->request->getPost('SortID'),
            'Erinnerungsdatum' => $this->request->getPost('Erinnerungsdatum'),
            'Erinnerung'       => $this->request->getPost('Erinnerung') ? 1 : 0,
            'Notizen'          => $this->request->getPost('Notizen'),
        ];

        $tasksModel = new TasksModel();
        $session = session();

        if ($todo == "create") {
            $tasksModel->createTask($data);
            $session->setFlashdata('success', 'Task erstellt!');
        } elseif ($todo == "update") {
            $tasksModel->updateTask($data, $taskId);
            $session->setFlashdata('success', 'Task aktualisiert.');
        } elseif ($todo == "delete") {
            $tasksModel->deleteTask($taskId);
            $session->setFlashdata('error', 'Task gelöscht.');
        }

        return redirect()->to(base_url('public/tasks/' . $view . (($view == "cards") ? '/' . $boardId : '')));
    }
}
