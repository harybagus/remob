<?php

namespace App\Models;

use CodeIgniter\Model;

class RenterAccountModel extends Model
{
    /**
     * Menentukan table dan field yang digunakan.
     */
    protected $table = 'renter';
    protected $allowedFields = ['name', 'email', 'image', 'password', 'mobile_phone_number', 'ktp_image', 'sim_image', 'balance', 'date_created'];

    /**
     * Mengambil data akun penyewa berdasarkan email.
     */
    public function getAccount($email)
    {
        return $this->where(['email' => $email])->first();
    }

    /**
     * Mengambil data akun penyewa berdasarkan id.
     */
    public function getAccountById($id)
    {
        return $this->where(['id' => $id])->first();
    }

    /**
     * Mengambil semua data akun penyewa.
     */
    public function getAllAccount()
    {
        return $this->doFindAll();
    }

    /**
     * Mengambil jumlah data akun penyewa.
     */
    public function getNumberOfRenters()
    {
        return $this->table('renter')->countAllResults();
    }
}
