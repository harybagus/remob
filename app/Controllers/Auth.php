<?php

namespace App\Controllers;

use App\Models\AuthModel;

class Auth extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
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
                'rules' => 'required|trim|valid_email',
                'errors' => [
                    'required' => 'Alamat email harus diisi.',
                    'valid_email' => 'Alamat email tidak valid.'
                ]
            ],
            'password' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Password harus diisi.'
                ]
            ]
        ])) {
            return redirect()->to(base_url('/auth'))->withInput();
        }

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $db = db_connect();

        $sql = 'SELECT * FROM user WHERE email = ?';
        $user = $db->query($sql, $email)->getRowArray();

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data['name'] = $user['name'];
                    session()->set($data);
                    return redirect()->to(base_url('/'))->withInput();
                } else {
                    session()->setFlashdata('errorMessage', 'Password salah!');
                    return redirect()->to(base_url('/auth'))->withInput();
                }
            } else {
                session()->setFlashdata('errorMessage', 'Email belum diaktivasi!');
                return redirect()->to(base_url('/auth'))->withInput();
            }
        } else {
            session()->setFlashdata('errorMessage', 'Email belum terdaftar!');
            return redirect()->to(base_url('/auth'))->withInput();
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
                'rules' => 'required|valid_email|is_unique[user.email]',
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
            return redirect()->to(base_url('/auth/registration'))->withInput();
        }

        $this->authModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'image' => 'default.jpg',
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'is_active' => 1,
            'date_created' => time()
        ]);

        session()->setFlashdata('successMessage', 'Selamat, Anda berhasil membuat akun! silakan aktivasi');
        return redirect()->to(base_url('/auth'));
    }

    public function logout()
    {
        session()->remove('email');
        session()->remove('role_id');

        session()->setFlashdata('successMessage', 'Anda telah logout! terimakasih sudah mengunjungi ReMob');
        return redirect()->to(base_url('/auth'));
    }
}
