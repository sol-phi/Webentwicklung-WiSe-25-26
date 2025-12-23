<?php

namespace App\Models;

use CodeIgniter\Model;

class BoardsModel extends Model
{
    // ...

    public function getData(){
        $boards = $this->db->table('boards');
        return $boards->select('*')->get()->getResultArray();
    }
}
