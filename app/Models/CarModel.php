<?php

namespace App\Models;

use CodeIgniter\Model;

class CarModel extends Model
{
    protected $table = 'car';
    protected $allowedFields = ['name', 'merk', 'image', 'license_plate', 'seat', 'production_year'];

    public function getCar()
    {
        return $this->doFindAll();
    }
}
