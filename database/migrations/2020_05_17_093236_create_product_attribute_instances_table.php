<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributeInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_instances', function (Blueprint $table) {
            $table->id();
            $table->uuid('product_attribute_id');
            $table->uuid('product_variant_id');
            $table->string('value')->nullable();
            $table->timestamps();

            $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->cascadeOnDelete();
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attributes_product_variants');
    }
}
