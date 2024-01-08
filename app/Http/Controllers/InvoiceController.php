<?php

namespace App\Http\Controllers;

use App\Models\InvoiceMpos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function addInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required',
            'order_id' => 'required|unique:invoice_mpos',
            'pos_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'resCode' => 'Error',
                'message' => 'Missing or invalid input data',
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $service_name = $request->input('service_name');
        $order_id = $request->input('order_id');
        $pos_id = $request->input('pos_id');
        $amount = $request->input('amount');
        $description = $request->input('description');

        $existingInvoice = InvoiceMpos::where('order_id', $order_id)->first();
        if ($existingInvoice) {
            return response()->json([
                'resCode' => 'Error',
                'message' => 'Duplicate orderId. Please use a unique orderId.',
            ], 400);
        }

        $invoice = new InvoiceMpos();
        $invoice->service_name = $service_name;
        $invoice->order_id = $order_id;
        $invoice->pos_id = $pos_id;
        $invoice->amount = $amount;
        $invoice->description = $description;
        $invoice->save();

        $encryptionKey = '0123456789ABCDEF';
        $dataToEncrypt = json_encode([
            'service_name' => $service_name,
            'order_id' => $order_id,
            'pos_id' => $pos_id,
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
            'service_name' => $service_name,
            'order_id' => $order_id,
            'pos_id' => $pos_id,
            'amount' => $amount,
        ]);

        return response()->json([
            'resCode' => $resCode,
            'message' => $message,
            'merchantID' => $merchantID,
            'resData' => $resData,
        ]);
    }

    public function cancelInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required',
            'order_id' => 'required',
            'pos_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'resCode' => 'Error',
                'message' => 'Missing or invalid input data',
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $service_name = $request->input('service_name');
        $order_id = $request->input('order_id');
        $pos_id = $request->input('pos_id');
        $amount = $request->input('amount');

        $invoice = InvoiceMpos::where('service_name', $service_name)
            ->where('order_id', $order_id)
            ->where('pos_id', $pos_id)
            ->where('amount', $amount)
            ->first();

        if (!$invoice) {
            return response()->json([
                'resCode' => 'Error',
                'message' => 'Invoice not found',
            ], 404);
        }

        $invoice->delete();

        $merchantID = '11111';
        $resCode = 'Success';
        $message = 'Invoice canceled successfully';

        $encryptionKey = '0123456789ABCDEF';
        $resData = json_encode([
            'service_name' => $service_name,
            'order_id' => $order_id,
            'pos_id' => $pos_id,
            'amount' => $amount,
        ]);

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));
        $encryptedData = openssl_encrypt($resData, 'aes-128-cbc', $encryptionKey, 0, $iv);
        $encodedData = base64_encode($iv . $encryptedData);

        return response()->json([
            'resCode' => $resCode,
            'message' => $message,
            'merchantID' => $merchantID,
            'resData' => $encodedData,
        ]);
    }

    public function updateTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required',
            'trans_status' => 'required',
            'trans_code' => 'required',
            'trans_date' => 'required|date',
            'trans_amount' => 'required|numeric',
            'issuer_code' => 'required',
            'muid' => 'required',
            'order_id' => 'required',
            'pos_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'resCode' => 'Error',
                'message' => 'Invalid or missing input data',
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $invoice = InvoiceMpos::where('service_name', $request->input('service_name'))
            ->where('order_id', $request->input('order_id'))
            ->where('pos_id', $request->input('pos_id'))
            ->first();

        if (!$invoice) {
            return response()->json([
                'resCode' => 'Error',
                'message' => 'Invoice not found',
            ], 404);
        }

        $invoice->trans_status = $request->input('trans_status');
        $invoice->trans_code = $request->input('trans_code');
        $invoice->trans_date = $request->input('trans_date');
        $invoice->trans_amount = $request->input('trans_amount');
        $invoice->issuer_code = $request->input('issuer_code');
        $invoice->muid = $request->input('muid');

        $invoice->save();

        return response()->json([
            'resCode' => 'Success',
            'message' => 'Transaction status updated successfully',
        ]);
    }

    public function getTransactionStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'serviceName' => 'required',
            'orderId' => 'required',
            'posId' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'resCode' => 'Error',
                'message' => 'Invalid or missing input data',
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $serviceName = $request->input('serviceName');
        $orderId = $request->input('orderId');
        $posId = $request->input('posId');
        $amount = $request->input('amount');

        $transStatus = 'Successful';

        $merchantId = '11111';
        $resCode = 200;
        $message = 'Success';

        $transactionData = [
            'serviceName' => $serviceName,
            'orderId' => $orderId,
            'posId' => $posId,
            'amount' => $amount,
            'transStatus' => $transStatus,
        ];
        
        $encryptionKey = '0123456789ABCDEF';
        $resData = json_encode($transactionData);

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));
        $encryptedData = openssl_encrypt($resData, 'aes-128-cbc', $encryptionKey, 0, $iv);
        $encodedData = base64_encode($iv . $encryptedData);

        Log::info('Transaction status retrieved', [
            'serviceName' => $serviceName,
            'orderId' => $orderId,
            'posId' => $posId,
            'amount' => $amount,
            'transStatus' => $transStatus,
        ]);

        return response()->json([
            'resCode' => $resCode,
            'message' => $message,
            'merchantId' => $merchantId,
            'resData' => $encodedData,
        ]);
    }
}
