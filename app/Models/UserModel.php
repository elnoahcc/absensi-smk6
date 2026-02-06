<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id', 'id_fingerprint', 'name', 'username', 'email', 'password', 'category_id','can_login','active'];

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


    public function getAllAdmin()
    {
        return $this->where('users.category_id', '1')->orderBy('created_at')->findAll();
    }

    public function getByIdAdmin($id)
    {
        return $this->find($id);
    }

    public function getAllStudents()
    {
        return $this->select('users.*, categories.name as category_name')
            ->join('categories', 'categories.id = users.category_id', 'left')
            ->whereNotIn('users.id', function($builder) {
                return $builder->select('user_id')
                    ->from('subcategory_overseer')
                    ->where('subcategory_overseer.user_id IS NOT NULL', null, false);
            })
            ->where('users.category_id !=', '1')
            ->orderBy('ISNULL(users.id_fingerprint)', 'ASC')
            ->orderBy('users.id_fingerprint', 'ASC')
            ->findAll();
    }

    public function getStudentsByCategory($categoryIds = [])
    {
        $query = $this->select('users.*, categories.name as category_name')
            ->join('categories', 'categories.id = users.category_id', 'left')
            ->whereNotIn('users.id', function($builder) {
                return $builder->select('user_id')
                    ->from('subcategory_overseer')
                    ->where('subcategory_overseer.user_id IS NOT NULL', null, false);
            })
            ->where('users.category_id !=', '1');

        if (!empty($categoryIds)) {
            $query->whereIn('users.category_id', $categoryIds);
        }

        return $query
            ->orderBy('ISNULL(users.id_fingerprint)', 'ASC')
            ->orderBy('users.id_fingerprint', 'ASC')
            ->findAll();
    }

    public function getStudentsByCategoryId($categoryId)
    {
        return $this->select('users.*')
            ->whereNotIn('users.id', function($builder) {
                return $builder->select('user_id')
                    ->from('subcategory_overseer')
                    ->where('subcategory_overseer.user_id IS NOT NULL', null, false);
            })
            ->where('users.category_id', $categoryId)
            ->where('users.category_id !=', '1')
            ->orderBy('users.name', 'ASC')
            ->findAll();
    }

    public function getStudentsByCategoryIdWithAttendance($categoryId)
    {
        return $this->select("users.*, COALESCE(attendances.status, 'Tidak Hadir') as status")
            ->whereNotIn('users.id', function($builder) {
                return $builder->select('user_id')
                    ->from('subcategory_overseer')
                    ->where('subcategory_overseer.user_id IS NOT NULL', null, false);
            })
            ->where('users.category_id', $categoryId)
            ->where('users.category_id !=', '1')
            ->join('attendances', 'users.id = attendances.user_id AND DATE(attendances.created_at) = CURDATE()', 'Left')
            ->orderBy('users.name', 'ASC')
            ->findAll();
    }

    //Admin Validation Function Start
    public function admin_insert_valid()
    {
        $validation_rules = [
            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 3 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 100 karakter.',
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[8]|max_length[30]|is_unique[users.username]|no_space',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 8 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 30 karakter.',
                    'is_unique' => 'Username sudah digunakan.',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[30]|no_space',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 8 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 30 karakter.',
                ]
            ]
        ];
        return $validation_rules;
    }

    public function admin_update_valid_with_usernamepass()
    {
        $validation_rules = [
            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 3 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 100 karakter.',
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[8]|max_length[30]|is_unique[users.username]|no_space',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 8 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 30 karakter.',
                    'is_unique' => 'Username sudah digunakan.',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[30]|no_space',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 8 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 30 karakter.',
                ]
            ]
        ];
        return $validation_rules;
    }

    public function admin_update_valid_with_username()
    {
        $validation_rules = [
            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 3 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 100 karakter.',
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[8]|max_length[30]|is_unique[users.username]|no_space',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 8 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 30 karakter.',
                    'is_unique' => 'Username sudah digunakan.',
                ]
            ],
            'password' => [
                'rules' => 'permit_empty|min_length[8]|max_length[30]|no_space',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 8 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 30 karakter.',
                ]
            ]
        ];
        return $validation_rules;
    }

    public function admin_update_valid()
    {
        $validation_rules = [
            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 3 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 100 karakter.',
                ]
            ],
            'password' => [
                'rules' => 'permit_empty|min_length[8]|max_length[30]|no_space',
                'errors' => [
                    'min_length' => 'Harus memiliki minimal 8 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 30 karakter.',
                ]
            ]
        ];
        return $validation_rules;
    }
 
    //Admin validation function end

    //User validation
    public function user_insert_valid_login() {
        $validation_rules = [
            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 3 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 100 karakter.',
                ]
            ],
            'category' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus diisi.',
                ]
            ],
            'id_fingerprint' => [
                'rules' => 'permit_empty|is_unique[users.id_fingerprint]|numeric',
                'errors' => [
                    'is_unique' => 'ID Fingerprint sudah digunakan.',
                    'numeric'   => 'ID Fingerprint hanya berupa angka.'
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[users.username]|min_length[8]|max_length[30]|no_space',
                'errors'=> [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 8 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 30 karakter.',
                    'is_unique' => 'Username sudah digunakan.',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[30]|no_space',
                'errors'=> [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 8 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 30 karakter.',
                ]
            ]
        ];
        return $validation_rules;
    }

    public function user_insert_valid() {
        $validation_rules = [
            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 3 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 100 karakter.',
                ]
            ],
            'category' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus diisi.',
                ]
            ],
            'id_fingerprint' => [
                'rules' => 'permit_empty|is_unique[users.id_fingerprint]|numeric',
                'errors' => [
                    'is_unique' => 'ID Fingerprint sudah digunakan.',
                    'numeric'   => 'ID Fingerprint hanya berupa angka.'
                ]
            ]
        ];
        return $validation_rules;
    }

    public function rulesuser_update() {
        $validation_rules = [
            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Harus diisi.',
                    'min_length' => 'Harus memiliki minimal 3 karakter.',
                    'max_length' => 'Tidak boleh lebih dari 100 karakter.',
                ]
            ],
            'category' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus diisi.',
                ]
            ]
        ];
        return $validation_rules;
    }

    public function rulesuser_usernamenotunique()
    {
        $rules = [
            'rules' => 'required|min_length[8]|max_length[30]|no_space',
            'errors' => [
                'required' => 'Harus diisi.',
                'min_length' => 'Harus memiliki minimal 8 karakter.',
                'max_length' => 'Tidak boleh lebih dari 30 karakter.',
            ]
        ];
        return $rules;
    }

    public function rulesuser_usernameunique()
    {
        $rules = [
            'rules' => 'required|is_unique[users.username]|min_length[8]|max_length[30]|no_space',
            'errors' => [
                'required' => 'Harus diisi.',
                'min_length' => 'Harus memiliki minimal 8 karakter.',
                'max_length' => 'Tidak boleh lebih dari 30 karakter.',
                'is_unique' => 'Username sudah digunakan.',
            ]
        ];
        return $rules;
    }

    public function rulesuser_passrequire()
    {
        $rules = [
            'rules' => 'required|min_length[8]|max_length[30]|no_space',
            'errors'=> [
                'required' => 'Harus diisi.',
                'min_length' => 'Harus memiliki minimal 8 karakter.',
                'max_length' => 'Tidak boleh lebih dari 30 karakter.',
            ],
        ];

        return $rules;
    }

    public function rulesuser_passpermitempty()
    {
        $rules = [
            'rules' => 'permit_empty|min_length[8]|max_length[30]|no_space',
            'errors'=> [
                'min_length' => 'Harus memiliki minimal 8 karakter.',
                'max_length' => 'Tidak boleh lebih dari 30 karakter.',
            ],
        ];

        return $rules;
    }

    public function rulesuser_idfingerunique()
    {
        $rules = [
            'rules' => 'permit_empty|is_unique[users.id_fingerprint]|numeric',
            'errors' => [
                'is_unique' => 'ID Fingerprint sudah digunakan.',
                'numeric'   => 'ID Fingerprint hanya berupa angka.'
            ]
        ];

        return $rules;
    }

    public function rulesuser_idfingernotunique()
    {
        $rules = [
            'rules' => 'permit_empty|numeric',
            'errors' => [
                'numeric'   => 'ID Fingerprint hanya berupa angka.'
            ]
        ];

        return $rules;
    }
    //User validation end
}