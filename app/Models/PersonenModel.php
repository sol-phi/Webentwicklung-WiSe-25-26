<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonenModel extends Model
{
    // Gibt alle Personen zurück, als Default
    public function getData(){
        $this->personen = $this->db->table('personen');
        return $this->personen->select('*')->orderBy('name', 'asc')->get()->getResultArray();
    }

    // Gibt alle Daten zu der einen Person zurück, welcher der übergebenen PersonenID entspricht, als RowArray (eindimensional)
    public function getDataFromPerson($personId){
        $this->personen = $this->db->table('personen');
        return $this->personen->select('*')->where('id', $personId)->get()->getRowArray();
    }

    // Gibt alle Personen zurück, die zu dem einen Board gehören.
    // Joins über Tasks und Spalten, notwendig, um Personen ihrem Board zuzuordnen.
    // distinct() notwendig, damit jede Person nur einmal zurückgegeben wird, auch wenn sie mehreren Tasks zugewiesen ist.
    public function getDataFromBoard($boardId){
        $this->personen = $this->db->table('personen');
        return $this->personen->distinct()->select('personen.*')->join('tasks', 'personen.id = tasks.personenid')
            ->join('spalten', 'tasks.spaltenid = spalten.id')
            ->where('spalten.boardsid', $boardId)->get()->getResultArray();
    }

    // Gibt die eine Person zurück, die dem Task zugewiesen war, als RowArray (eindimensional)
    public function getDataFromTask($taskId){
        $this->personen = $this->db->table('personen');
        return $this->personen->select('personen.*')->join('tasks', 'personen.id = tasks.personenid')
            ->where('tasks.id', $taskId)->get()->getRowArray();
    }

    // CRUD
    public function createPerson($data){
        $this->personen = $this->db->table('personen');
        $this->personen->insert([
            //'id' hat Auto-Increment
            'vorname'  => $data['Vorname'],
            'name'     => $data['Nachname'],
            'email'    => $data['EMail'],
            'passwort' => $data['Passwort'],
        ]);
    }
    public function updatePerson($data){
        $this->personen = $this->db->table('personen');
        $this->personen->where('id', $data['personenId'])->update([
            'vorname'  => $data['Vorname'],
            'name'     => $data['Nachname'],
            'email'    => $data['EMail'],
            'passwort' => $data['Passwort'],
        ]);
    }
    public function deletePerson($data){
        $this->personen = $this->db->table('personen');
        $this->personen->where('id', $data['personenId'])->delete();
    }
}
