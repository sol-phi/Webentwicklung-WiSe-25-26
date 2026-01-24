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

    // CRUD
    public function createBoard($data){
        $this->boards = $this->db->table('boards');
        $this->boards->insert([
            //'id' hat Auto-Increment
            'board' => $data['Bezeichnung'],
        ]);
    }
    public function updateBoard($data){
        $this->boards = $this->db->table('boards');
        $this->boards->where('id', $data['boardId'])->update([
            'board' => $data['Bezeichnung'],
        ]);
    }
    public function deleteBoard($data){
        $this->boards = $this->db->table('boards');
        $this->boards->where('id', $data['boardId'])->delete();
    }
}
