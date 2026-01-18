<?php

namespace App\Controllers;

use App\Models\SpaltenModel;

class Spalten extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    public function getIndex(): void
    {
        // Daten aus dem Model zum Erzeugen der Tabelle
        $spaltenModel = new SpaltenModel();
        $data['spalten'] = $spaltenModel->getDataWithBoard();

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/spalten', $data);
        echo view('templates/footer');
    }
}
