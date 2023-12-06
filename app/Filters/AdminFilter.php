<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah tidak ada session email.
        if (!session()->get('email')) {
            // Jika iya, maka buat flash data error.
            session()->setFlashdata('errorMessage', 'Anda belum login! silakan login terlebih dahulu.');
            // Lalu redirect ke url auth.
            return redirect()->to(base_url('auth'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Cek apakah session role adalah admin.
        if (session()->get('role') == 'admin') {
            // Jika iya, maka redirect ke url admin.
            return redirect()->to(base_url('admin'));
        }
    }
}
