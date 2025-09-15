<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table = 'gallery'; 
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'name',
        'category',
        'description',
        'url',
    ];

    /**
     * Récupère les points des utilisateurs actifs
     *
     * @return array Liste des utilisateurs actifs sous forme brute
     */
    public function getCategories()
    {
        $builder = $this->db->table("gallery_category");

        $builder->select('id, slug, name, short_description');
        $builder->orderBy('id', 'DESC');

        return $builder->get()->getResultObject();
    }

    /**
     * Récupère les médailles des utilisateurs actifs
     *
     * @return array Liste des utilisateurs actifs avec leurs médailles
     */
    public function getPicturesOfCategory($cat_slug)
    {
        
        $builder = $this->db->table("gallery");

        $builder->select('id, name, description, url');
        $builder->where('category', $cat_slug, true);
        $builder->orderBy('id', 'ASC');

        return $builder->get()->getResultObject();
    }

}
