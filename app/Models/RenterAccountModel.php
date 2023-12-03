<?php

namespace App\Models;

use CodeIgniter\Model;

class RenterAccountModel extends Model
{
    protected $table = 'renter';
    protected $allowedFields = ['name', 'email', 'image', 'password', 'mobile_phone_number', 'ktp_image', 'sim_image', 'balance', 'date_created'];

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

    public function getNumberOfRenters()
    {
        return $this->table('renter')->countAllResults();
    }
}
