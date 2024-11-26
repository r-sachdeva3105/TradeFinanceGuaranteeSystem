<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // File name
            $table->string('type'); // File type (csv, json, xml)
            $table->binary('content'); // File content as blob
            $table->timestamps(); // Created at, Updated at
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
};
