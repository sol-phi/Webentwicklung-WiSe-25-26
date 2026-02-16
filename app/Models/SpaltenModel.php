<?php

namespace App\Models;

use CodeIgniter\Model;

class SpaltenModel extends Model
{
    // Gibt alle Spalten zurück, als Default
    public function getData(){
        return $this->db->table('spalten')->select('*')->get()->getResultArray();
    }

    // Gibt alle Spalten zurück, mit Namen der zugehörigen Boards, anstatt ID's
    public function getDatawithBoardNames(){
        // Join auf boards, Board-Name als 'board' auswählen
        return $this->db->table('spalten')
            ->select('spalten.*, boards.board AS board')
            ->join('boards', 'spalten.boardsid = boards.id', 'left')
            ->get()
            ->getResultArray();
    }

    //Gibt die die passende Spalte zur übergebenen SpaltenID zurück
    public function getDataFromSpalte($spaltenId){
        return $this->db->table('spalten')
            ->select('spalten.*')
            ->where('id', $spaltenId)
            ->get()
            ->getRowArray();
    }


    // Gibt alle Spalten zurück, die zu dem einen Board gehören.
    public function getDataFromBoard($boardId){
        return $this->db->table('spalten')
            ->select('*')
            ->where('boardsid', $boardId)
            ->orderBy('sortid', 'ASC') // <-- Sortierung für Drag & Drop
            ->get()
            ->getResultArray();
    }

    // Gibt die eine Spalte zurück, zu der dieser Task gehört, als RowArray (eindimensional)
    public function getDataFromTask($taskId){
        return $this->db->table('spalten')->select('spalten.*')->join('tasks', 'spalten.id = tasks.spaltenid')
            ->where('tasks.id', $taskId)->get()->getRowArray();
    }

    // CRUD
    public function createSpalte($data){
        $this->db->table('spalten')->insert([
            //'id' hat Auto-Increment
            'boardsid'            => $data['Board'],
            'sortid'              => $data['SortID'],
            'spalte'              => $data['Bezeichnung'],
            'spaltenbeschreibung' => $data['Beschreibung'],
        ]);
    }
    public function updateSpalte($data){
        $this->db->table('spalten')->where('id', $data['spaltenId'])->update([
            'boardsid'            => $data['Board'],
            'sortid'              => $data['SortID'],
            'spalte'              => $data['Bezeichnung'],
            'spaltenbeschreibung' => $data['Beschreibung'],
        ]);
    }
    public function deleteSpalte($data){
        $this->db->table('spalten')->where('id', $data['spaltenId'])->delete();
    }

    // Zum Abfangen von Deletes, wenn in der Spalte noch Tasks drin sind (Datenbank Referenzintegrität ist Restrict anstatt Cascade)
    public function hasTasks($spaltenId): bool {
        return $this->db->table('tasks')
                ->where('spaltenid', $spaltenId)
                ->countAllResults() > 0;
    }

    public function updateSpalteSortId($id, $sortId)
    {
        return $this->db->table('spalten')->where('id', $id)->update(['sortid' => $sortId]);
    }
}
