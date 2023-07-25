<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class InventoryController extends Controller
{
    public function index()
    {
        return view('user.modules.index.index');
    }

    public function employee()
    {
        return view('user.modules.employee.index');
    }

    public function device()
    {
        return view('user.modules.device.index');
    }

    public function package()
    {
        return view('user.modules.package.index');
    }
}
