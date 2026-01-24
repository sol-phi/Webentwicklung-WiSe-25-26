<?php

namespace App\Controllers;

use App\Models\BoardsModel;

class BoardsErstellen extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    private BoardsModel $boardsModel;

    public function __construct()
    {
        $this->boardsModel = new BoardsModel();
    }

    public function getIndex($todo = null, $boardId = null)
    {
        // Fürs Kopieren, Bearbeiten und Löschen wird das betroffene Board geladen.
        $data['selected_board'] = $this->boardsModel->getDataFromBoard($boardId);

        // Abfangen von URL-Manipulationen: leitet zurück zu der Board-Ansicht weiter, wenn kein gültiges Board beim Kopieren/Bearbeiten/Löschen ausgewählt ist.
        // $data['selected_board'] ist nicht gesetzt, wenn die $boardId ungültig ist.
        // Copy, Update und Delete müssen eine *valide* BoardID besitzen, Create darf überhaupt keine BoardID besitzen.
        if ((($todo == "copy" || $todo == "update" || $todo == "delete") && !isset($data['selected_board']))  ||
            ($todo == "create" && isset($boardId)) ) {
            return redirect()->to(base_url('public/boards'));
        }

        // Abfangen von URL-Manipulationen: leitet zurück zu der Tabellenansicht weiter, wenn Aktion keine der vier unten aufgeführten ist.
        if (!($todo == "create" || $todo == "copy" || $todo == "update" || $todo == "delete")) {
            return redirect()->to(base_url('public/boards'));
        }

        // Damit die Erstellen View weiß, welche Aktion gerade ausgeführt wird.
        $data['todo'] = $todo;

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/boards-erstellen', $data);
        echo view('templates/footer');
    }

    public function postSubmit($todo = null, $boardId = null)
    {
        // Abfangen von URL-Manipulationen hier nicht notwendig, da diese Funktion nur mit fest vordefinierten Parametern durch die View aufgerufen wird.
        // Datensicherheit wird durch vorherige Abfänge von URL-Manipulationen gewährleistet.

        // Validierung nur bei Create, Copy und Update
        if ($todo !== "delete") {
            $rules = config('MyRules')->boardserstellen;
            $errors = config('MyRules')->boardserstellen_errors;

            if (!$this->validate($rules, $errors)) {
                return redirect()
                    ->to(base_url('public/boards-erstellen/' . $todo . (($todo == "copy" || $todo == 'update' || $todo == 'delete') ? '/' . $boardId: '')))
                    ->withInput()  // ← Wichtig für old() in der View
                    ->with('errors', $this->validator->getErrors());
            }
        }

        // Füllt die POST-Daten in ein Array, um sie an das Model zu übergeben.
        $data = [
            'boardId'       => $boardId,  // nur für Copy, Update und Delete relevant
            'Bezeichnung'   => $this->request->getPost('Bezeichnung'),
        ];

        $session = session();

        if ($todo == "create") {
            $this->boardsModel->createBoard($data);
            $session->setFlashdata('success', 'Board erstellt!');
        } elseif ($todo == "copy") { // Wird in der View wie Update behandelt, außer dass das gewählte Board nicht ersetzt, sondern dupliziert wird.
            $this->boardsModel->createBoard($data);
            $session->setFlashdata('success', 'Board kopiert.');
        } elseif ($todo == "update") {
            $this->boardsModel->updateBoard($data);
            $session->setFlashdata('success', 'Board aktualisiert.');
        } elseif ($todo == "delete") {
            $this->boardsModel->deleteBoard($data);
            $session->setFlashdata('error', 'Board gelöscht.');
        }

        return redirect()->to(base_url('public/boards/'));
    }
}
