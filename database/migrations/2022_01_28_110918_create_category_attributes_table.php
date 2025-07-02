<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('categoryCode');
            $table->string('subCateg');
            $table->string('type');
            $table->string('brand');
            $table->string('size');
            $table->string('color');
            $table->string('finish');
            $table->string('thickness');
            $table->softDeletes();
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
        Schema::dropIfExists('category_attributes');
    }
}
