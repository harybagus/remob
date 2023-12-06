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
        // Membuat object dari model.
        $this->adminAccountModel = new AdminAccountModel();
        $this->renterAccountModel = new RenterAccountModel();
    }

    public function index()
    {
        // Membuat title untuk halaman login.
        $data['title'] = "Login";
        // Mengarahkan tampilan ke file login di folder auth, serta mengirim data.
        return view('auth/login', $data);
    }

    public function login()
    {
        // Memvalidasi data yang diinput user(admin/penyewa).
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
            // Jika tidak lolos validasi maka redirect ke url auth.
            return redirect()->to(base_url('auth'))->withInput();
        }

        // Mengambil email yang diinput user.
        $email = $this->request->getVar('email');
        // Mengambil password yang diinput user.
        $password = $this->request->getVar('password');

        // Koneksi ke database.
        $db = db_connect();

        // Membuat query mengambil data admin berdasarkan email yang diinputkan.
        $sqlAccountAdmin = 'SELECT * FROM admin WHERE email = ?';
        // Membuat query mengambil data penyewa berdasarkan email yang diinputkan.
        $sqlAccountRenter = 'SELECT * FROM renter WHERE email = ?';

        // Mengambil data admin.
        $accountAdmin = $db->query($sqlAccountAdmin, $email)->getRowArray();
        // Mengambil data penyewa.
        $accountRenter = $db->query($sqlAccountRenter, $email)->getRowArray();

        // Cek apakah ada akun admin/penyewa di database.
        if ($accountAdmin || $accountRenter) {
            // Jika iya, maka cek apakah akun yang login admin atau penyewa
            if ($accountAdmin) {
                // Jika admin, maka cek apakah password akun admin dan password yang diinputkan admin sama.
                if (password_verify($password, $accountAdmin['password'])) {
                    /**
                     * Jika iya..
                     * Buat data email berdasarkan email admin.
                     * Buat data role yaitu admin.
                     */
                    $data = [
                        'email' => $accountAdmin['email'],
                        'role' => 'admin'
                    ];

                    // Atur data session.
                    session()->set($data);
                    // Lalu redirect ke url admin.
                    return redirect()->to(base_url('admin'));
                } else {
                    // Jika tidak, maka buat flash data error.
                    session()->setFlashdata('errorMessage', 'Password salah!');
                    // Lalu redirect ke url auth.
                    return redirect()->to(base_url('auth'))->withInput();
                }
            } else {
                // Jika penyewa, maka cek apakah password akun penyewa dan password yang diinputkan penyewa sama.
                if (password_verify($password, $accountRenter['password'])) {
                    /**
                     * Jika iya..
                     * Buat data email berdasarkan email penyewa.
                     * Buat data role yaitu renter(penyewa).
                     */
                    $data = [
                        'email' => $accountRenter['email'],
                        'role' => 'renter'
                    ];

                    // Atur data session.
                    session()->set($data);
                    // Lalu redirect ke url renter.
                    return redirect()->to(base_url('renter'));
                } else {
                    // Jika tidak, maka buat flash data error.
                    session()->setFlashdata('errorMessage', 'Password salah!');
                    // Lalu redirect ke url auth.
                    return redirect()->to(base_url('auth'))->withInput();
                }
            }
        } else {
            // Jika tidak, maka buat flash data error.
            session()->setFlashdata('errorMessage', 'Email belum terdaftar!');
            // Lalu redirect ke url auth.
            return redirect()->to(base_url('auth'))->withInput();
        }
    }

    public function registration()
    {
        // Membuat title untuk halaman registrasi.
        $data['title'] = "Registration";
        // Mengarahkan tampilan ke file registration di folder auth, serta mengirim data.
        return view('auth/registration', $data);
    }

    public function create()
    {
        // Memvalidasi data yang diinput user(admin/penyewa).
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
            // Jika tidak lolos validasi maka redirect ke url auth/registration.
            return redirect()->to(base_url('auth/registration'))->withInput();
        }

        // Masukkan nama, email, password, gambar(default) dan tanggal dibuat ke table renter.
        $this->renterAccountModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'image' => 'default.jpg',
            'date_created' => time()
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Selamat, Anda berhasil membuat akun! silakan login');
        // Lalu redirect ke url auth.
        return redirect()->to(base_url('auth'));
    }

    public function logout()
    {
        // Hapus session email dan role.
        session()->remove('email');
        session()->remove('role');

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Anda telah logout! terimakasih sudah mengunjungi ReMob');
        // Lalu redirect ke url auth.
        return redirect()->to(base_url('auth'));
    }
}
