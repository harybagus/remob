<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'user';
    protected $allowedFields = ['name', 'email', 'image', 'password', 'role_id', 'date_created'];

    public function getAccount($email)
    {
        return $this->where(['email' => $email])->first();
    }

    public function getAdminAccount()
    {
        return $this->where(['role_id' => 1])->doFindAll();
    }
}
