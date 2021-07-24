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
            $table->string('serial_number')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('shelf_no')->nullable();
            $table->string('row_no')->nullable();
            $table->smallInteger('count')->nullable();
            $table->smallInteger('unavailable_count')->nullable();
            $table->smallInteger('maintenance_count')->nullable();
            $table->text('description')->nullable();
            $table->decimal('buy_price')->nullable();
            $table->date('buy_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('product_status_id')->constrained('product_statuses');
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
