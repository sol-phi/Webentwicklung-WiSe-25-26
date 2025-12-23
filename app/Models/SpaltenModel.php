<?php

namespace App\Models;

use CodeIgniter\Model;

class SpaltenModel extends Model
{
    // ...

    public function getData(){
        $spalten = $this->db->table('spalten');
        return $spalten->select('*')->get()->getResultArray();
    }
}
