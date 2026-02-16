<?php

namespace App\Controllers;

use App\Models\TaskartenModel;

class TaskartenErstellen extends BaseController
{
    private TaskartenModel $taskartenModel;

    public function __construct()
    {
        $this->taskartenModel = new TaskartenModel();
    }

    public function getIndex($todo = null, $taskartenId = null)
    {
        // Fürs Kopieren, Bearbeiten und Löschen wird das betroffene Board geladen.
        $data['selected_taskart'] = $this->taskartenModel->getDataFromTaskart($taskartenId);

        // Abfangen von URL-Manipulationen: leitet zurück zu der Board-Ansicht weiter, wenn kein gültiges Board beim Kopieren/Bearbeiten/Löschen ausgewählt ist.
        // $data['selected_board'] ist nicht gesetzt, wenn die $boardId ungültig ist.
        // Copy, Update und Delete müssen eine *valide* BoardID besitzen, Create darf überhaupt keine BoardID besitzen.
        if ((($todo == "copy" || $todo == "update" || $todo == "delete") && !isset($data['selected_taskart']))  ||
            ($todo == "create" && isset($taskartenId)) ) {
            return redirect()->to(base_url('public/taskarten'));
        }

        // Abfangen von URL-Manipulationen: leitet zurück zu der Tabellenansicht weiter, wenn Aktion keine der vier unten aufgeführten ist.
        if (!($todo == "create" || $todo == "copy" || $todo == "update" || $todo == "delete")) {
            return redirect()->to(base_url('public/taskarten'));
        }

        // Damit die Erstellen View weiß, welche Aktion gerade ausgeführt wird.
        $data['todo'] = $todo;

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/taskarten-erstellen', $data);
        echo view('templates/footer');
    }

    public function postSubmit($todo, $id = null)
    {
        if ($todo !== "delete") {
            $rules = config('MyRules')->taskarten;

            if (!$this->validate($rules)) {
                $redirectUrl = 'public/taskarten-erstellen/' . $todo;
                if ($id) {
                    $redirectUrl .= '/' . $id;
                }

                return redirect()
                    ->to(base_url($redirectUrl))
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }
        }

        $postData = $this->request->getPost();
        $session = session();

        switch ($todo) {
            case 'create':
                $this->taskartenModel->createTask($postData);
                $session->setFlashdata('success', 'Taskart erstellt!');
                break;
            case 'copy':
                $this->taskartenModel->createTask($postData);
                $session->setFlashdata('success', 'Taskart kopiert.');
                break;
            case 'update':
                $postData['id'] = $id;
                $this->taskartenModel->updateTaskart($postData);
                $session->setFlashdata('success', 'Taskart aktualisiert.');
                break;
            case 'delete':
                $this->taskartenModel->deleteTaskart($id);
                $session->setFlashdata('error', 'Taskart gelöscht.');
                break;
        }

        return redirect()->to(base_url('public/taskarten'));
    }
}