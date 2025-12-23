<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model
{
    protected $table = 'tasks';

    public function getData(): array
    {
        $builder = $this->db->table($this->table);
        return $builder->select('*')->get()->getResultArray();
    }

    public function getID(int $id): ?array
    {
        $builder = $this->db->table($this->table);
        $row = $builder->select('*')->where('id', $id)->get()->getRowArray();
        return $row ?: null;
    }

    public function createTask(array $post): int
    {
        $builder = $this->db->table($this->table);

        $data = [
            'tasks'            => trim($post['tasks'] ?? ''),
            'taskartenid'      => isset($post['taskartenid']) ? (int)$post['taskartenid'] : null,
            'personenid'       => isset($post['personenid']) ? (int)$post['personenid'] : null,
            'spaltenid'        => isset($post['spaltenid']) ? (int)$post['spaltenid'] : null,
            'sortid'           => isset($post['sortid']) ? (int)$post['sortid'] : 100,
            'erinnerungsdatum' => $post['erinnerungsdatum'] ?? null, // datetime-string oder null
            'erinnerung'       => isset($post['erinnerung']) ? (int)$post['erinnerung'] : 0,
            'notizen'          => $post['notizen'] ?? '',
            'erledigt'         => isset($post['erledigt']) ? (int)$post['erledigt'] : 0,
            'geloescht'        => isset($post['geloescht']) ? (int)$post['geloescht'] : 0,
            // passend zu deiner Spalte `erstelldatum (date)` nur Datum:
            'erstelldatum'     => date('Y-m-d'),
        ];

        $builder->insert($data);
        return (int) $this->db->insertID();
    }

    public function updateTask(int $id, array $post): bool
    {
        $builder = $this->db->table($this->table);

        $data = [];
        if (isset($post['tasks']))            $data['tasks'] = trim($post['tasks']);
        if (isset($post['taskartenid']))      $data['taskartenid'] = (int)$post['taskartenid'];
        if (isset($post['personenid']))       $data['personenid'] = (int)$post['personenid'];
        if (isset($post['spaltenid']))        $data['spaltenid'] = (int)$post['spaltenid'];
        if (isset($post['sortid']))           $data['sortid'] = (int)$post['sortid'];
        if (array_key_exists('erinnerungsdatum', $post)) $data['erinnerungsdatum'] = $post['erinnerungsdatum'];
        if (isset($post['erinnerung']))       $data['erinnerung'] = (int)$post['erinnerung'];
        if (isset($post['notizen']))          $data['notizen'] = $post['notizen'];
        if (isset($post['erledigt']))         $data['erledigt'] = (int)$post['erledigt'];
        if (isset($post['geloescht']))        $data['geloescht'] = (int)$post['geloescht'];

        if (empty($data)) {
            return false;
        }

        $builder->where('id', $id)->update($data);
        return ($this->db->affectedRows() > 0);
    }

    public function deleteTask(int $id): bool
    {
        $builder = $this->db->table($this->table);
        $builder->where('id', $id)->delete();
        return ($this->db->affectedRows() > 0);
    }
}
