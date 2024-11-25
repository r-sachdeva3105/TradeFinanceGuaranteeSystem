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
    Schema::table('guarantees', function (Blueprint $table) {
        $table->string('status')->default('pending'); // Default to 'pending'
        $table->unsignedBigInteger('reviewer_id')->nullable(); // Nullable for unassigned guarantees
        $table->text('remarks')->nullable(); // Optional remarks
        
        // Foreign key constraint for reviewer_id
        $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('guarantees', function (Blueprint $table) {
        $table->dropColumn(['status', 'reviewer_id', 'remarks']);
        $table->dropForeign(['reviewer_id']);
    });
}

};
