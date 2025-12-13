<?php

namespace App\Controllers;

class SpaltenErstellen extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    public function getIndex(): void
    {
        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/spalten-erstellen');
        echo view('templates/footer');
    }
}
