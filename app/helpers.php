<?php

if (!function_exists('jsonResponse')) {
    function jsonResponse($status, $data){
        if($status){
            $jsonData = array(
                'status' => $status,
                'data' => $data
            );
        } else {
            $jsonData = array(
                'status' => $status,
                'errors' => $data
            );
        }

        return response()->json($jsonData);
    }
}

if (!function_exists('generateTerms')) {
    function generateTerms($loan_amount, $term){
        $amount = number_format($loan_amount / $term,2,'.','');
        $returnData = array();
        $today = date('Y-m-d H:i:s');
        $total_payment = 0;
        for($i=1;$i<=$term;$i++){
            $returnData[] = array(
                'date' => date('Y-m-d', strtotime("+$i week")),
                'amount' => ($term==$i)?number_format(($loan_amount-$total_payment),2,'.',''):$amount
            );
            $total_payment = $total_payment+$amount;
        }
        return $returnData;
    }
}