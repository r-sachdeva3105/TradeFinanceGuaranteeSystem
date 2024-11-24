<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('guarantees', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();  // Add nullable user_id column
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('guarantees', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
