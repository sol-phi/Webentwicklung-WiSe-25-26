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
}
