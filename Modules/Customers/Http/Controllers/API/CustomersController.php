<?php

namespace Modules\Customers\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Customers\Http\Requests\CustomerRequest;
use App\Models\User;

class CustomersController extends Controller
{
    public function login(CustomerRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->where('type', 'Customer')->first();
        if(!empty($user) && Hash::check($request->password, $user->password)) {
            $accessToken = $user->createToken('authToken')->plainTextToken;
            return jsonResponse(1,[
                'name' => $user->name,
                'email' => $user->email,
                'token' => $accessToken
            ]);
        } else {
            return jsonResponse(0,['Invalid email and password.']);
        }
    }
}
