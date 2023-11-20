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
}
