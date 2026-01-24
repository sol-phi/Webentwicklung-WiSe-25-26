<?php

namespace App\Controllers;

use App\Models\BoardsModel;

class Boards extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    private BoardsModel $boardsModel;

    public function __construct()
    {
        $this->boardsModel = new BoardsModel();
    }

    public function getIndex(): void
    {
        // Daten aus dem Model zum Erzeugen der Tabelle
        $data['boards'] = $this->boardsModel->getData();

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/boards', $data);
        echo view('templates/footer');
    }
}