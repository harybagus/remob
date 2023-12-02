<?php

namespace App\Controllers;

use App\Models\AdminAccountModel;
use App\Models\CarModel;
use App\Models\RentalModel;

class Car extends BaseController
{
    protected $adminAccountModel;
    protected $carModel;
    protected $rentalModel;

    public function __construct()
    {
        $this->adminAccountModel = new AdminAccountModel();
        $this->carModel = new CarModel();
        $this->rentalModel = new RentalModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Tambah Data Mobil',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
        ];

        return view('admin/car/create', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.'
                ]
            ],
            'merk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Merk harus diisi.'
                ]
            ],
            'transmission' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Transmisi harus dipilih.'
                ]
            ],
            'seat' => [
                'rules' => 'required|max_length[1]|greater_than[1]|numeric',
                'errors' => [
                    'required' => 'Jumlah kursi harus diisi.',
                    'max_length' => 'Jumlah kursi maksimal 1 angka.',
                    'greater_than' => 'Jumlah kursi minimal 2.',
                    'numeric' => 'Jumlah kursi harus berisi angka.'
                ]
            ],
            'number-of-cars' => [
                'rules' => 'required|max_length[1]|greater_than[0]|numeric',
                'errors' => [
                    'required' => 'Jumlah mobil harus diisi.',
                    'max_length' => 'Jumlah mobil maksimal 1 angka.',
                    'greater_than' => 'Jumlah mobil minimal 1.',
                    'numeric' => 'Jumlah mobil harus berisi angka.'
                ]
            ],
            'rental-price-per-day' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga sewa / hari harus diisi.'
                ]
            ],
            'image' => [
                'rules' => 'uploaded[image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Anda belum memilih gambar.',
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'Yang Anda pilih bukan gambar.',
                    'mime_in' => 'Yang Anda pilih bukan gambar.'
                ]
            ]
        ])) {
            return redirect()->to(base_url('admin/car/create'))->withInput();
        }

        $price = $this->request->getVar('rental-price-per-day');
        $price = str_replace('Rp', '', $price);
        $price = str_replace('.', '', $price);

        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('assets/img/car', $imageName);

        $this->carModel->save([
            'name' => $this->request->getVar('name'),
            'merk' => $this->request->getVar('merk'),
            'transmission' => $this->request->getVar('transmission'),
            'seat' => $this->request->getVar('seat'),
            'number_of_cars' => $this->request->getVar('number-of-cars'),
            'rental_price_per_day' => $price,
            'image' => $imageName
        ]);

        session()->setFlashdata('successMessage', 'Data berhasil ditambahkan');
        return redirect()->to(base_url('admin/car'));
    }

    public function update($id)
    {
        $data = [
            'title' => 'Ubah Data Mobil',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
            'car' => $this->carModel->getCarById($id)
        ];

        return view('admin/car/update', $data);
    }

    public function edit($id)
    {
        if (!$this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.'
                ]
            ],
            'merk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Merk harus diisi.'
                ]
            ],
            'transmission' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Transmisi harus dipilih.'
                ]
            ],
            'seat' => [
                'rules' => 'required|max_length[1]|greater_than[1]|numeric',
                'errors' => [
                    'required' => 'Jumlah kursi harus diisi.',
                    'max_length' => 'Jumlah kursi maksimal 1 angka.',
                    'greater_than' => 'Jumlah kursi minimal 2.',
                    'numeric' => 'Jumlah kursi harus berisi angka.'
                ]
            ],
            'number-of-cars' => [
                'rules' => 'required|max_length[1]|greater_than[0]|numeric',
                'errors' => [
                    'required' => 'Jumlah mobil harus diisi.',
                    'max_length' => 'Jumlah mobil maksimal 1 angka.',
                    'greater_than' => 'Jumlah mobil minimal 1.',
                    'numeric' => 'Jumlah mobil harus berisi angka.'
                ]
            ],
            'rental-price-per-day' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga sewa / hari harus diisi.'
                ]
            ],
            'image' => [
                'rules' => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'Yang Anda pilih bukan gambar.',
                    'mime_in' => 'Yang Anda pilih bukan gambar.'
                ]
            ]
        ])) {
            return redirect()->to(base_url('admin/car/update/' . $id))->withInput();
        }

        $price = $this->request->getVar('rental-price-per-day');
        $price = str_replace('Rp', '', $price);
        $price = str_replace('.', '', $price);

        $image = $this->request->getFile('image');
        if ($image->getError() == 4) {
            $imageName = $this->request->getVar('old-image');
        } else {
            $imageName = $image->getRandomName();
            $image->move('assets/img/car', $imageName);
            unlink('assets/img/car/' . $this->request->getVar('old-image'));
        }

        $this->carModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'merk' => $this->request->getVar('merk'),
            'transmission' => $this->request->getVar('transmission'),
            'seat' => $this->request->getVar('seat'),
            'number_of_cars' => $this->request->getVar('number-of-cars'),
            'rental_price_per_day' => $price,
            'image' => $imageName
        ]);

        session()->setFlashdata('successMessage', 'Data berhasil diubah');
        return redirect()->to(base_url('admin/car'));
    }

    public function delete($id)
    {
        $car = $this->carModel->getCarById($id);

        unlink('assets/img/car/' . $car['image']);

        $this->carModel->delete($id);

        session()->setFlashdata('successMessage', 'Data berhasil dihapus');
        return redirect()->to(base_url('admin/car'));
    }

    public function rental($id)
    {
        if (!$this->validate([
            'rental-start' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal awal sewa harus diisi.'
                ]
            ]
        ])) {
            return redirect()->to(base_url('renter/car-rental/' . $id))->withInput();
        }

        $rentalPricePerDay = $this->request->getVar('rental-price-per-day');
        $rentalPricePerDay = str_replace('Rp', '', $rentalPricePerDay);
        $rentalPricePerDay = str_replace('.', '', $rentalPricePerDay);

        $this->rentalModel->save([
            'renter_id' => $this->request->getVar('renter-id'),
            'car_id' => $this->request->getVar('car-id'),
            'rental_price_per_day' => $rentalPricePerDay,
            'rental_start' => $this->request->getVar('rental-start'),
            'status' => 0
        ]);

        $car = $this->carModel->getCarById($this->request->getVar('car-id'));
        $numberOfCars = $car['number_of_cars'] - 1;

        $this->carModel->save([
            'id' => $this->request->getVar('car-id'),
            'number_of_cars' => $numberOfCars
        ]);

        session()->setFlashdata('successMessage', 'Selamat, Anda berhasil menyewa mobil, silakan ambil mobil di garasi kami!');
        return redirect()->to(base_url('renter/car'));
    }
}
