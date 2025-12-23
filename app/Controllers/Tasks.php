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

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/tasks', $data);
        echo view('templates/footer');
    }

    public function getCrud($id, $todo): void
    {
        $tasksModel = new TasksModel();
        $data['tasks'] = $tasksModel->getID($id);
        $data['todo'] = $todo;

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/tasks-erstellen', $data);
        echo view('templates/footer');
    }

    public function postSubmit($id, $todo)
    {
        $tasksModel = new TasksModel();
        $post = $this->request->getPost();

        $id   = (int) $id;
        $todo = (int) $todo;
        $session = session();

        if ($todo === 0) {
            // Create -> createTask gibt die Insert-ID zurück
            $insertId = $tasksModel->createTask($post);
            if ($insertId > 0) {
                $session->setFlashdata('success', 'Task erstellt (ID: ' . $insertId . ').');
            } else {
                $session->setFlashdata('error', 'Task konnte nicht erstellt werden.');
            }
        } elseif ($todo === 1) {
            // Update -> updateTask gibt bool zurück
            $ok = $tasksModel->updateTask($id, $post);
            if ($ok) {
                $session->setFlashdata('success', 'Task erfolgreich aktualisiert.');
            } else {
                $session->setFlashdata('error', 'Task nicht aktualisiert (keine Änderungen oder Fehler).');
            }
        } elseif ($todo === 2) {
            // Delete -> deleteTask gibt bool zurück
            $ok = $tasksModel->deleteTask($id);
            if ($ok) {
                $session->setFlashdata('success', 'Task gelöscht.');
            } else {
                $session->setFlashdata('error', 'Task konnte nicht gelöscht werden.');
            }
        }

        return redirect()->to(base_url('public/tasks'));
    }

}
