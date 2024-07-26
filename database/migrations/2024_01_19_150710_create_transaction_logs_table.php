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
        Schema::create('transaction_logs', function (Blueprint $table) {

            $table->uuid('id')->primary();;
            $table->uuid('transaction_id');
            $table->uuid('user_id');
            $table->string('remarks')->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();
            //dont add foreign key constraint might affect the observables
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_logs');
    }
};
