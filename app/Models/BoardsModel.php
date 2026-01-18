<?php

namespace App\Models;

use CodeIgniter\Model;

class BoardsModel extends Model
{
    // Gibt alle Boards zurück, als Default
    public function getData(){
        $this->boards = $this->db->table('boards');
        return $this->boards->select('*')->get()->getResultArray();
    }

    // Gibt nur den einen Board mit der entsprechenden ID als RowArray (eindimensional) zurück
    public function getDataFromBoard($boardId){
        $this->boards = $this->db->table('boards');
        return $this->boards->select('*')->where('id', $boardId)->get()->getRowArray();
    }

    // Gibt den einen Board zurück, zu dem diese Spalte gehört, als RowArray (eindimensional)
    public function getDataFromSpalte($spaltenId){
        $this->boards = $this->db->table('boards');
        return $this->boards->select('boards.*')->join('spalten', 'boards.id = spalten.boardsid')
            ->where('spalten.id', $spaltenId)->get()->getRowArray();
    }
}
