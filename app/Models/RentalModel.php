<?php

namespace App\Models;

use CodeIgniter\Model;

class RentalModel extends Model
{
    protected $table = 'rental';
    protected $allowedFields = ['renter_id', 'car_id', 'rental_price_per_day', 'total_rental_price', 'rental_start', 'rental_end', 'status'];

    public function getRentalData()
    {
        return $this->doFindAll();
    }
}
