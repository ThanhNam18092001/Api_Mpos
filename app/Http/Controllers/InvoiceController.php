<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function addInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'serviceName' => 'required',
            'orderId' => 'required|unique:invoices',
            'posId' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'resCode' => 'Error',
                'message' => 'Missing or invalid input data',
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $serviceName = $request->input('serviceName');
        $orderId = $request->input('orderId');
        $posId = $request->input('posId');
        $amount = $request->input('amount');
        $description = $request->input('description');

        $existingInvoice = Invoice::where('orderId', $orderId)->first();
        if ($existingInvoice) {
            return response()->json([
                'resCode' => 'Error',
                'message' => 'Duplicate orderId. Please use a unique orderId.',
            ], 400);
        }

        $invoice = new Invoice();
        $invoice->serviceName = $serviceName;
        $invoice->orderId = $orderId;
        $invoice->posId = $posId;
        $invoice->amount = $amount;
        $invoice->description = $description;
        $invoice->save();

        $encryptionKey = '0123456789ABCDEF';
        $dataToEncrypt = json_encode([
            'serviceName' => $serviceName,
            'orderId' => $orderId,
            'posId' => $posId,
            'amount' => $amount,
            'description' => $description,
        ]);

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));
        $encryptedData = openssl_encrypt($dataToEncrypt, 'aes-128-cbc', $encryptionKey, 0, $iv);
        $encodedData = base64_encode($iv . $encryptedData);

        $merchantID = '11111';
        $resCode = 200;
        $message = 'Success';
        $resData = $encodedData;

        Log::info('Invoice added', [
            'serviceName' => $serviceName,
            'orderId' => $orderId,
            'posId' => $posId,
            'amount' => $amount,
        ]);

        return response()->json([
            'resCode' => $resCode,
            'message' => $message,
            'merchantID' => $merchantID,
            'resData' => $resData,
        ]);
    }
}
