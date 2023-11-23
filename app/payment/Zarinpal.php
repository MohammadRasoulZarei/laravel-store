<?php
namespace App\payment;

class Zarinpal extends payment{

    public static function send($amounts,$addressId)
    {
        $data = array(
            'MerchantID' =>env('ZARINPAL_API'),
            'Amount' => $amounts['paying_amount'],
            'CallbackURL' => route('home.payment.verify',['gate'=>'zarinpal']),
            'Description' => 'خرید تست'
        );



        $jsonData = json_encode($data);
        $ch = curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData)
            )
        );


        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true);
        curl_close($ch);


        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if ($result["Status"] == 100) {

                $createOrder = parent::createOrder($result["Authority"], $amounts, $addressId, 'zarinpal');
                if (isset($createOrder['error'])) {
                    return $createOrder;


                }
                return 'https://sandbox.zarinpal.com/pg/StartPay/' . $result["Authority"];
            } else {
                echo 'ERR: ' . $result["Status"];
            }
        }
    }
    static function verify($token)
    {
        $MerchantID = env('ZARINPAL_API');


        $Authority = $token;

        $data = array('MerchantID' => $MerchantID, 'Authority' => $Authority, 'Amount' => CartFinalTotal());
        $jsonData = json_encode($data);
        $ch = curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentVerification.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData)
            )
        );
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        if ($err) {
            return ['error' => 'عملیات پرداخت با شکست انجام شد'. 'شماره خطا=' . $err] ;
        } else {
            if ($result['Status'] == 100) {
                $successUpdate =parent::successUpdate($Authority, $result['RefID']);
                if (isset($successUpdate['error'])) {


                    return $successUpdate;
                }

                return true;
            } else {
                // dd($result,'fail');
                return ['error'=>'عملیات پرداخت با شکست انجام شد'];
            }
        }
    }
}
