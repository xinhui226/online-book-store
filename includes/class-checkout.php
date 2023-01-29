<?php

class Checkout
{
    public static function proceedPayment($order_id,$total_amount)
    {
        return callAPI(
            BILLPLZ_API_URL.'v3/bills',
            'POST',
            [
                'collection_id' => BILLPLZ_COLLECTION_ID,
                'email' => $_SESSION['user']['email'],
                'name' => $_SESSION['user']['username'],
                'amount' => $total_amount*100,
                'callback_url' => 'http://online-book-store.local:52089/payment-callback',
                'description' => 'Order #'.$order_id,
                'redirect_url' => 'http://online-book-store.local:52089/payment-verification'
            ],
            [
                'Content-Type: application/json',
                'Authorization: Basic '. base64_encode(BILLPLZ_API_KEY.':')
            ]
          );
    }
    
    public static function updateTransactionId($transactionid,$orderid)
    {
        return DB::connect()->update(
            'UPDATE orders SET transaction_id = :transactionid WHERE id = :id',
            [
                'transactionid'=>$transactionid,
                'id'=>$orderid
            ]
        );
    }
    
    public static function checkPaymentDetails($transaction_id)
    {
        $details = callAPI(
            BILLPLZ_API_URL.'v3/bills/'.$transaction_id.'/transactions',
            'GET',
            [],
            [
                'Content-Type: application/json',
                'Authorization: Basic '. base64_encode(BILLPLZ_API_KEY.':')
            ]
        )->transactions[0];

        $result = $details;

        if($details->status!='completed'){
            $result->completed_at = '---';
        }

        return $result;
    }

}