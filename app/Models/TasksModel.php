<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model
{
    // Gibt alle Tasks zurück, als Default
    public function getData(){
        return $this->db->table('tasks')->select('*')->orderBy('tasks', 'asc')->get()->getResultArray();
    }

    // Gibt alle Tasks zurück, die zu dem einen Board gehören.
    // Dafür müssen wir die Spalten mit joinen, um auf den Board zugreifen zu können, zu dem die Tasks alle gehören.
    // Und noch ein orderBy nach sortID obendrauf, für die Drag-und-Drop-Funktionalität.
    public function getDataFromBoard($boardId){
        return $this->db->table('tasks')->select('tasks.*')->join('spalten', 'tasks.spaltenid = spalten.id')
            ->where('boardsid', $boardId)->orderBy('sortid', 'asc')->get()->getResultArray();
    }

    // Gibt alle Daten zu dem einen Task zurück, welcher der übergebenen Task-ID entspricht, als RowArray (eindimensional)
    public function getDataFromTask($taskId){
        return $this->db->table('tasks')->select('tasks.*')->where('id', $taskId)->get()->getRowArray();
    }

    // CRUD
    public function createTask($data){

        // Ermittelt die höchste SortID in der Spalte, und macht die SortID dann um eins höher, sodass neue Tasks immer unten dran gehangen werden.
        $maxSortId = $this->db->table('tasks')
            ->selectMax('sortid')
            ->where('spaltenid', $data['SpaltenID'])
            ->get()
            ->getRowArray()['sortid'];

        // Die übergebenen Daten werden an die entsprechenden Spalten der Tabelle 'tasks' in der Datenbank zugewiesen und eingefügt.
        $this->db->table('tasks')->insert([
            //'id' hat Auto-Increment
            'personenid'          => $data['PersonID'],
            'taskartenid'         => $data['TaskartID'],
            'spaltenid'           => $data['SpaltenID'],
            'sortid'              => empty($maxSortId) ? 0 : $maxSortId + 1,
            'tasks'               => $data['Bezeichnung'],
            'erstelldatum'        => date('Y-m-d'), // Timestamp des aktuellen Datums
            'erinnerungsdatum'    => $data['Erinnerungsdatum'],
            'erinnerung'          => $data['Erinnerung'],
            'notizen'             => $data['Notizen'],
            'erledigt'            => 0,
            'geloescht'           => 0,
        ]);
    }
    public function updateTask($data, $taskId){
        // Die übergebenen Daten werden an die entsprechenden Spalten der Tabelle 'tasks' in der Datenbank zugewiesen und ersetzt.
        $this->db->table('tasks')->where('id', $taskId)->update([
            //'id' nicht nötig, da wir den alten Wert übernehmen
            'personenid'          => $data['PersonID'],
            'taskartenid'         => $data['TaskartID'],
            'spaltenid'           => $data['SpaltenID'],
            // SortID ist eine interne Variable für Drag und Drop, der Benutzer kann sie gar nicht ändern
            //'sortid'              => $data['SortID'],
            'tasks'               => $data['Bezeichnung'],
            // Erstelldatum soll sich beim Bearbeiten nicht ändern. Vielleicht stattdessen ein 'Letztes Update' Feld hinzufügen?
            //'erstelldatum'        => date('Y-m-d'),
            'erinnerungsdatum'    => $data['Erinnerungsdatum'],
            'erinnerung'          => $data['Erinnerung'],
            'notizen'             => $data['Notizen'],
            //'erledigt'            => 0,
            //'geloescht'           => 0,
        ]);
    }

    // Äquivalent zu updateTask, aber einfach mit weniger Daten. Von der Drag-and-Drop-Funktionalität verwendet
    public function updateTaskWithSpaltenId($data, $taskId){
        $this->db->table('tasks')->where('id', $taskId)->update([
            'spaltenid'           => $data['SpaltenID'],
        ]);
    }
    // Analog
    public function updateTasksWithOrder($data, $taskId){
        $this->db->table('tasks')->where('id', $taskId)->update([
            'sortid'              => $data['SortID'],
        ]);
    }

    public function deleteTask($taskId){
        // Es wird nur nach der Task-ID gesucht, und dann die entsprechende Zeile gelöscht.
        $this->db->table('tasks')->where('id', $taskId)->delete();
    }

}
