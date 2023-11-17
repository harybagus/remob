<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $sql = 'SELECT * FROM user WHERE email = ?';

        $data = [
            'title' => 'Profil Saya',
            'user' => $db->query($sql, session()->get('email'))->getRowArray()
        ];

        return view('user/index', $data);
    }
}
