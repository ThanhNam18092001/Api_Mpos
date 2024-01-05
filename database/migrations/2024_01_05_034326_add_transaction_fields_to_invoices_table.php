<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionFieldsToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('transStatus')->nullable();
            $table->string('transCode')->nullable();
            $table->date('transDate')->nullable();
            $table->decimal('transAmount', 10, 2)->nullable();
            $table->string('issuerCode')->nullable();
            $table->string('muid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['transStatus', 'transCode', 'transDate', 'transAmount', 'issuerCode', 'muid']);
        });
    }
}
