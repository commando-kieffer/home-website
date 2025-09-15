<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandoNameModel extends Model
{
    protected $table = 'panel_names'; 
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'biography',
        'is_occupied',
        'is_reserved',
    ];

    /**
     * Récupère les points des utilisateurs actifs
     *
     * @return array Liste des utilisateurs actifs sous forme brute
     */
    public function getFreeNames()
    {
        $builder = $this->db->table($this->table);

        $builder->select('name');
        $builder->where('is_reserved = 0 AND name NOT IN (SELECT UPPER(username) FROM `xf_user` WHERE user_group_id BETWEEN 5 and 20 OR user_group_id in (50, 54))');
        $builder->orderBy('name', 'ASC');

        $query = $builder->get();

        return $query->getResultArray();
    }

}
