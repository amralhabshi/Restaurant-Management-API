<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(RegisterAccountRequest $request)
    {
        $data = $request->validated();

        // نخزن البيانات مؤقتاً في Session
        Session::put('register_step_1', [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $data['phone'],
            'email'      => $data['email'],
            'username'   => $data['username'],
            'password'   => bcrypt($data['password']),
        ]);

        return redirect()
            ->route('register.restaurant.form');
    }
}
