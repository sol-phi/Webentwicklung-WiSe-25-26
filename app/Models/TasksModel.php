<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model
{
    // ...

    public function getData(){
        $this->personen = $this->db->table('tasks');
        return $this->personen->select('*')->get()->getResultArray();
    }
}
