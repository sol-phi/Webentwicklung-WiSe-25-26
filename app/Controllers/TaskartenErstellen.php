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

    public function getIndex($todo, $id = null)
    {
        $data = [
            'todo' => $todo,
            'selected_taskart' => null
        ];

        if ($id) {
            $data['selected_taskart'] = $this->taskartenModel->getDataFromTaskart($id);
            if (!$data['selected_taskart']) {
                return redirect()->to(base_url('public/taskarten'));
            }
        }

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