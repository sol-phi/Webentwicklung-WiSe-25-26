<?php

namespace App\Controllers;

use App\Models\BoardsModel;
use App\Models\SpaltenModel;

class SpaltenErstellen extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    public function getIndex($todo = null, $spaltenId = null)
    {
        // Daten aus dem Model zum Erzeugen des Dropdowns für die Board-Auswahl
        $boardsModel = new BoardsModel();
        $data['boards'] = $boardsModel->getData();

        // Fürs Bearbeiten und Löschen wird die betroffene Spalte geladen.
        $spaltenModel = new SpaltenModel();
        $data['selected_spalte'] = $spaltenModel->getDataFromSpalte($spaltenId);

        // Abfangen von URL-Manipulationen: leitet zurück zu der Spaltenansicht weiter, wenn keine gültige Spalte beim Bearbeiten/Löschen ausgewählt ist.
        // $data['selected_spalte'] ist nicht gesetzt, wenn die $spaltenId ungültig ist.
        // Update und Delete müssen eine *valide* SpaltenId besitzen, create darf überhaupt keine SpaltenId besitzen.
        if ((($todo == "update" || $todo == "delete") && !isset($data['selected_spalte']))  ||
            ($todo == "create" && isset($spaltenId)) ) {
            return redirect()->to(base_url('public/spalten'));
        }

        if ($todo == "create") {
            // Damit die Erstellen View weiß, welche Aktion gerade ausgeführt wird.
            $data['todo'] = "create";
        } elseif ($todo == "update" || $todo == "delete") {
            // Damit der Board-Dropdown mit den Daten zu der dazugehörigen Spalte ausgefüllt werden kann.
            $data['selected_board'] = $spaltenModel->getDataFromSpalte($spaltenId);
            // Damit die Erstellen View weiß, welche Aktion gerade ausgeführt wird.
            $data['todo'] = ($todo == "update") ? "update" : "delete";
        } else{ // Abfangen von URL-Manipulationen: leitet zurück zu der Tabellenansicht weiter, wenn Aktion keine der obigen drei ist.
            return redirect()->to(base_url('public/spalten'));
        }

        if (session('data') !== null) {
            // Bei gescheiterter Validierung werden hier alle bis dahin korrekt ausgefüllten Werte mit übergeben,
            // damit diese beim Neuladen der Seite in den Formularfeldern bleiben. Plus die neuen Fehlermeldungen.
            // session('data') hat bei gleichen Array-Schlüsseln Vorrang vor $data.
            $data = array_merge($data, session('data'));
        }

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/spalten-erstellen', $data);
        echo view('templates/footer');
    }

    public function postSubmit($todo = null, $spaltenId = null)
    {
        // Abfangen von URL-Manipulationen hier nicht notwendig, da diese Funktion nur mit fest vordefinierten Parametern durch die View aufgerufen wird.
        // Datensicherheit wird durch vorherige Abfänge von URL-Manipulationen gewährleistet.

        // Füllt die POST-Daten in ein Array, um sie an das Model zu übergeben.

        // Validierung nur bei Create und Update
        if ($todo !== "delete") {
            $rules = config('MyRules')->spaltenerstellen;
            $errors = config('MyRules')->spaltenerstellen_errors;

            if (!$this->validate($rules, $errors)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        $data = [
            'spaltenId'   => $spaltenId,  // nur für update und delete relevant
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
