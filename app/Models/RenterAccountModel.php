<?php

namespace App\Models;

use CodeIgniter\Model;

class RenterAccountModel extends Model
{
    protected $table = 'renter';
    protected $allowedFields = ['name', 'email', 'image', 'password', 'date_created'];

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