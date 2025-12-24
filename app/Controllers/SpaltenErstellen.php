<?php

namespace App\Controllers;

use App\Models\BoardsModel;

class SpaltenErstellen extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    public function getIndex(): void
    {
        // Daten aus dem Model zum Erzeugen des Dropdowns für die Board-Auswahl
        $boardsModel = new BoardsModel();
        $data['boards'] = $boardsModel->getData();

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/spalten-erstellen', $data);
        echo view('templates/footer');
    }
}
