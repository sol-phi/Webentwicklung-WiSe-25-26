<?php

namespace App\Models;

use CodeIgniter\Model;

class BoardsModel extends Model
{
    // ...

    public function getData(){
        $this->personen = $this->db->table('boards');
        return $this->personen->select('*')->get()->getResultArray();
    }
}
