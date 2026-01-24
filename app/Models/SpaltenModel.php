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

    // Gibt alle Spalten zurück, mit Namen der zugehörigen Boards, anstatt ID's
    public function getDatawithBoardNames(){
        $this->spalten = $this->db->table('spalten');

        // Join auf boards, Board-Name als 'board' auswählen
        $rows = $this->spalten
            ->select('spalten.*, boards.board AS board')
            ->join('boards', 'spalten.boardsid = boards.id', 'left')
            ->get()
            ->getResultArray();
        return $rows;
    }

    //Gibt die die passende Spalte zur übergebenen SpaltenID zurück
    public function getDataFromSpalte($spaltenId){
        $this->spalten = $this->db->table('spalten');
        return $this->spalten
            ->select('spalten.*')
            ->where('id', $spaltenId)
            ->get()
            ->getRowArray();
    }


    // Gibt alle Spalten zurück, die zu dem einen Board gehören.
    public function getDataFromBoard($boardId){
        $this->spalten = $this->db->table('spalten');
        return $this->spalten->select('*')->where('boardsid', $boardId)->get()->getResultArray();
    }

    // Gibt die eine Spalte zurück, zu der dieser Task gehört, als RowArray (eindimensional)
    public function getDataFromTask($taskId){
        $this->spalten = $this->db->table('spalten');
        return $this->spalten->select('spalten.*')->join('tasks', 'spalten.id = tasks.spaltenid')
            ->where('tasks.id', $taskId)->get()->getRowArray();
    }

    // CRUD
    public function createSpalte($data){
        $this->spalten = $this->db->table('spalten');
        $this->spalten->insert([
            //'id' hat Auto-Increment
            'boardsid'            => $data['Board'],
            'sortid'              => $data['SortID'],
            'spalte'              => $data['Bezeichnung'],
            'spaltenbeschreibung' => $data['Beschreibung'],
        ]);
    }
    public function updateSpalte($data){
        $this->spalten = $this->db->table('spalten');
        $this->spalten->where('id', $data['spaltenId'])->update([
            'boardsid'            => $data['Board'],
            'sortid'              => $data['SortID'],
            'spalte'              => $data['Bezeichnung'],
            'spaltenbeschreibung' => $data['Beschreibung'],
        ]);
    }
    public function deleteSpalte($data){
        $this->spalten = $this->db->table('spalten');
        $this->spalten->where('id', $data['spaltenId'])->delete();
    }
}
