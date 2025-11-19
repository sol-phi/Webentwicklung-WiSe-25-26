<?php

namespace App\Controllers;

class Home extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    public function tasks(): void
    {
        echo view('templates/header');
        echo view('templates/navigation');
        echo view('tasks');
        echo view('templates/footer');
    }

    public function boards(): void
    {
        echo view('templates/header');
        echo view('templates/navigation');
        echo view('boards');
        echo view('templates/footer');
    }

    public function spalten(): void
    {
        echo view('templates/header');
        echo view('templates/navigation');
        echo view('spalten');
        echo view('templates/footer');
    }

    public function spalten_erstellen(): void
    {
        echo view('templates/header');
        echo view('templates/navigation');
        echo view('spalten_erstellen');
        echo view('templates/footer');
    }
}
