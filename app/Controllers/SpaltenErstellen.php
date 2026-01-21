<?php

namespace App\Controllers;

use App\Models\BoardsModel;
use App\Models\SpaltenModel;

class SpaltenErstellen extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    public function getIndex($todo = null, $spaltenid = null): void
    {
        // Daten aus dem Model zum Erzeugen des Dropdowns für die Board-Auswahl
        $boardsModel = new BoardsModel();
        $data['boards'] = $boardsModel->getData();

        if ($todo !== null) {
            $data['todo'] = $todo;
        }

        // Fürs Bearbeiten und Löschen wird die betroffene Spalte geladen.
        $spaltenModel = new SpaltenModel();
        $data['selected_spalte'] = $spaltenModel->getDataFromSpalte($spaltenid);

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/spalten-erstellen', $data);
        echo view('templates/footer');
    }

    public function postSubmit($todo = null, $spaltenid = null)
    {
        // Validierung nur bei Create und Update
        if ($todo !== "delete") {
            $rules = config('MyRules')->spaltenerstellen;
            $errors = config('MyRules')->spaltenerstellen_errors;

            if (!$this->validate($rules, $errors)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        $data = [
            'spaltenId'   => $spaltenid,  // nur für update und delete relevant
            'Board'       => $this->request->getPost('Board'),       // enthält die numeric ID aus dem <select>
            'SortID'      => $this->request->getPost('SortID'),
            'Bezeichnung' => $this->request->getPost('Bezeichnung'),
            'Beschreibung'=> $this->request->getPost('Beschreibung'),
        ];

        $spaltenModel = new SpaltenModel();
        $session = session();

        if ($todo == "create") {
            $spaltenModel->createSpalte($data);
            $session->setFlashdata('success', 'Spalte erstellt!');
        } elseif ($todo == "update") {
            $spaltenModel->updateSpalte($data);
            $session->setFlashdata('success', 'Spalte aktualisiert.');
        } elseif ($todo == "delete") {
            $spaltenModel->deleteSpalte($data);
            $session->setFlashdata('error', 'Spalte gelöscht.');
        }

        return redirect()->to(base_url('public/spalten/'));
    }
}
