<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;

class RoleAwareAuthenticationResponse implements LoginResponse, RegisterResponse
{
    public function toResponse($request)
    {
        return redirect()->to($request->user()->getDashboardUrl());
    }
}
