<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model
{
    // ...

    public function getData(){
        $tasks = $this->db->table('tasks');
        return $tasks->select('*')->get()->getResultArray();
    }
}
