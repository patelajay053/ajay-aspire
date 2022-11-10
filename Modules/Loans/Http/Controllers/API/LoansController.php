<?php

namespace Modules\Loans\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Loans\Http\Requests\LoanRequest;
use Modules\Loans\Http\Requests\LoanApproveRequest;
use App\Models\Loan;
use App\Models\LoanTerm;

class LoansController extends Controller
{
    public function index(Request $request){
        $loanInfo = Loan::with('terms')->where('customer_id', $request->user()->id)->paginate();
        return jsonResponse(1,$loanInfo);
    }

    public function detail(LoanRequest $request){
        $request->validated();
        $loanInfo = Loan::with('terms')->where('customer_id', $request->user()->id)->where('id', $request->id)->first();
        if(!empty($loanInfo)){
            return jsonResponse(1,$loanInfo);
        } else {
            return jsonResponse(0,['Loan not found, please provide valid loan id']);
        }
    }

    public function store(LoanRequest $request)
    {
        $request->validated();

        $loanObj = new Loan;
        $loanObj->customer_id = $request->user()->id;
        $loanObj->amount = $request->amount;
        $loanObj->terms = $request->terms;
        $loanObj->save();

        $tems = generateTerms($request->amount, $request->terms);
        foreach($tems as $key => $tVal){
            $loanTermObj = new LoanTerm;
            $loanTermObj->loan_id = $loanObj->id;
            $loanTermObj->payment_date = date('Y-m-d', strtotime($tVal['date']));
            $loanTermObj->amount = $tVal['amount'];
            $loanTermObj->save();
        }

        return jsonResponse(1,['Your loan request successfully added, Please wait for approval.']);
    }

    public function repayment(LoanApproveRequest $request){
        $request->validated();

        $loanObj = Loan::where('customer_id', $request->user()->id)->where('id', $request->id)->first();
        if(empty($loanObj)){
            return jsonResponse(0,['Loan not found']);
        }
        if($loanObj->status != 'Approved'){
            return jsonResponse(0,['Your loan status is '.$loanObj->status]);
        }

        $paidAmount = LoanTerm::where('loan_id', $loanObj->id)->where('status','Paid')->sum('paid_amount');
        $remainAmount = $loanObj->amount - $paidAmount;
        if($request->amount > $remainAmount){
            return jsonResponse(0,['Your remain loan amount is '.$remainAmount.', you can not pay more than remain amount.']);
        }

        $loanTermObj = new LoanTerm;
        $loanTermObj->loan_id = $loanObj->id;
        $loanTermObj->payment_date = date('Y-m-d');
        $loanTermObj->amount = $request->amount;
        $loanTermObj->paid_amount = $request->amount;
        $loanTermObj->paid_date = date('Y-m-d H:i:s');
        $loanTermObj->status = 'Paid';
        $loanTermObj->save();

        $termsObj = LoanTerm::where('loan_id', $loanObj->id)->where('status','Pending')->orderBy('payment_date', 'ASC')->get();
        $paidAmount = LoanTerm::where('loan_id', $loanObj->id)->where('status','Paid')->sum('paid_amount');
        $remainAmount = $loanObj->amount - $paidAmount;
        foreach($termsObj as $key => $tVal){
            if($remainAmount <= 0){
                $extraTerm = LoanTerm::find($tVal->id);
                $extraTerm->delete();
            }

            if($tVal->amount > $remainAmount){
                $tVal->amount = $remainAmount;
                $tVal->save();
            }
            
            $remainAmount = $remainAmount - $tVal->amount;
        }

        $pendingCount = LoanTerm::where('status', 'Pending')->where('loan_id',$loanObj->id)->count();
        if($pendingCount == 0){
            $loanObj->status='Paid';
            $loanObj->save();
        }

        return jsonResponse(1,['Your payment is successful.']);
    }
}
