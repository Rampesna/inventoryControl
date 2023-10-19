<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class DeviceController extends Controller
{
    public function index()
    {
        return view('user.modules.device.index.index');
    }

    public function history($encodedId)
    {
        return view('user.modules.device.history.index', [
            'encodedId' => $encodedId
        ]);
    }
}
