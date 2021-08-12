<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaystackController extends Controller
{
    public function InitializeTransaction(Request $request){
        $url = "https://api.paystack.co/transaction/initialize";
        $fields = [
          'email' => $request->email,
          'amount' => $request->amount,
        ];
        $fields_string = http_build_query($fields);
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Authorization: Bearer sk_test_dbfb5911c9068a24b3af958428d78c608490d667",
          "Cache-Control: no-cache",
          // "Content-Type: application/json"
        ));
        
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        //execute post
        $response = curl_exec($ch);
        $result = json_decode($response);

        if ($result) {
            $pay = $result->data->authorization_url;
            
            return redirect($pay);
        }
    }

    public function VerifyTransaction(){
      $curl = curl_init();
  
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/:reference",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer sk_test_dbfb5911c9068a24b3af958428d78c608490d667",
          "Cache-Control: no-cache",
        ),
      ));
      
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        echo $response;
      }
    }

    public function ListTransaction(){
      $curl = curl_init();
  
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer sk_test_dbfb5911c9068a24b3af958428d78c608490d667",
          "Cache-Control: no-cache",
        ),
      ));
      
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        echo $response;
      }
    }
}
