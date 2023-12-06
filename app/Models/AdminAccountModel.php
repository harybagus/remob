<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminAccountModel extends Model
{
    /**
     * Menentukan table dan field yang digunakan.
     */
    protected $table = 'admin';
    protected $allowedFields = ['name', 'email', 'image', 'password'];

    /**
     * Mengambil data akun admin berdasarkan email.
     */
    public function getAccount($email)
    {
        return $this->where(['email' => $email])->first();
    }

    /**
     * Mengambil data akun admin berdasarkan id.
     */
    public function getAccountById($id)
    {
        return $this->where(['id' => $id])->first();
    }

    /**
     * Mengambil semua data akun admin.
     */
    public function getAllAccount()
    {
        return $this->doFindAll();
    }

    /**
     * Mengambil jumlah data akun admin.
     */
    public function getNumberOfAdmins()
    {
        return $this->table('admin')->countAllResults();
    }
}
