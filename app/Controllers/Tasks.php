<?php

namespace App\Controllers;

use App\Models\BoardsModel;
use App\Models\PersonenModel;
use App\Models\SpaltenModel;
use App\Models\TaskartenModel;
use App\Models\TasksModel;

class Tasks extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    private BoardsModel $boardsModel;
    private TasksModel $tasksModel;
    private SpaltenModel $spaltenModel;
    private TaskartenModel $taskartenModel;
    private PersonenModel $personenModel;

    public function __construct()
    {
        $this->boardsModel = new BoardsModel();
        $this->tasksModel = new TasksModel();
        $this->spaltenModel = new SpaltenModel();
        $this->taskartenModel = new TaskartenModel();
        $this->personenModel = new PersonenModel();
    }

    // Wenn nur /tasks aufgerufen wird, wird man automatisch zur Card-Ansicht des ersten Boards weitergeleitet.
    // Tasks in Tabellenansicht, im Stil von den Board-, Spalten- und Personenansichten in der Navigation.
    public function getIndex()
    {
        // Boards geladen für den Fallback aufs erste verfügbare Board bei URL-Manipulationen bei Redirects zurück zu Cards, und zum Anzeigen
        $data['boards'] = $this->boardsModel->getData();
        $data['tasks'] = $this->tasksModel->getData();
        // Folgende Daten geladen, damit dessen Bezeichnungen zu dem Task angezeigt werden können.
        $data['spalten'] = $this->spaltenModel->getData();
        $data['taskarten'] = $this->taskartenModel->getData();
        $data['personen'] = $this->personenModel->getData();

        return view('templates/header').
               view('templates/navigation').
               view('pages/tasks', $data).
               view('templates/footer');
    }

    // Von Ajax nach einem erfolgreichem Drop aufgerufen
    public function postUpdatePosition()
    {
        $data = json_decode($this->request->getBody(), true);

        if(!$data){ // Wenn aus irgendeinem Grund nichts seitens Ajax ankommt
            return $this->response->setJSON(['success' => false, 'message' => 'No data']);
        }

        // $data beinhält TaskID, SpaltenID und den Array Order, welcher aber hier nicht genutzt wird.
        $this->tasksModel->updateTaskWithSpaltenId($data, $data['TaskID']);

        // Alle Tasks in der Zielspalte werden geupdatet, durch Lesen aus dem Order Array. $item beinhält TaskID und SortID.
        foreach($data['Order'] as $item){
            $this->tasksModel->updateTasksOrder($item, $item['TaskID']);
        }

        // Falls wir bis hier keine Fehler kriegen, muss es geklappt haben
        return $this->response->setJSON(['success' => true]);
    }
}
