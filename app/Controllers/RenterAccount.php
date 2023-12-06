<?php

namespace App\Controllers;

use App\Models\AdminAccountModel;
use App\Models\RenterAccountModel;

class RenterAccount extends BaseController
{
    protected $adminAccountModel;
    protected $renterAccountModel;

    public function __construct()
    {
        // Membuat object dari model.
        $this->adminAccountModel = new AdminAccountModel();
        $this->renterAccountModel = new RenterAccountModel();
    }

    public function index()
    {
        /**
         * Membuat title untuk halaman tambah data penyewa.
         * Mengambil data akun penyewa berdasarkan email di session ketika berhasil login.
         */
        $data = [
            'title' => 'Tambah Data Penyewa',
            'account' => $this->adminAccountModel->getAccount(session()->get('email'))
        ];

        // Mengarahkan tampilan ke file create di folder admin/renterAccount, serta mengirim data.
        return view('admin/renterAccount/create', $data);
    }

    public function add()
    {
        // Memvalidasi data yang diinputkan admin.
        if (!$this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[renter.email]',
                'errors' => [
                    'required' => 'Alamat email harus diisi.',
                    'valid_email' => 'Alamat email tidak valid.',
                    'is_unique' => 'Alamat email sudah terdaftar.'
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
            // Jika tidak lolos validasi maka redirect ke url admin/renter/create.
            return redirect()->to(base_url('admin/renter/create'))->withInput();
        }

        // Mengambil file gambar yang diinputkan.
        $image = $this->request->getFile('image');

        // Cek apakah admin tidak meng-upload gambar.
        if ($image->getError() == 4) {
            // Jika iya, maka tentukan nama file gambar.
            $imageName = 'default.jpg';
        } else {
            // Jika tidak, maka buat nama random untuk nama gambar.
            $imageName = $image->getRandomName();
            // Lalu pindahkan file gambar yang diinput ke dalam folder profile.
            $image->move('assets/img/profile', $imageName);
        }

        // Memasukkan nama, email, gambar, password(default) dan tanggal dibuat ke table renter.
        $this->renterAccountModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'image' => $imageName,
            'password' => password_hash(321321321, PASSWORD_DEFAULT),
            'date_created' => time()
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Data berhasil ditambahkan');
        // Lalu redirect ke url admin/renter.
        return redirect()->to(base_url('admin/renter'));
    }

    public function update($id)
    {
        /**
         * Membuat title untuk halaman ubah data penyewa.
         * Mengambil data akun penyewa berdasarkan email di session ketika berhasil login.
         * Mengambil data akun penyewa yang ingin diubah berdasarkan id.
         */
        $data = [
            'title' => 'Ubah Data Penyewa',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
            'updatedAccount' => $this->renterAccountModel->getAccountById($id)
        ];

        // Mengarahkan tampilan ke file update di folder admin/renterAccount, serta mengirim data.
        return view('admin/renterAccount/update', $data);
    }

    public function edit($id)
    {
        // Memvalidasi data yang diinputkan admin.
        if (!$this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi.'
                ]
            ],
            'image' => [
                'rules' => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'Yang Anda pilih bukan gambar.',
                    'mime_in' => 'Yang Anda pilih bukan gambar.'
                ]
            ]
        ])) {
            // Jika tidak lolos validasi maka redirect ke url admin/renter/update/id.
            return redirect()->to(base_url('admin/renter/update/' . $id))->withInput();
        }

        // Mengambil file gambar yang diinput admin.
        $image = $this->request->getFile('image');

        // Cek apakah admin tidak meng-upload gambar.
        if ($image->getError() == 4) {
            // Jika iya, maka tentukan nama file gambar sesuai dengan nama file gambar yang lama.
            $imageName = $this->request->getVar('old-image');
        } else {
            // Jika tidak, maka buat nama random untuk nama gambar.
            $imageName = $image->getRandomName();
            // Lalu pindahkan file gambar yang diinput ke dalam folder profile.
            $image->move('assets/img/profile', $imageName);

            // Cek apakah nama gambar lama bukan defualt.jpg.
            if ($this->request->getVar('old-image') != 'default.jpg') {
                // Jika iya, maka hapus file gambar di folder profile berdasarkan nama gambar lama.
                unlink('assets/img/profile/' . $this->request->getVar('old-image'));
            }
        }

        // Masukkan id, nama dan gambar ke table renter.
        $this->renterAccountModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'image' => $imageName
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Data berhasil diubah');
        // Lalu redirect ke url admin/renter.
        return redirect()->to(base_url('admin/renter'));
    }

    public function delete($id)
    {
        // Mengambil data akun penyewa berdasarkan id.
        $account = $this->renterAccountModel->getAccountById($id);

        // Cek apakah gambar ktp tidak kosong.
        if ($account['ktp_image'] != '') {
            // Jika iya, maka hapus file gambar di folder ktp sesuai nama gambar.
            unlink('assets/img/ktp/' . $account['ktp_image']);

            // Cek apakah gambar sim tidak kosong.
        } elseif ($account['sim_image'] != '') {
            // Jika iya, maka hapus file gambar di folder sim sesuai nama gambar.
            unlink('assets/img/sim/' . $account['sim_image']);

            // Cek apakah gambar profil tidak kosong.
        } elseif ($account['image'] != 'default.jpg') {
            // Jika iya, maka hapus file gambar di folder profile sesuai nama gambar.
            unlink('assets/img/profile/' . $account['image']);
        }

        // Hapus data penyewa di table renter berdasarkan id.
        $this->renterAccountModel->delete($id);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Data berhasil dihapus');
        // Lalu redirect ke url admin/renter.
        return redirect()->to(base_url('admin/renter'));
    }
}
