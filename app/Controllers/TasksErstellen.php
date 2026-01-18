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

        // Abfangen von URL-Manipulationen: leitet zurück zu der Tabellenansicht weiter, wenn kein gültiger Task beim Bearbeiten/Löschen ausgewählt ist.
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

        if (session('data') !== null) {
            // Bei gescheiterter Validierung werden hier alle bis dahin korrekt ausgefüllten Werte mit übergeben,
            // damit diese beim Neuladen der Seite in den Formularfeldern bleiben. Plus die neuen Fehlermeldungen.
            // session('data') hat bei gleichen Array-Schlüsseln Vorrang vor $data.
            $data = array_merge($data, session('data'));
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

        // Abfangen von URL-Manipulationen: leitet zurück zu dem ersten verfügbaren Board auf der Cards-Ansicht weiter, wenn kein gültiger Task/Board beim Erstellen/Bearbeiten/Löschen ausgewählt ist.
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

        if (session('data') !== null) {
            // Bei gescheiterter Validierung werden hier alle bis dahin korrekt ausgefüllten Werte mit übergeben,
            // damit diese beim Neuladen der Seite in den Formularfeldern bleiben. Plus die neuen Fehlermeldungen.
            // session('data') hat bei gleichen Array-Schlüsseln Vorrang vor $data.
            $data = array_merge($data, session('data'));
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
        // Abfangen von URL-Manipulationen hier nicht notwendig, da diese Funktion nut mit fest vordefinierten Parametern durch die View aufgerufen wird.
        // Datensicherheit wird durch vorherige Abfänge von URL-Manipulationen gewährleistet.

        // Füllt die POST-Daten in ein Array, um sie an das Model zu übergeben.
        $data = [
            'Bezeichnung'       => $this->request->getPost('Bezeichnung'),
            'TaskartID'         => $this->request->getPost('TaskartID'),
            'PersonID'          => $this->request->getPost('PersonID'),
            'SpaltenID'         => $this->request->getPost('SpaltenID'),
            'SortID'            => $this->request->getPost('SortID'),
            'Erinnerungsdatum'  => $this->request->getPost('Erinnerungsdatum'),
            'Erinnerung'        => $this->request->getPost('Erinnerung') ? 1 : 0,
            'Notizen'             => $this->request->getPost('Notizen'),
        ];

        $tasksModel = new TasksModel();
        $session = session();
        // Bei Create und Update wird die Validierung der Eingaben durchgeführt.
        if ($this->validation->run($_POST,'taskErstellenRules') || $todo == "delete") {
            // Differenzierung zwischen Cards- und Table-Ansicht geschieht in der View
            if ($todo == "create") {
                // Die Daten werden nun als neuer Task im Model in die Datenbank eingefügt.
                $tasksModel->createTask($data);
                // Für die Bestätigungsmeldung auf der Tasks-Übersichtsseite, ob Cards oder Table.
                $session->setFlashdata('success', 'Task erstellt!');
            }
            elseif ($todo == "update") {
                // Die Daten werden nun an der Stelle id == $taskId die vorherige Zeile überschreiben, in der Datenbank, durch das Model
                $tasksModel->updateTask($data, $taskId);
                // Für die Bestätigungsmeldung auf der Tasks-Übersichtsseite, ob Cards oder Table.
                $session->setFlashdata('success', 'Task aktualisiert.');
            }
            elseif ($todo == "delete") {
                // Die Datenbank wird nun nach $taskid durchsucht, und dessen Zeile gelöscht.
                $tasksModel->deleteTask($taskId);
                // Für die Bestätigungsmeldung auf der Tasks-Übersichtsseite, ob Cards oder Table.
                // Kein Fehler, Löschen soll nur rot angezeigt werden.
                $session->setFlashdata('error', 'Task gelöscht.');
            }

            // Leitet zurück dorthin, von wo die Erstellen View aufgerufen wurde.
            return redirect()->to(base_url('public/tasks/' . $view . (($view == "cards") ? '/' . $boardId : '' ) ));
        }
        else{
            // Bei fehlerhafter Validierung werden die bisherigen Eingaben zurück in $data gepackt und an die Erstellen View übergeben,
            // zum Anzeigen der bis dahin eingegebenen Werten.
            $data = $_POST;
            // Beinhaltet die Fehlermeldungen, die in der Erstellen-View rot unter den Eingabefeldern angezeigt werden.
            $data['error'] = $this->validation->getErrors();

            // Alle relevanten, nicht in den Formularfeldern vorhandenen Daten werden ebenfalls zurückgegeben.
            $data['todo'] = $todo;
            // Alle Boards geladen für den Fallback aufs erste verfügbare Board bei URL-Manipulationen.
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
            $data['view'] = $view;

            // Leitet zurück zu genau derselben Erstellen View weiter, wo wir uns gerade befinden, mit den bisherigen Eingaben und den neuen Fehlermeldungen.
            // Dient dazu, die Seite neu zu laden, damit die Fehlermeldungen angezeigt werden können.
            // with() erlaubt das Übergeben von Daten in einem redirect, ähnlich zu echo view('pages/spalten-erstellen', $data);
            return redirect()
                ->to(base_url('public/tasks-erstellen/' . $view . (($view == "cards") ? '/' . $boardId : '' ) . '/' . $todo . (($todo == 'update' || $todo == 'delete') ? '/' . $taskId: '') ))
                ->withInput()
                ->with('data', $data);
        }
    }
}
