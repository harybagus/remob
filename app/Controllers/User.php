<?php

namespace App\Controllers;

use App\Models\AuthModel;

class User extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Profil Saya',
            'account' => $this->authModel->getAccount(session()->get('email'))
        ];

        return view('user/index', $data);
    }
}
