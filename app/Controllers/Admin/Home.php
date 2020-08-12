<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Home extends Controller
{

    public function dashboardPemasaran()
    {
        return view('template/dashboard-pemasaran');
    }

    public function dashboardTeknik() {
        return view('template/dashboard-teknik');
    }

}