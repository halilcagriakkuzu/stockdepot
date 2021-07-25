<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentFormProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_form_products', function (Blueprint $table) {
            $table->id();
            $table->integer('count')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_removed')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('rent_form_id')->constrained('rent_forms');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_form_products');
    }
}
