<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\SubcategoryOverseerModel;

class Guru extends BaseController
{
    protected $userModel;
    protected $categoryModel;
    protected $subcategoryOverseerModel;

    public function __construct() 
    {
        $this->userModel = new UserModel();
        $this->categoryModel = new CategoryModel();
        $this->subcategoryOverseerModel = new SubcategoryOverseerModel();
    }

    public function index()
    {
        $data['title'] = "Daftar Guru";
        $data['subtitle'] = "Guru";

        // Get all users who are overseers (gurus)
        $data['guru'] = $this->userModel
            ->join('subcategory_overseer', 'subcategory_overseer.user_id = users.id', 'inner')
            ->join('categories', 'categories.id = subcategory_overseer.category_id', 'left')
            ->select('users.*, GROUP_CONCAT(categories.name SEPARATOR ", ") as kelas_dikelola')
            ->groupBy('users.id')
            ->findAll();

        return view('pages/guru/list', $data);
    }

    public function add()
    {
        $data['title'] = "Tambah Guru";
        $data['subtitle'] = "Guru";

        // Get all categories except admin
        $data['categories'] = $this->categoryModel->where('id !=', '1')->findAll();

        return view('pages/guru/add', $data);
    }

    public function addpost()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[150]',
            'username' => 'required|min_length[3]|max_length[150]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            // 'categories' => 'required' // Removed, check manually
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errname', $this->validator->getError('name'));
            session()->setFlashdata('errusername', $this->validator->getError('username'));
            session()->setFlashdata('errpassword', $this->validator->getError('password'));
            // session()->setFlashdata('errcategories', $this->validator->getError('categories'));
            return redirect()->back()->withInput();
        }

        helper('uuidv4');
        $userId = uuidv4();
        $categories = $this->request->getPost('categories');
        if (empty($categories)) {
            return redirect()->back()->with('error', 'Pilih minimal satu kelas!')->withInput();
        }
        $data = [
            'id' => $userId,
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'category_id' => $categories[0], // Set ke kelas pertama yang dipilih
            'can_login' => '1',
            'active' => '1',
        ];

        if ($this->userModel->insert($data)) {
            // Assign categories to guru
            $categories = $this->request->getPost('categories');
            if (!empty($categories)) {
                foreach ($categories as $catId) {
                    $this->subcategoryOverseerModel->insert([
                        'category_id' => $catId,
                        'user_id' => $userId
                    ]);
                }
            }
            return redirect()->to('guru')->with('success', 'Guru berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal Menyimpan Data User!');
        }
    }

    public function edit($id)
    {
        $data['title'] = "Edit Guru";
        $data['subtitle'] = "Guru";

        $guru = $this->userModel->find($id);
        if (!$guru) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['guru'] = $guru;
        $data['categories'] = $this->categoryModel->where('id !=', '1')->findAll();

        // Get assigned categories
        $assigned = $this->subcategoryOverseerModel->where('user_id', $id)->findAll();
        $data['assigned_categories'] = array_column($assigned, 'category_id');

        return view('pages/guru/edit', $data);
    }

    public function editpost($id)
    {
        $guru = $this->userModel->find($id);
        if (!$guru) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[150]',
            // 'categories' => 'required' // Check manually
        ];

        if ($this->request->getPost('username') != $guru['username']) {
            $rules['username'] = 'required|min_length[3]|max_length[150]|is_unique[users.username]';
        }

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            session()->setFlashdata('errname', $this->validator->getError('name'));
            session()->setFlashdata('errusername', $this->validator->getError('username'));
            session()->setFlashdata('errpassword', $this->validator->getError('password'));
            // session()->setFlashdata('errcategories', $this->validator->getError('categories'));
            return redirect()->back()->withInput();
        }

        $categories = $this->request->getPost('categories');
        if (empty($categories)) {
            return redirect()->back()->with('error', 'Pilih minimal satu kelas!')->withInput();
        }

        $data = [
            'name' => $this->request->getPost('name'),
        ];

        if ($this->request->getPost('username') != $guru['username']) {
            $data['username'] = $this->request->getPost('username');
        }

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($this->userModel->update($id, $data)) {
            // Update assigned categories
            $this->subcategoryOverseerModel->where('user_id', $id)->delete();
            $categories = $this->request->getPost('categories');
            if (!empty($categories)) {
                foreach ($categories as $catId) {
                    $this->subcategoryOverseerModel->insert([
                        'category_id' => $catId,
                        'user_id' => $id
                    ]);
                }
            }
            return redirect()->to('guru')->with('success', 'Guru berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Gagal Update Data!');
        }
    }

    public function delete($id)
    {
        $guru = $this->userModel->find($id);
        if (!$guru) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Delete from subcategory_overseer first
        $this->subcategoryOverseerModel->where('user_id', $id)->delete();

        if ($this->userModel->delete($id)) {
            return redirect()->to('guru')->with('success', 'Guru berhasil dihapus.');
        } else {
            return redirect()->to('guru')->with('error', 'Gagal Hapus Data!');
        }
    }
}