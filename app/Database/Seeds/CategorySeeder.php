<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'          => '2',
                'name'        => 'Guru',
                'description' => 'Guru mengelola kelas dan absensi siswa.',
            ],
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}
