<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        $role = Auth::user()->role;

        if ($role == 'admin' || $role == 'author') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home.main');
        }
    }
}
