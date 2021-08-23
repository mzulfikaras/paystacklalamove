<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaystackJsController extends Controller
{
    public function index(){
        return view('paystackjs');
    }

    public function VerifyTransaction(){
        $curl = curl_init();

        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.paystack.co/transaction/verify/' . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
              'Authorization: Bearer sk_test_dbfb5911c9068a24b3af958428d78c608490d667',
              'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response);

        if($result){
            return redirect('/pay')->with('success', $result->data->status);
        }
    
    }
}
