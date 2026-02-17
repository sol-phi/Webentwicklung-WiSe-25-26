<?php

namespace App\Controllers;

use App\Models\SpaltenModel;

class Spalten extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    private SpaltenModel $spaltenModel;

    public function __construct()
    {
        $this->spaltenModel = new SpaltenModel();
    }

    public function getIndex(): string
    {
        // Daten aus dem Model zum Erzeugen der Tabelle
        $data['spalten'] = $this->spaltenModel->getDatawithBoardNames();

        return view('templates/header').
               view('templates/navigation').
               view('pages/spalten', $data).
               view('templates/footer');
    }


    // Von Ajax nach einem erfolgreichem Drop aufgerufen
    public function postUpdatePosition()
    {
        $data = json_decode($this->request->getBody(), true);

        if(!$data || !isset($data['Order'])){
            return $this->response->setJSON(['success' => false, 'message' => 'No data received']);
        }

        foreach($data['Order'] as $item){
            $this->spaltenModel->updateSpaltenOrder($item['SpaltenID'], $item['SortID']);
        }

        return $this->response->setJSON(['success' => true]);
    }
}