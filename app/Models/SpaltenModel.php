<?php

namespace App\Models;

use CodeIgniter\Model;

class SpaltenModel extends Model
{
    // Gibt alle Spalten zurück, als Default
    public function getData(){
        $this->spalten = $this->db->table('spalten');
        return $this->spalten->select('*')->get()->getResultArray();
    }

    // Gibt alle Spalten von der Spaltentabelle zurück, mit dem Board drauf gejoint für den Namen.
    // Und noch ein orderBy obendrauf, um konsistent mit der Tasks Tabelle zu bleiben
    public function getDataWithBoard(){
        $this->spalten = $this->db->table('spalten');
        return $this->spalten->select('spalten.*, boards.board')->join('boards', 'spalten.boardsid = boards.id')
            ->orderBy('spalte', 'asc')->get()->getResultArray();
    }

    // Gibt alle Spalten zurück, die zu dem einen Board gehören.
    public function getDataFromBoard($boardId){
        $this->spalten = $this->db->table('spalten');
        return $this->spalten->select('*')->where('boardsid', $boardId)->get()->getResultArray();
    }

    // Gibt alle Daten zu der einen Spalte zurück, welcher der übergebenen Spalten-ID entspricht, als RowArray (eindimensional)
    public function getDataFromSpalte($spaltenId){
        $this->spalten = $this->db->table('spalten');
        return $this->spalten->select('*')->where('id', $spaltenId)->get()->getRowArray();
    }

    // Gibt die eine Spalte zurück, zu der dieser Task gehört, als RowArray (eindimensional)
    public function getDataFromTask($taskId){
        $this->spalten = $this->db->table('spalten');
        return $this->spalten->select('spalten.*')->join('tasks', 'spalten.id = tasks.spaltenid')
            ->where('tasks.id', $taskId)->get()->getRowArray();
    }

    public function createSpalte($data){
        $this->spalten = $this->db->table('spalten');
        // Die übergebenen Daten werden an die entsprechenden Spalten der Tabelle 'spalten' in der Datenbank zugewiesen und eingefügt.
        $this->spalten->insert([
            //'id' hat Auto-Increment
            'boardsid'              => $data['BoardID'],
            'sortid'                => $data['SortID'],
            'spalte'                => $data['Bezeichnung'],
            'spaltenbeschreibung'   => $data['Beschreibung'],
        ]);
    }
    public function updateSpalte($data, $spaltenId){
        $this->spalten = $this->db->table('spalten');
        // Die übergebenen Daten werden an die entsprechenden Spalten der Tabelle 'spalten' in der Datenbank zugewiesen und ersetzt.
        $this->spalten->where('id', $spaltenId)->update([
            //'id' nicht nötig, da wir den alten Wert übernehmen
            'boardsid'              => $data['BoardID'],
            'sortid'                => $data['SortID'],
            'spalte'                => $data['Bezeichnung'],
            'spaltenbeschreibung'   => $data['Beschreibung'],
        ]);
    }
    public function deleteSpalte($spaltenId){
        // Es wird nur nach der Spalten-ID gesucht, und dann die entsprechende Zeile gelöscht.
        $this->spalten = $this->db->table('spalten');
        $this->spalten->where('id', $spaltenId)->delete();
    }
}
