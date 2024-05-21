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
        Schema::create('generations', function (Blueprint $table) {
            $table->id();
            $table->string('date_from')->nullable();
            $table->string('date_to')->nullable();
            $table->integer('payee_id')->unsigned()->default(0);
            $table->string('payee_name')->nullable();
            $table->text('registered_address')->nullable();
            $table->string('tin')->nullable();
            $table->string('zip_code')->nullable();
            $table->integer('atc_id')->unsigned()->default(0);
            $table->string('atc_code')->nullable();
            $table->string('atc_remarks')->nullable();
            $table->decimal('atc_percentage',8,2)->default(0);
            $table->decimal('amount',8,2)->default(0);
            $table->decimal('total',8,2)->default(0);
            $table->integer('include_sign')->default(0);
            $table->string('reference_number')->nullable();
            $table->integer('user_id')->unsigned()->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generations');
    }
};
