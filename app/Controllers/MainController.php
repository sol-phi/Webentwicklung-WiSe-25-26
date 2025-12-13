<?php

namespace App\Controllers;

use App\Models\DataModel;

class MainController extends BaseController
{
    protected $dataModel;

    public function __construct()
    {
        $this->dataModel = new DataModel();
    }

    public function getBoards(): void
    {
        $data['boards'] = $this->dataModel->getBoards();
        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/boards', $data);
        echo view('templates/footer');
    }

    public function getSpalten(): void
    {
        $data['spalten'] = $this->dataModel->getSpalten();
        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/spalten', $data);
        echo view('templates/footer');
    }

    public function getPersonen(): void
    {
        $data['personen'] = $this->dataModel->getPersonen();
        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/personen', $data);
        echo view('templates/footer');
    }

    public function getTasks(): void
    {
        $data['tasks'] = $this->dataModel->getTasks();
        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/tasks', $data);
        echo view('templates/footer');
    }

    public function getSpalten_erstellen(): void
    {
        echo view('templates/header');
        echo view('templates/navigation');
        echo view('pages/spalten-erstellen');
        echo view('templates/footer');
    }

}