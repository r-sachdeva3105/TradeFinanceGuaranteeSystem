<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guarantees', function (Blueprint $table) {
            $table->id();
            $table->string('corporate_reference_number')->unique();
            $table->string('guarantee_type');
            $table->decimal('nominal_amount', 10, 2);
            $table->string('nominal_amount_currency');
            $table->date('expiry_date');
            $table->string('applicant_name');
            $table->string('applicant_address');
            $table->string('beneficiary_name');
            $table->string('beneficiary_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guarantees');
    }
};
