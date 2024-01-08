<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/invoices', [InvoiceController::class, 'addInvoice']);

Route::delete('/invoice-cancel', [InvoiceController::class, 'cancelInvoice']);

Route::put('/update-transaction', [InvoiceController::class, 'updateTransaction']);

Route::get('/get-invoice', [InvoiceController::class, 'getTransactionStatus']);
