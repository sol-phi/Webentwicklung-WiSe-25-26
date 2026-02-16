<?php

namespace App\Controllers;

use App\Models\BoardsModel;
use App\Models\PersonenModel;

class PersonenErstellen extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    private BoardsModel $boardsModel;
    private PersonenModel $personenModel;

    public function __construct()
    {
        $this->boardsModel = new BoardsModel();
        $this->personenModel = new PersonenModel();
    }

    public function getIndex($todo = null, $personId = null)
    {
        // Fürs Kopieren, Bearbeiten und Löschen wird die betroffene Person geladen.
        $data['selected_person'] = $this->personenModel->getDataFromPerson($personId);

        // Abfangen von URL-Manipulationen: leitet zurück zu der Personenansicht weiter, wenn keine gültige Person beim Kopieren/Bearbeiten/Löschen ausgewählt ist.
        // $data['selected_person'] ist nicht gesetzt, wenn die $personId ungültig ist.
        // Copy, Update und Delete müssen eine *valide* PersonenID besitzen, Create darf überhaupt keine PersonenID besitzen.
        if ((($todo == "copy" || $todo == "update" || $todo == "delete") && !isset($data['selected_person']))  ||
            ($todo == "create" && isset($personId)) ) {
            return redirect()->to(base_url('public/personen'));
        }

        // Abfangen von URL-Manipulationen: leitet zurück zu der Tabellenansicht weiter, wenn Aktion keine der vier unten aufgeführten ist.
        if (!($todo == "create" || $todo == "copy" || $todo == "update" || $todo == "delete")) {
            return redirect()->to(base_url('public/personen'));
        }

        // Damit die Erstellen View weiß, welche Aktion gerade ausgeführt wird.
        $data['todo'] = $todo;

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/personen-erstellen', $data);
        echo view('templates/footer');
    }

    public function postSubmit($todo = null, $personId = null)
    {
        // Abfangen von URL-Manipulationen hier nicht notwendig, da diese Funktion nur mit fest vordefinierten Parametern durch die View aufgerufen wird.
        // Datensicherheit wird durch vorherige Abfänge von URL-Manipulationen gewährleistet.

        // Validierung nur bei Create, Copy und Update
        if ($todo !== "delete") {
            $rules = config('MyRules')->personenerstellen;
            $errors = config('MyRules')->personenerstellen_errors;

            if (!$this->validate($rules, $errors)) {
                return redirect()
                    ->to(base_url('public/personen-erstellen/' . $todo . (($todo == "copy" || $todo == 'update' || $todo == 'delete') ? '/' . $personId: '')))
                    ->withInput()  // ← Wichtig für old() in der View
                    ->with('errors', $this->validator->getErrors());
            }
        }

        // Füllt die POST-Daten in ein Array, um sie an das Model zu übergeben.
        $data = [
            'personenId' => $personId,  // nur für update und delete relevant
            'Vorname'    => $this->request->getPost('Vorname'),       // enthält die numeric ID aus dem <select>
            'Nachname'   => $this->request->getPost('Nachname'),
            'EMail'      => $this->request->getPost('EMail'),
            'Passwort'   => $this->request->getPost('Passwort'),
        ];

        $session = session();

        if ($todo == "create") {
            $this->personenModel->createPerson($data);
            $session->setFlashdata('success', 'Person erstellt!');
        } elseif ($todo == "copy") { // Wird in der View wie Update behandelt, außer dass die gewählte Person nicht ersetzt, sondern dupliziert wird.
            $this->personenModel->createPerson($data);
            $session->setFlashdata('success', 'Person kopiert.');
        } elseif ($todo == "update") {
            $this->personenModel->updatePerson($data);
            $session->setFlashdata('success', 'Person aktualisiert.');
        } elseif ($todo == "delete") {
            $this->personenModel->deletePerson($data);
            $session->setFlashdata('error', 'Person gelöscht.');
        }

        return redirect()->to(base_url('public/personen/'));
    }
}