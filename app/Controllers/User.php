<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Profil',
            'user' => session()->get('name')
        ];

        return view('user/index', $data);
    }
}
