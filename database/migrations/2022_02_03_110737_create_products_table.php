<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('productCode');
            $table->string('productName');
            $table->string('barcode');
            $table->string('invUOM');
            $table->string('saleUOM');
            $table->string('hsnCode');
            $table->string('taxRate');
            $table->string('categoryCode');
            $table->string('subCateg');
            $table->string('type');
            $table->string('brand');
            $table->string('size');
            $table->string('color');
            $table->string('finish');
            $table->string('thickness');
            $table->string('conv_Factor');
            $table->string('boxQty');
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
        Schema::dropIfExists('products');
    }
}
