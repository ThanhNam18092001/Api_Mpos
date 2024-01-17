<?php

namespace App\Http\Controllers\Zalo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZaloController extends Controller
{
    public function accessToken()
    {
        $curl = curl_init();

        $data = array(
            'code' => '<your_oauth_code>', //Note
            'app_id' => '1003456463332716062', // KEY
            'grant_type' => 'authorization_code', //Note
            'code_verifier' => 'your_code_verifier', //Note
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://oauth.zaloapp.com/v4/oa/access_token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "secret_key: j19i1v0wH767NYvMYe55", // SCERET KEY
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


    public function accessTokenByRefresh()
    {
        $curl = curl_init();

        $data = array(
            'app_id' => '1003456463332716062', // KEY
            'grant_type' => 'refresh_token', //Note
            'refresh_token' => '8b6gIcnTH7qaLgXCQLf0UIPJgargGY0GNpAj94fhH4jd1iTvOKbG4d45s5fUV5O8GNFzJLOjQJfiTDHXImD5Ktftm2D1EL5bIK_8L5me92v0Uuz2J0OR3mTXiKLA9ou9KdM5KMu15n5fHvr4MZG1811uX4CN50qaFLwWLmqqIZSyRVD4BXLZBnn4y5ap3teo0cFI1p0lE4OiI8GUFXaQH7LykHvWDYTTQ73EBKT-HrXrCh00GqSwP7KHpL0uTaKA93hhU2eoOa8VDVfrEszo4JmanYK5QozG6HgN8r1BTNbh1_SzHdvvRbGZpHXeBIP9LKQUEHvC3Lu2DeqBBJuQQ2bFi24l9Zz8QKcXULqkImDIGE9lHWm0L4bog6HwBZrNDK7UD2WSGNXkKkqLJr5-Fze2Q411U0'
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://oauth.zaloapp.com/v4/oa/access_token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "secret_key: j19i1v0wH767NYvMYe55", // SCERET KEY
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

    public function getOfInterestedListCustomer()
    {
        $curl = curl_init();

        $data = array(
            'offset' => 0,
            'count' => 5,
            // 'tag_name' => 'Khách hàng Q1',
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://openapi.zalo.me/v2.0/oa/getfollowers?data=" . urlencode(json_encode($data)),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
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

    public function getListInfomationZalo()
    {
        $curl = curl_init();

        $data = array(
            'offset' => 0,
            'count' => 5,
            // 'tag_name' => 'Khách hàng Q1',
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://openapi.zalo.me/v2.0/oa/getoa",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
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
