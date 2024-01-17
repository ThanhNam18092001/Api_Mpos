<?php

namespace App\Http\Controllers\Zalo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ZnsController extends Controller
{
    public function sendZaloMessage()
    {
        $curl = curl_init();

        $phoneNumber = '0392525473';
        $phoneNumberWithPrefix = '84' . substr($phoneNumber, 1);

        $data = array(
            "phone" => $phoneNumberWithPrefix,
            "template_id" => "309018",
            "template_data" => array(
                "customer_name" => "Nam",
                "booking_code" => "BK00001",
                "schedule_time" => "18/01/2024",
                "address" => "hcm"
            ),
            // "tracking_id" => "tracking_id",
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://business.openapi.zalo.me/message/template",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "access_token: IFVBC5TfY5TEyCasKcwCKqpropTHTiyE4ABmP5avxbK1z_XAIoxaToB1eXrc8k43FTVG4oCgYYT7yymP6Y_E9d3Dp0GcDU8SVS736mCDypjwoyKvPLxbKtg7eL0TVuziKPsWN1zXhZzV-Ua606JG66gJzZ09JEK9QQJG3HPFn1LcqC9s9nd2RdZLz4ex8jOkGhlnEXTkvIfHigC1DaQ3OrUJW5uL2QXlVCABIoi4ioWfqFqyV33IFJhsbbTm6hatF8Aj06aSe1KEsUOLJaRb7WxSt0jG6z4iIE_pAW44mqqSoiGo0ZtGBX_Rm0zzDuyxADdDNYen-tjYq-Td94lSJ3-lnoTWQ8OuEesM3ZXYbMLGYgnwFK7eJbVUzNv1FBfj8jQyMMKoXa85ofbXGpAST1lDk4ilhNTIKtIDKW",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $responseData = json_decode($response, true);
            print_r($responseData);
        }
    }
}
