<?php

namespace App\Controllers;

use App\Models\BoardsModel;

class Boards extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    public function getIndex(): void
    {
        // Daten aus dem Model zum Erzeugen der Tabelle
        $boardsModel = new BoardsModel();
        $data['boards'] = $boardsModel->getData();

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/boards', $data);
        echo view('templates/footer');
    }
}
