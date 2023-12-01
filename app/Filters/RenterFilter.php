<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RenterFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('email')) {
            session()->setFlashdata('errorMessage', 'Anda belum login! silakan login terlebih dahulu.');
            return redirect()->to(base_url('auth'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (session()->get('role') == 'renter') {
            return redirect()->to(base_url('renter'));
        }
    }
}
