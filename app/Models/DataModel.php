<?php

namespace App\Models;

use CodeIgniter\Model;

class DataModel extends Model
{

    protected function getTableData(string $table): array
    {
        return $this->db->table($table)
            ->select('*')
            ->get()
            ->getResultArray();
    }

    public function getPersonen(): array
    {
        return $this->getTableData('personen');
    }

    public function getBoards(): array
    {
        return $this->getTableData('boards');
    }

    public function getSpalten(): array
    {
        return $this->getTableData('spalten');
    }

    public function getTasks(): array
    {
        return $this->getTableData('tasks');
    }
}