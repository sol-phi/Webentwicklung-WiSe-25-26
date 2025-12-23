<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonenModel extends Model
{
    // ...

    public function getData(){
        $personen = $this->db->table('personen');
        return $personen->select('*')->get()->getResultArray();
    }
}
