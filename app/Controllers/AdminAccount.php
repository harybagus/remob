<?php

namespace App\Controllers;

use App\Models\AdminAccountModel;

class AdminAccount extends BaseController
{
    protected $adminAccountModel;

    public function __construct()
    {
        // Membuat object dari model.
        $this->adminAccountModel = new AdminAccountModel();
    }

    public function index()
    {
        /**
         * Membuat title untuk halaman tambah data admin.
         * Mengambil data akun admin berdasarkan email di session ketika berhasil login.
         */
        $data = [
            'title' => 'Tambah Data Admin',
            'account' => $this->adminAccountModel->getAccount(session()->get('email'))
        ];

        // Mengarahkan tampilan ke file create di folder admin/adminAccount, serta mengirim data.
        return view('admin/adminAccount/create', $data);
    }

    public function add()
    {
        // Memvalidasi data yang diinput admin.
        if (!$this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[admin.email]',
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
            // Jika tidak lolos validasi maka redirect ke url admin/account/create.
            return redirect()->to(base_url('admin/account/create'))->withInput();
        }

        // Mengambil file gambar yang diinput admin.
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

        // Masukkan nama, email, gambar dan password(default) ke table admin.
        $this->adminAccountModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'image' => $imageName,
            'password' => password_hash(123123123, PASSWORD_DEFAULT)
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Data berhasil ditambahkan');
        // Lalu redirect ke url admin/account.
        return redirect()->to(base_url('admin/account'));
    }

    public function update($id)
    {
        /**
         * Membuat title untuk halaman ubah data admin.
         * Mengambil data akun admin berdasarkan email di session ketika berhasil login.
         * Mengambil data akun admin yang ingin diubah berdasarkan id.
         */
        $data = [
            'title' => 'Ubah Data Admin',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
            'updatedAccount' => $this->adminAccountModel->getAccountById($id)
        ];

        // Mengarahkan tampilan ke file update di folder admin/adminAccount, serta mengirim data.
        return view('admin/adminAccount/update', $data);
    }

    public function edit($id)
    {
        // Memvalidasi data yang diinput admin.
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
            // Jika tidak lolos validasi maka redirect ke url admin/account/update/$id.
            return redirect()->to(base_url('admin/account/update/' . $id))->withInput();
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

        // Masukkan id, nama dan gambar ke table admin.
        $this->adminAccountModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'image' => $imageName
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Data berhasil diubah');
        // Lalu redirect ke url admin/account.
        return redirect()->to(base_url('admin/account'));
    }

    public function delete($id)
    {
        // Mengambil data admin berdasarkan id.
        $account = $this->adminAccountModel->getAccountById($id);

        // Cek apakah nama gambar bukan default.jpg.
        if ($account['image'] != 'default.jpg') {
            // Jika iya, maka hapus file gambar sesuai nama gambar.
            unlink('assets/img/profile/' . $account['image']);
        }

        // Hapus data admin di table admin berdasarkan id.
        $this->adminAccountModel->delete($id);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Data berhasil dihapus');
        // Lalu redirect ke url admin/account.
        return redirect()->to(base_url('admin/account'));
    }
}
