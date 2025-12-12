<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonenModel extends Model
{
    // ...

    public function getData(){
        $this->personen = $this->db->table('personen');
        return $this->personen->select('*')->get()->getResultArray();
    }
}
