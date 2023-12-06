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
        // Membuat object dari model.
        $this->adminAccountModel = new AdminAccountModel();
        $this->carModel = new CarModel();
        $this->rentalModel = new RentalModel();
    }

    public function index()
    {
        /**
         * Membuat title untuk halaman tambah data mobil.
         * Mengambil data akun admin berdasarkan email di session ketika berhasil login.
         */
        $data = [
            'title' => 'Tambah Data Mobil',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
        ];

        // Mengarahkan tampilan ke file create di folder admin/car, serta mengirim data.
        return view('admin/car/create', $data);
    }

    public function add()
    {
        // Memvalidasi data yang diinput admin.
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
            // Jika tidak lolos validasi maka redirect ke url admin/car/create.
            return redirect()->to(base_url('admin/car/create'))->withInput();
        }

        /**
         * Mengambil harga rental mobil yang diinputkan.
         * Membersihkan dari karakter selain angka.
         */
        $price = $this->request->getVar('rental-price-per-day');
        $price = str_replace('Rp', '', $price);
        $price = str_replace('.', '', $price);

        /**
         * Mengambil file gambar yang diinputkan.
         * Membuat nama random untuk nama gambar.
         * Pindahkan file gambar ke foler car.
         */
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('assets/img/car', $imageName);

        // Memasukkan nama, merk, transmisi, jumlah kursi, jumlah mobil, harga rental / hari dan nama gambar ke table car.
        $this->carModel->save([
            'name' => $this->request->getVar('name'),
            'merk' => $this->request->getVar('merk'),
            'transmission' => $this->request->getVar('transmission'),
            'seat' => $this->request->getVar('seat'),
            'number_of_cars' => $this->request->getVar('number-of-cars'),
            'rental_price_per_day' => $price,
            'image' => $imageName
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Data berhasil ditambahkan');
        // Lalu redirect ke url admin/car.
        return redirect()->to(base_url('admin/car'));
    }

    public function update($id)
    {
        /**
         * Membuat title untuk halaman ubah data mobil.
         * Mengambil data akun admin berdasarkan email di session ketika berhasil login.
         * Mengambil data mobil berdasarkan id.
         */
        $data = [
            'title' => 'Ubah Data Mobil',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
            'car' => $this->carModel->getCarById($id)
        ];

        // Mengarahkan tampilan ke file update di folder admin/car, serta mengirim data.
        return view('admin/car/update', $data);
    }

    public function edit($id)
    {
        // Memvalidasi data yang diinput admin.
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
            // Jika tidak lolos validasi maka redirect ke url admin/car/update/id.
            return redirect()->to(base_url('admin/car/update/' . $id))->withInput();
        }

        /**
         * Mengambil harga rental mobil yang diinputkan.
         * Membersihkan dari karakter selain angka.
         */
        $price = $this->request->getVar('rental-price-per-day');
        $price = str_replace('Rp', '', $price);
        $price = str_replace('.', '', $price);

        /**
         * Mengambil file gambar yang diinputkan.
         * Membuat nama random untuk nama gambar.
         * Pindahkan file gambar ke foler assets/img/car.
         */
        // Mengambil file gambar yang diinputkan.
        $image = $this->request->getFile('image');

        // Cek apakah apakah admin tidak meng-upload gambar.
        if ($image->getError() == 4) {
            // Jika iya, maka tentukan nama file gambar sesuai dengan nama file gambar yang lama.
            $imageName = $this->request->getVar('old-image');
        } else {
            // Jika tidak, maka buat nama random untuk nama gambar.
            $imageName = $image->getRandomName();
            // Lalu pindahkan file gambar yang diinput ke dalam folder car.
            $image->move('assets/img/car', $imageName);
            // Hapus file gambar di folder car berdasarkan nama gambar lama.
            unlink('assets/img/car/' . $this->request->getVar('old-image'));
        }

        // Masukkan id, nama, merk, transmisi, jumlah kursi, jumlah mobil, harga rental / hari dan nama gambar ke table car.
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

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Data berhasil diubah');
        // Lalu redirect ke url admin/car.
        return redirect()->to(base_url('admin/car'));
    }

    public function delete($id)
    {
        // Mengambil data mobil berdasarkan id.
        $car = $this->carModel->getCarById($id);

        // Hapus file gambar di folder car sesuai nama gambar.
        unlink('assets/img/car/' . $car['image']);

        // Hapus data mobil di table car berdasarkan id.
        $this->carModel->delete($id);

        // Buat flash data success
        session()->setFlashdata('successMessage', 'Data berhasil dihapus');
        // Lalu redirect ke url admin/car.
        return redirect()->to(base_url('admin/car'));
    }

    public function rental($id)
    {
        // Memvalidasi tanggal awal sewa yang diinputkan penyewa.
        if (!$this->validate([
            'rental-start' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal awal sewa harus diisi.'
                ]
            ]
        ])) {
            // Jika tidak lolos validasi maka redirect ke url renter/car-rental/id.
            return redirect()->to(base_url('renter/car-rental/' . $id))->withInput();
        }

        /**
         * Mengambil harga rental / hari dari form readonly.
         * Membersihkan dari karakter selain angka.
         */
        $rentalPricePerDay = $this->request->getVar('rental-price-per-day');
        $rentalPricePerDay = str_replace('Rp', '', $rentalPricePerDay);
        $rentalPricePerDay = str_replace('.', '', $rentalPricePerDay);

        // Memasukkan id penyewa, id mobil, harga rental / hari, tanggal awal sewa dan status ke table rental.
        $this->rentalModel->save([
            'renter_id' => $this->request->getVar('renter-id'),
            'car_id' => $this->request->getVar('car-id'),
            'rental_price_per_day' => $rentalPricePerDay,
            'rental_start' => $this->request->getVar('rental-start'),
            'status' => 0
        ]);

        // Mengambil data mobil berdasarkan id mobil.
        $car = $this->carModel->getCarById($this->request->getVar('car-id'));
        // Kurangi 1 jumlah mobil.
        $numberOfCars = $car['number_of_cars'] - 1;

        // Memasukkan id, jumlah mobil ke table car.
        $this->carModel->save([
            'id' => $this->request->getVar('car-id'),
            'number_of_cars' => $numberOfCars
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Selamat, Anda berhasil menyewa mobil, silakan ambil mobil di garasi kami!');
        // Lalu redirect ke url renter/car.
        return redirect()->to(base_url('renter/car'));
    }

    public function carReturn($id)
    {
        /**
         * Membuat title untuk halaman pengembalian mobil.
         * Mengambil data akun admin berdasarkan email di session ketika berhasil login.
         * Mengambil data penyewaan berdasarkan id.
         */
        $data = [
            'title' => 'Pengembalian Mobil',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
            'rental' => $this->rentalModel->getRentalDataById($id)
        ];

        // Mengarahkan tampilan ke file carReturn di folder admin, serta mengirim data.
        return view('admin/carReturn', $data);
    }

    public function return($id)
    {
        // Memvalidasi tanggal akhir sewa yang diinputkan admin.
        if (!$this->validate([
            'rental-end' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal akhir sewa harus diisi.'
                ]
            ]
        ])) {
            // Jika tidak lolos validasi maka redirect ke url admin/car-return/id.
            return redirect()->to(base_url('admin/car-return/' . $id))->withInput();
        }

        // Mengambil tanggal awal sewa dari form readonly.
        $rentalStart = $this->request->getVar('rental-start');
        // Mengambil tanggal akhir sewa yang diinput.
        $rentalEnd = $this->request->getVar('rental-end');

        // Cek apakah tanggal awal sewa lebih lama dari akhir sewa.
        if (strtotime($rentalStart) > strtotime($rentalEnd)) {
            // Jika iya, maka buat flash data error.
            session()->setFlashdata('errorMessage', 'Tanggal akhir sewa tidak boleh kurang dari tanggal awal sewa.');
            // Lalu redirect ke url admin/car-return/id.
            return redirect()->to(base_url('admin/car-return/' . $id));
        }

        /**
         * Menghitung berapa hari selisih antara tanggal awal sewa dengan akhir sewa.
         */
        $rentalStart = date_create($rentalStart);
        $rentalEnd = date_create($rentalEnd);
        $interval = date_diff($rentalStart, $rentalEnd);
        $day = $interval->format('%a') + 1;

        /**
         * Mengambil harga rental / hari dari form readonly.
         * Membersihkan dari karakter selain angka.
         */
        $rentalPricePerDay = $this->request->getVar('rental-price-per-day');
        $rentalPricePerDay = str_replace('Rp', '', $rentalPricePerDay);
        $rentalPricePerDay = str_replace('.', '', $rentalPricePerDay);

        // Kalikan harga rental / hari dengan jumlah hari sewa.
        $totalRentalPrice = intval($rentalPricePerDay) * $day;

        // Masukkan data id, id penyewa, id mobil, harga rental / hari, total harga rental, tanggal awal sewa, tanggal akhir sewa dan status ke table rental.
        $this->rentalModel->save([
            'id' => $id,
            'renter_id' => $this->request->getVar('renter-id'),
            'car_id' => $this->request->getVar('car-id'),
            'rental_price_per_day' => $rentalPricePerDay,
            'total_rental_price' => $totalRentalPrice,
            'rental_start' => $this->request->getVar('rental-start'),
            'rental_end' => $this->request->getVar('rental-end'),
            'status' => 1
        ]);

        // Mengambil data mobil berdasarkan id.
        $car = $this->carModel->getCarById($this->request->getVar('car-id'));
        // Tambahkan 1 jumlah mobil.
        $numberOfCars = $car['number_of_cars'] + 1;

        // Memasukkan id, jumlah mobil ke table car.
        $this->carModel->save([
            'id' => $this->request->getVar('car-id'),
            'number_of_cars' => $numberOfCars
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Berhasil mengembalikan mobil');
        // Lalu redirect ke url admin/rental.
        return redirect()->to(base_url('admin/rental'));
    }
}
