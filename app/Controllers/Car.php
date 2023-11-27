<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\CarModel;

class Car extends BaseController
{
    protected $authModel;
    protected $carModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
        $this->carModel = new CarModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Tambah Data Mobil',
            'account' => $this->authModel->getAccount(session()->get('email')),
            'car' => $this->carModel->getCar()
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
            'license-plate' => [
                'rules' => 'required|max_length[11]',
                'errors' => [
                    'required' => 'Nomor polisi harus diisi.',
                    'max_length' => 'Nomor polisi maksimal 11 karakter'
                ]
            ],
            'seat' => [
                'rules' => 'required|max_length[1]|numeric',
                'errors' => [
                    'required' => 'Jumlah kursi harus diisi.',
                    'max_length' => 'Jumlah kursi maksimal 1 angka',
                    'numeric' => 'Jumlah kursi harus berisi angka'
                ]
            ],
            'production-year' => [
                'rules' => 'required|max_length[4]|min_length[4]|numeric',
                'errors' => [
                    'required' => 'Tahun produksi harus diisi.',
                    'max_length' => 'Tahun produksi maksimal 4 angka',
                    'min_length' => 'Tahun produksi minimal 4 angka',
                    'numeric' => 'Tahun produksi harus berisi angka'
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
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang Anda pilih bukan gambar',
                    'mime_in' => 'Ekstensi file tidak diizinkan'
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
            'license_plate' => $this->request->getVar('license-plate'),
            'seat' => $this->request->getVar('seat'),
            'production_year' => $this->request->getVar('production-year'),
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
            'account' => $this->authModel->getAccount(session()->get('email')),
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
            'license-plate' => [
                'rules' => 'required|max_length[11]',
                'errors' => [
                    'required' => 'Nomor polisi harus diisi.',
                    'max_length' => 'Nomor polisi maksimal 11 karakter'
                ]
            ],
            'seat' => [
                'rules' => 'required|max_length[1]|numeric',
                'errors' => [
                    'required' => 'Jumlah kursi harus diisi.',
                    'max_length' => 'Jumlah kursi maksimal 1 angka',
                    'numeric' => 'Jumlah kursi harus berisi angka'
                ]
            ],
            'production-year' => [
                'rules' => 'required|max_length[4]|min_length[4]|numeric',
                'errors' => [
                    'required' => 'Tahun produksi harus diisi.',
                    'max_length' => 'Tahun produksi maksimal 4 angka',
                    'min_length' => 'Tahun produksi minimal 4 angka',
                    'numeric' => 'Tahun produksi harus berisi angka'
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
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang Anda pilih bukan gambar',
                    'mime_in' => 'Ekstensi file tidak diizinkan'
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
            'license_plate' => $this->request->getVar('license-plate'),
            'seat' => $this->request->getVar('seat'),
            'production_year' => $this->request->getVar('production-year'),
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
}
