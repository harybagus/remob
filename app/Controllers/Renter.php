<?php

namespace App\Controllers;

use App\Models\RenterAccountModel;

class Renter extends BaseController
{
    protected $renterAccountModelModel;

    public function __construct()
    {
        $this->renterAccountModelModel = new RenterAccountModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Profil Saya',
            'account' => $this->renterAccountModelModel->getAccount(session()->get('email'))
        ];

        return view('renter/myProfile', $data);
    }
}
