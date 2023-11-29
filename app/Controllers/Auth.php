<?php

namespace App\Controllers;

use App\Models\AdminAccountModel;
use App\Models\RenterAccountModel;

class Auth extends BaseController
{
    protected $adminAccountModel;
    protected $renterAccountModel;

    public function __construct()
    {
        $this->adminAccountModel = new AdminAccountModel();
        $this->renterAccountModel = new RenterAccountModel();
    }

    public function index()
    {
        $data['title'] = "Login";
        return view('auth/login', $data);
    }

    public function login()
    {
        if (!$this->validate([
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Alamat email harus diisi.',
                    'valid_email' => 'Alamat email tidak valid.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi.'
                ]
            ]
        ])) {
            return redirect()->to(base_url('auth'))->withInput();
        }

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $db = db_connect();

        $sqlAccountAdmin = 'SELECT * FROM admin WHERE email = ?';
        $sqlAccountRenter = 'SELECT * FROM renter WHERE email = ?';

        $accountAdmin = $db->query($sqlAccountAdmin, $email)->getRowArray();
        $accountRenter = $db->query($sqlAccountRenter, $email)->getRowArray();

        if ($accountAdmin || $accountRenter) {
            if ($accountAdmin) {
                if (password_verify($password, $accountAdmin['password'])) {
                    $data = [
                        'email' => $accountAdmin['email'],
                        'role' => 'admin'
                    ];
                    session()->set($data);
                    return redirect()->to(base_url('admin'));
                } else {
                    session()->setFlashdata('errorMessage', 'Password salah!');
                    return redirect()->to(base_url('auth'))->withInput();
                }
            } else {
                if (password_verify($password, $accountRenter['password'])) {
                    $data = [
                        'email' => $accountRenter['email'],
                        'role' => 'renter'
                    ];
                    session()->set($data);
                    return redirect()->to(base_url('renter'));
                } else {
                    session()->setFlashdata('errorMessage', 'Password salah!');
                    return redirect()->to(base_url('auth'))->withInput();
                }
            }
        } else {
            session()->setFlashdata('errorMessage', 'Email belum terdaftar!');
            return redirect()->to(base_url('auth'))->withInput();
        }
    }

    public function registration()
    {
        $data['title'] = "Registration";
        return view('auth/registration', $data);
    }

    public function create()
    {
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
            'password' => [
                'rules' => 'required|min_length[8]|matches[confirm-password]',
                'errors' => [
                    'required' => 'Password harus diisi.',
                    'min_length' => 'Password harus berisi minimal 8 karakter.',
                    'matches' => 'Password dan confirm password tidak sama.'
                ]
            ],
            'confirm-password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Confirm password harus diisi.'
                ]
            ]
        ])) {
            return redirect()->to(base_url('auth/registration'))->withInput();
        }

        $this->renterAccountModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'image' => 'default.jpg',
            'date_created' => time()
        ]);

        session()->setFlashdata('successMessage', 'Selamat, Anda berhasil membuat akun! silakan login');
        return redirect()->to(base_url('auth'));
    }

    public function logout()
    {
        session()->remove('email');
        session()->remove('role');

        session()->setFlashdata('successMessage', 'Anda telah logout! terimakasih sudah mengunjungi ReMob');
        return redirect()->to(base_url('auth'));
    }
}
