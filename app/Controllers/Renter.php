<?php

namespace App\Controllers;

use App\Models\RenterAccountModel;

class Renter extends BaseController
{
    protected $renterAccountModel;

    public function __construct()
    {
        $this->renterAccountModel = new RenterAccountModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Profil Saya',
            'account' => $this->renterAccountModel->getAccount(session()->get('email'))
        ];

        return view('renter/myProfile', $data);
    }
}
