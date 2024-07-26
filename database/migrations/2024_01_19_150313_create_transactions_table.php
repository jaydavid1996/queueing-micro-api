<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('resident_id');
            $table->string('type');
            $table->text('meta')->nullable();
            $table->string('status');
            $table->boolean('is_priority');
            $table->string('payment_status')->nullable();
            $table->dateTime('payment_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('resident_id')
                ->references('id')
                ->on('residents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
