<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id', 'name', 'description', 'pengawas_id', 'overseer'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAll()
    {
        return $this->findAll();
    }

    public function getCategoriesWithStudentCount()
    {
        return $this->select('categories.*, COUNT(u.id) as total')
            ->join('users u', 'categories.id = u.category_id', 'left')
            ->whereNotIn('u.id', function($builder) {
                return $builder->select('user_id')
                    ->from('subcategory_overseer')
                    ->where('subcategory_overseer.user_id IS NOT NULL', null, false);
            }, false)
            ->where('categories.id !=', '1')
            ->orderBy('categories.name', 'asc')
            ->groupBy('categories.id')
            ->findAll();
    }

    public function getCategoriesWithStudentCountByUser($userId)
    {
        return $this->select('categories.*, COUNT(u.id) as total')
            ->join('subcategory_overseer', 'categories.id = subcategory_overseer.category_id')
            ->join('users u', 'categories.id = u.category_id', 'left')
            ->whereNotIn('u.id', function($builder) {
                return $builder->select('user_id')
                    ->from('subcategory_overseer')
                    ->where('subcategory_overseer.user_id IS NOT NULL', null, false);
            }, false)
            ->where('subcategory_overseer.user_id', $userId)
            ->orderBy('categories.name', 'asc')
            ->groupBy('categories.id')
            ->findAll();
    }
}