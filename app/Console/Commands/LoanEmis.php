<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LoanTerm;

class LoanEmis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loan:emi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        date('Y-m-d');
        $terms = LoanTerm::where('payment_date', $date)->where('status', 'Pending')->get();
        foreach($terms as $key => $tVal){
            if($terms->loan->status == 'Approved'){
                $terms->status = 'Paid';  
                $terms->paid_amount = $terms->amount;
                $terms->paid_date = date('Y-m-d H:i:s');
                $terms->save();

                $pendingCount = LoanTerm::where('status', 'Pending')->where('loan_id',$terms->loan_id)->count();
                if($pendingCount == 0){
                    $terms->loan->status='Paid';
                    $terms->loan->save();
                }
            }
        }
        return Command::SUCCESS;
    }
}
