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

        $merchantID = '11111';
        $resCode = 'Success';
        $message = 'Invoice added successfully';
        $resData = base64_encode(json_encode([
            'merchantID' => $merchantID,
            'serviceName' => $serviceName,
            'orderId' => $orderId,
            'posId' => $posId,
            'amount' => $amount,
            'description' => $description
        ]));

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
