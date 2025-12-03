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
        $db = \Config\Database::connect();
        $builder = $db->table('spalten');
        $builder->select('spalten.*, boards.board');
        $builder->join('boards', 'boards.id = spalten.boardsid');
        $builder->orderBy('spalten.sortid', 'ASC');

        $query = $builder->get();
        $data['spalten'] = $query->getResultArray();

        echo view('templates/header');
        echo view('templates/navigation');
        echo view('spalten', $data);
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
