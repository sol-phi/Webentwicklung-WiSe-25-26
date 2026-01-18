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
            $data['selected_board'] = $boardsModel->getDataFromSpalte($spaltenId);
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
        $data = [
            'Bezeichnung'       => $this->request->getPost('Bezeichnung'),
            'Beschreibung'      => $this->request->getPost('Beschreibung'),
            'SortID'            => $this->request->getPost('SortID'),
            'BoardID'             => $this->request->getPost('BoardID'),
        ];

        $spaltenModel = new SpaltenModel();
        $session = session();
        // Bei Create und Update wird die Validierung der Eingaben durchgeführt.
        if ($this->validation->run($_POST,'spaltenErstellenRules') || $todo == "delete") {
            if ($todo == "create") {
                // Die Daten werden nun als neue Spalte im Model in die Datenbank eingefügt.
                $spaltenModel->createSpalte($data);
                // Für die Bestätigungsmeldung auf der Spalten-Übersichtsseite.
                $session->setFlashdata('success', 'Spalte erstellt!');
            }
            elseif ($todo == "update") {
                // Die Daten werden nun an der Stelle id == $spaltenId die vorherige Zeile überschreiben, in der Datenbank, durch das Model
                $spaltenModel->updateSpalte($data, $spaltenId);
                // Für die Bestätigungsmeldung auf der Spalten-Übersichtsseite.
                $session->setFlashdata('success', 'Spalte aktualisiert.');
            }
            elseif ($todo == "delete") {
                // Die Datenbank wird nun nach $spaltenId durchsucht, und dessen Zeile gelöscht.
                $spaltenModel->deleteSpalte($spaltenId);
                // Für die Bestätigungsmeldung auf der Spalten-Übersichtsseite.
                // Kein Fehler, Löschen soll nur rot angezeigt werden.
                $session->setFlashdata('error', 'Spalte gelöscht.');
            }

            // Leitet zurück dorthin, von wo die Erstellen View aufgerufen wurde.
            return redirect()->to(base_url('public/spalten/'));
        }
        else{
            // Bei fehlerhafter Validierung werden die bisherigen Eingaben zurück in $data gepackt und an die Erstellen View übergeben,
            // zum Anzeigen der bis dahin eingegebenen Werten.
            $data = $_POST;
            // Beinhaltet die Fehlermeldungen, die in der Erstellen-View rot unter den Eingabefeldern angezeigt werden.
            $data['error'] = $this->validation->getErrors();

            // Alle relevanten, nicht in den Formularfeldern vorhandenen Daten werden ebenfalls zurückgegeben.
            $data['todo'] = $todo;
            // Für den Boards-Dropdown
            $boardsModel = new BoardsModel();
            $data['boards'] = $boardsModel->getData();
            // Zum Filtern für den Boards-Dropdown, und zum Laden der korrekten Spaltendaten bei Update und Delete
            $spaltenModel = new SpaltenModel();
            $data['selected_spalte'] = $spaltenModel->getDataFromSpalte($spaltenId);

            if ($todo == "update" || $todo == "delete") {
                // Damit der Board-Dropdown mit den Daten zu der dazugehörigen Spalte ausgefüllt werden kann.
                $data['selected_board'] = $boardsModel->getDataFromSpalte($spaltenId);
            }

            // Leitet zurück zu genau derselben Erstellen View weiter, wo wir uns gerade befinden, mit den bisherigen Eingaben und den neuen Fehlermeldungen.
            // Dient dazu, die Seite neu zu laden, damit die Fehlermeldungen angezeigt werden können.
            // with() erlaubt das Übergeben von Daten in einem redirect, ähnlich zu echo view('pages/spalten-erstellen', $data);
            return redirect()
                ->to(base_url('public/spalten-erstellen/' . $todo . (($todo == 'update' || $todo == 'delete') ? '/' . $spaltenId: '')))
                ->with('data', $data);
        }


    }
}
