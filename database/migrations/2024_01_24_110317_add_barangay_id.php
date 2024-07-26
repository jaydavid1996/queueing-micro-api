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
        //
        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('barangay_id')->nullable()->after('id');
            $table->foreign('barangay_id')
                ->references('id')
                ->on('barangays');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->uuid('barangay_id')->nullable()->after('id');
            $table->foreign('barangay_id')
                ->references('id')
                ->on('barangays');
        });

        Schema::table('residents', function (Blueprint $table) {
            $table->uuid('barangay_id')->nullable()->after('id');
            $table->foreign('barangay_id')
                ->references('id')
                ->on('barangays');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['barangay_id']);
            $table->dropColumn('barangay_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['barangay_id']);
            $table->dropColumn('barangay_id');
        });

        Schema::table('residents', function (Blueprint $table) {
            $table->dropForeign(['barangay_id']);
            $table->dropColumn('barangay_id');
        });

    }
};
