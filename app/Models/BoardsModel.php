<?php

namespace App\Models;

use CodeIgniter\Model;

class BoardsModel extends Model
{
    // Gibt alle Boards zurück, als Default
    public function getData(){
        return $this->db->table('boards')->select('*')->get()->getResultArray();
    }

    // Gibt nur den einen Board mit der entsprechenden ID als RowArray (eindimensional) zurück
    public function getDataFromBoard($boardId){
        return $this->db->table('boards')->select('*')->where('id', $boardId)->get()->getRowArray();
    }

    // CRUD
    public function createBoard($data){
        $this->db->table('boards')->insert([
            //'id' hat Auto-Increment
            'board' => $data['Bezeichnung'],
        ]);
    }
    public function updateBoard($data){
        $this->db->table('boards')->where('id', $data['boardId'])->update([
            'board' => $data['Bezeichnung'],
        ]);
    }
    public function deleteBoard($data){
        $this->db->table('boards')->where('id', $data['boardId'])->delete();
    }

    // Zum Abfangen von Deletes, wenn in dem Board noch Spalten drin sind (Datenbank Referenzintegrität ist Restrict anstatt Cascade)
    public function hasSpalten($boardId): bool {
        return $this->db->table('spalten')
                ->where('boardsid', $boardId)
                ->countAllResults() > 0;
    }
}
