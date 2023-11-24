<?php

namespace App\Controllers;

use App\Models\AuthModel;

class Admin extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'account' => $this->authModel->getAccount(session()->get('email'))
        ];

        return view('admin/index', $data);
    }

    public function account()
    {
        $data = [
            'title' => 'Kelola Akun',
            'account' => $this->authModel->getAccount(session()->get('email')),
            'adminAccount' => $this->authModel->getAdminAccount(session()->get('email'))
        ];

        return view('admin/account', $data);
    }

    public function createAccountAdmin()
    {
        $data = [
            'title' => 'Tambah Data Admin',
            'account' => $this->authModel->getAccount(session()->get('email'))
        ];

        return view('admin/createAccountAdmin', $data);
    }

    public function addAccount()
    {
        if (!$this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[user.email]',
                'errors' => [
                    'required' => 'Alamat email harus diisi.',
                    'valid_email' => 'Alamat email tidak valid.',
                    'is_unique' => 'Alamat email sudah terdaftar.'
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
            return redirect()->to(base_url('admin/createAccount'))->withInput();
        }

        $image = $this->request->getFile('image');
        if ($image->getError() == 4) {
            $imageName = 'default.jpg';
        } else {
            $imageName = $image->getRandomName();
            $image->move('assets/img/profile', $imageName);
        }

        $this->authModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'image' => $imageName,
            'password' => password_hash(123123123, PASSWORD_DEFAULT),
            'role_id' => $this->request->getVar('role-id'),
            'date_created' => time()
        ]);

        session()->setFlashdata('successMessage', 'Data berhasil ditambahkan');
        return redirect()->to(base_url('admin/account'));
    }

    public function updateAccountAdmin($id)
    {
        $data = [
            'title' => 'Ubah Data Admin',
            'account' => $this->authModel->getAccount(session()->get('email')),
            'updatedAccount' => $this->authModel->getAccountById($id)
        ];

        return view('admin/updateAccountAdmin', $data);
    }

    public function editAccount($id)
    {
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
            return redirect()->to(base_url('admin/updateAccount/' . $id))->withInput();
        }

        $image = $this->request->getFile('image');
        if ($image->getError() == 4) {
            $imageName = $this->request->getVar('old-image');
        } else {
            $imageName = $image->getRandomName();
            $image->move('assets/img/profile', $imageName);
            if ($this->request->getVar('old-image') != 'default.jpg') {
                unlink('assets/img/profile/' . $this->request->getVar('old-image'));
            }
        }

        $this->authModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'image' => $imageName
        ]);

        session()->setFlashdata('successMessage', 'Data berhasil diubah');
        return redirect()->to(base_url('admin/account'));
    }

    public function deleteAccount($id)
    {
        $account = $this->authModel->getAccountById($id);

        if ($account['image'] != 'default.jpg') {
            unlink('assets/img/profile/' . $account['image']);
        }

        $this->authModel->delete($id);

        session()->setFlashdata('successMessage', 'Data berhasil dihapus');
        return redirect()->to(base_url('admin/account'));
    }

    public function changePassword()
    {
        $data = [
            'title' => 'Ubah Password',
            'account' => $this->authModel->getAccount(session()->get('email'))
        ];

        return view('admin/changePassword', $data);
    }

    public function change()
    {
        if (!$this->validate([
            'current-password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password saat ini harus diisi.'
                ]
            ],
            'new-password' => [
                'rules' => 'required|min_length[8]|matches[confirm-password]',
                'errors' => [
                    'required' => 'Password baru harus diisi.',
                    'min_length' => 'Password baru harus berisi minimal 8 karakter.',
                    'matches' => 'Password baru dan confirm password tidak sama.'
                ]
            ],
            'confirm-password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Confirm password harus diisi.'
                ]
            ]
        ])) {
            return redirect()->to(base_url('admin/change-password'));
        }

        $account = $this->authModel->getAccount(session()->get('email'));

        $currentPassword = $this->request->getVar('current-password');
        $newPassword = $this->request->getVar('new-password');

        if (!password_verify($currentPassword, $account['password'])) {
            session()->setFlashdata('errorMessage', 'Password saat ini salah!');
            return redirect()->to(base_url('admin/change-password'));
        } else {
            if ($currentPassword == $newPassword) {
                session()->setFlashdata('errorMessage', 'Password saat ini dan password baru tidak boleh sama!');
                return redirect()->to(base_url('admin/change-password'));
            }
        }

        $this->authModel->save([
            'id' => $account['id'],
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        session()->setFlashdata('successMessage', 'Password berhasil diubah');
        return redirect()->to(base_url('admin/change-password'));
    }
}
