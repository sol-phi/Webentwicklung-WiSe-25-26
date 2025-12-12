<?php

namespace App\Models;

use CodeIgniter\Model;

class SpaltenModel extends Model
{
    // ...

    public function getData(){
        $this->personen = $this->db->table('spalten');
        return $this->personen->select('*')->get()->getResultArray();
    }
}
