<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\CarModel;

class Admin extends BaseController
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

    public function renterData()
    {
        $data = [
            'title' => 'Data Penyewa',
            'account' => $this->authModel->getAccount(session()->get('email')),
            'renterAccount' => $this->authModel->getRenterAccount(session()->get('email'))
        ];

        return view('admin/renterData', $data);
    }

    public function carData()
    {
        $data = [
            'title' => 'Data Mobil',
            'account' => $this->authModel->getAccount(session()->get('email')),
            'car' => $this->carModel->getCar()
        ];

        return view('admin/carData', $data);
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
