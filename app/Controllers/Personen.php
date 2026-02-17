<?php

namespace App\Controllers;

use App\Models\PersonenModel;

class Personen extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    private PersonenModel $personenModel;

    public function __construct()
    {
        $this->personenModel = new PersonenModel();
    }

    public function getIndex(): string
    {
        // Daten aus dem Model zum Erzeugen der Tabelle
        $data['personen'] = $this->personenModel->getData();

        return view('templates/header').
               view('templates/navigation').
               view('pages/personen', $data).
               view('templates/footer');
    }
}