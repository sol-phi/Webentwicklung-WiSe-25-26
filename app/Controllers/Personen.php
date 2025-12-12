<?php

namespace App\Controllers;

use App\Models\PersonenModel;

class Personen extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    public function getIndex(): void
    {
        $personenModel = new PersonenModel();
        $data['personen'] = $personenModel->getData();

//        echo("<pre>");
//        var_dump($data['personen']);
//        echo("<pre>");

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/personen', $data);
        echo view('templates/footer');


    }


}
