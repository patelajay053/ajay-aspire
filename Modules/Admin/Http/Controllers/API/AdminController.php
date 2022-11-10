<?php

namespace Modules\Admin\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Http\Requests\AdminLoginRequest;
use Modules\Admin\Http\Requests\AdminLoanRequest;
use App\Models\Admin;
use App\Models\Loan;
use Auth;

class AdminController extends Controller
{

    public function login(AdminLoginRequest $request)
    {
        $request->validated();

        $user = Admin::where('email', $request->email)->where('type', 'Admin')->first();
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

    public function loan(AdminLoanRequest $request){
        $request->validated();

        $loanInfo = Loan::with('terms');
        if(!empty($request->status)){
            $loanInfo = $loanInfo->where('status', $request->status);
        }
        $loanInfo = $loanInfo->paginate();
        return jsonResponse(1,$loanInfo);
    }

    public function loanApproved(AdminLoanRequest $request){
        $request->validated();

        $loanInfo = Loan::find($request->id);
        if(empty($loanInfo)){
            return jsonResponse(0,['Loan not found, Please provide valid info']);
        }

        if($loanInfo->status != 'Pending'){
            return jsonResponse(0,['Loan is already '.$loanInfo->status]);
        }

        $loanInfo->status = 'Approved';
        $loanInfo->save();
        return jsonResponse(1,['Loan is approved.']);
    }
}
