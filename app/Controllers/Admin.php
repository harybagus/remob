<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $sql = 'SELECT * FROM user WHERE email = ?';

        $data = [
            'title' => 'Dashboard',
            'admin' => $db->query($sql, session()->get('email'))->getRowArray()
        ];

        return view('admin/index', $data);
    }
}
