<?php

namespace App\Models;

use CodeIgniter\Model;

class CarModel extends Model
{
    /**
     * Menentukan table dan field yang digunakan.
     */
    protected $table = 'car';
    protected $allowedFields = ['name', 'merk', 'image', 'transmission', 'seat', 'number_of_cars', 'rental_price_per_day'];

    /**
     * Mengambil semua data mobil.
     */
    public function getCar()
    {
        return $this->doFindAll();
    }

    /**
     * Mengambil data mobil berdasarkan id.
     */
    public function getCarById($id)
    {
        return $this->where(['id' => $id])->first();
    }

    /**
     * Mengambil jumlah data mobil.
     */
    public function getNumberOfCars()
    {
        return $this->table('car')->countAllResults();
    }
}
