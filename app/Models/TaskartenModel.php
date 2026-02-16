<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskartenModel extends Model
{
    // Gibt alle Spalten zurück, als Default
    public function getData(){
        return $this->db->table('taskarten')->select('*')->get()->getResultArray();
    }

    // Gibt die eine Taskart zurück, die dem Task zugewiesen war, als RowArray (eindimensional)
    public function getDataFromTask($taskId){
        return $this->db->table('taskarten')->select('taskarten.*')->join('tasks', 'taskarten.id = tasks.taskartenid')
            ->where('tasks.id', $taskId)->get()->getRowArray();
    }

    public function getDataFromTaskart($id)
    {
        return $this->db->table('taskarten')->where('id', $id)->get()->getRowArray();
    }

    public function createTask($data)
    {
        return $this->db->table('taskarten')->insert([
            'taskart' => $data['Taskart'],
            'taskartenicon' => $data['TaskartenIcon'] ?? 'fa-solid fa-circle',
        ]);
    }

    public function updateTaskart($data)
    {
        return $this->db->table('taskarten')
            ->where('id', $data['id'])
            ->update([
                'taskart' => $data['Taskart'],
                'taskartenicon' => $data['TaskartenIcon'],
            ]);
    }

    public function deleteTaskart($id)
    {
        return $this->db->table('taskarten')->where('id', $id)->delete();
    }
}