<?php

namespace App\Models;

use CodeIgniter\Model;

class RentalModel extends Model
{
    /**
     * Menentukan table dan field yang digunakan.
     */
    protected $table = 'rental';
    protected $allowedFields = ['renter_id', 'car_id', 'rental_price_per_day', 'total_rental_price', 'rental_start', 'rental_end', 'status'];

    /**
     * Mengambil semua data penyewaan.
     */
    public function getRentalData()
    {
        return $this->doFindAll();
    }

    /**
     * Mengambil data penyewaan berdasarkan id.
     */
    public function getRentalDataById($id)
    {
        return $this->where(['id' => $id])->first();
    }

    /**
     * Mengambil jumlah data penyewaan.
     */
    public function getNumberOfRentals()
    {
        return $this->table('rental')->countAllResults();
    }
}
