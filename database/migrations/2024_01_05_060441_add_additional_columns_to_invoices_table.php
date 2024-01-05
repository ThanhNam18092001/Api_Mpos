<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('description')->nullable();
            $table->string('pan')->nullable();
            $table->string('authCode')->nullable();
            $table->string('rrn')->nullable();
            $table->string('paymentIdentifier')->nullable();
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
            $table->dropColumn('description');
            $table->dropColumn('pan');
            $table->dropColumn('authCode');
            $table->dropColumn('rrn');
            $table->dropColumn('paymentIdentifier');
        });
    }
}
