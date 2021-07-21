<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_forms', function (Blueprint $table) {
            $table->id();
            $table->string('interlocutor_name')->nullable();
            $table->string('interlocutor_email')->nullable();
            $table->string('interlocutor_phone')->nullable();
            $table->decimal('price')->nullable();
            $table->string('currency')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('rent_form_status_id')->constrained('rent_form_statuses');

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_forms');
    }
}
