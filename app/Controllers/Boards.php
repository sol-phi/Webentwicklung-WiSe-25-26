<?php

namespace App\Controllers;

use App\Models\BoardsModel;

class Boards extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    public function getIndex(): void
    {
        $boardsModel = new BoardsModel();
        $data['boards'] = $boardsModel->getData();

//        echo("<pre>");
//        var_dump($data['boards']);
//        echo("<pre>");

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/boards', $data);
        echo view('templates/footer');
    }
}
