<?php

namespace App\Controllers;

use App\Models\SpaltenModel;

class Spalten extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    public function getIndex(): void
    {

        $spaltenModel = new SpaltenModel();
        $data['spalten'] = $spaltenModel->getData();

//        echo("<pre>");
//        var_dump($data['spalten']);
//        echo("<pre>");

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/spalten', $data);
        echo view('templates/footer');
    }
}
