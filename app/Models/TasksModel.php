<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model
{
    // Gibt alle Tasks zurück, als Default
    public function getData(){
        $this->tasks = $this->db->table('tasks');
        return $this->tasks->select('*')->orderBy('tasks', 'asc')->get()->getResultArray();
    }

    // Gibt alle Tasks zurück, die zu dem einen Board gehören.
    // Dafür müssen wir die Spalten mit joinen, um auf den Board zugreifen zu können, zu dem die Tasks alle gehören.
    // Und noch ein orderBy obendrauf, entsprechend Aufgabenstellung von Übung 5
    public function getDataFromBoard($boardId){
        $this->tasks = $this->db->table('tasks');
        return $this->tasks->select('tasks.*')->join('spalten', 'tasks.spaltenid = spalten.id')
            ->where('boardsid', $boardId)->orderBy('tasks', 'asc')->get()->getResultArray();
    }

    // Gibt alle Daten zu dem einen Task zurück, welcher der übergebenen Task-ID entspricht, als RowArray (eindimensional)
    public function getDataFromTask($taskId){
        $this->tasks = $this->db->table('tasks');
        return $this->tasks->select('tasks.*')->where('id', $taskId)->get()->getRowArray();
    }

    // CRUD
    public function createTask($data){
        $this->tasks = $this->db->table('tasks');
        // Die übergebenen Daten werden an die entsprechenden Spalten der Tabelle 'tasks' in der Datenbank zugewiesen und eingefügt.
        $this->tasks->insert([
            //'id' hat Auto-Increment
            'personenid'          => $data['PersonID'],
            'taskartenid'         => $data['TaskartID'],
            'spaltenid'           => $data['SpaltenID'],
            'sortid'              => $data['SortID'],
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
        $this->tasks = $this->db->table('tasks');
        // Die übergebenen Daten werden an die entsprechenden Spalten der Tabelle 'tasks' in der Datenbank zugewiesen und ersetzt.
        $this->tasks->where('id', $taskId)->update([
            //'id' nicht nötig, da wir den alten Wert übernehmen
            'personenid'          => $data['PersonID'],
            'taskartenid'         => $data['TaskartID'],
            'spaltenid'           => $data['SpaltenID'],
            'sortid'              => $data['SortID'],
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
    public function deleteTask($taskId){
        // Es wird nur nach der Task-ID gesucht, und dann die entsprechende Zeile gelöscht.
        $this->tasks = $this->db->table('tasks');
        $this->tasks->where('id', $taskId)->delete();
    }
}
