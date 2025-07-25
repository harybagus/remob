<?php

namespace Tests\App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\CarModel;

class CarModelTest extends CIUnitTestCase
{
    protected $carModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->carModel = new CarModel();
    }

    public function testInsertCarWithValidData()
    {
        $carData = [
            'name' => 'Avanza',
            'merk' => 'Toyota',
            'transmission' => 'Manual',
            'seat' => 7,
            'number_of_cars' => 3,
            'rental_price_per_day' => 200000,
            'image' => 'avanza.png',
        ];

        $insertedId = $this->carModel->insert($carData);
        $this->assertIsInt($insertedId);
    }

    public function testInsertCarWithEmptyData()
    {
        $this->expectException(\CodeIgniter\Database\Exceptions\DataException::class);
        $this->carModel->insert([]);
    }


    public function testGetCarByIdExists()
    {
        $id = $this->carModel->insert([
            'name' => 'Xenia',
            'merk' => 'Daihatsu',
            'transmission' => 'Manual',
            'seat' => 5,
            'number_of_cars' => 2,
            'rental_price_per_day' => 150000,
            'image' => 'xenia.png',
        ]);

        $car = $this->carModel->getCarById($id);

        $this->assertIsArray($car);
        $this->assertEquals('Xenia', $car['name']);
    }

    public function testGetCarByIdNotFound()
    {
        $car = $this->carModel->getCarById(999999);
        $this->assertNull($car);
    }

    public function testGetTotalCarCount()
    {
        $count = $this->carModel->getNumberOfCars();
        $this->assertIsInt($count);
        $this->assertGreaterThanOrEqual(0, $count);
    }

    public function testCarCountIncreasesAfterInsert()
    {
        $before = $this->carModel->getNumberOfCars();

        $this->carModel->insert([
            'name' => 'Brio',
            'merk' => 'Honda',
            'transmission' => 'Automatic',
            'seat' => 4,
            'number_of_cars' => 5,
            'rental_price_per_day' => 180000,
            'image' => 'brio.png',
        ]);

        $after = $this->carModel->getNumberOfCars();
        $this->assertGreaterThan($before, $after);
    }
}
