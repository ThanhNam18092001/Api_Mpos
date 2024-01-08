<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceMpos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_mpos', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->string('order_id');
            $table->string('pos_id');
            $table->integer('amount');
            $table->string('trans_status')->nullable();
            $table->string('trans_code')->nullable();
            $table->date('trans_date')->nullable();
            $table->decimal('trans_amount', 10, 2)->nullable();
            $table->string('issuer_code')->nullable();
            $table->string('muid')->nullable();
            $table->string('description')->nullable();
            $table->string('pan')->nullable();
            $table->string('auth_code')->nullable();
            $table->string('rrn')->nullable();
            $table->string('paymentIdentifier')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_mpos');
    }
}
