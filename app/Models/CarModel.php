<?php

namespace App\Models;

use CodeIgniter\Model;

class CarModel extends Model
{
    protected $table = 'car';
    protected $allowedFields = ['name', 'merk', 'image', 'license_plate', 'seat', 'production_year', 'rental_price_per_day'];

    public function getCar()
    {
        return $this->doFindAll();
    }

    public function getCarById($id)
    {
        return $this->where(['id' => $id])->first();
    }
}
