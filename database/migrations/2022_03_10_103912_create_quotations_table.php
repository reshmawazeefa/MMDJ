<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('customerCode');
            $table->string('referral1');
            $table->string('referral2');
            $table->date('date');
            $table->date('docNumber');
            $table->string('priceList');
            $table->float('totalAmount', 8, 2);
            $table->string('discountPercent');
            $table->float('tax', 8, 2);
            $table->float('grandTotal', 8, 2);
            $table->enum('status', ['Open', 'Confirm', 'Cancel'])->default('Open');
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
        Schema::dropIfExists('quotations');
    }
}
