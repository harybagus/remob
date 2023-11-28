<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminAccountModel extends Model
{
    protected $table = 'admin';
    protected $allowedFields = ['name', 'email', 'image', 'password'];

    public function getAccount($email)
    {
        return $this->where(['email' => $email])->first();
    }

    public function getAccountById($id)
    {
        return $this->where(['id' => $id])->first();
    }

    public function getAllAccount()
    {
        return $this->doFindAll();
    }
}
