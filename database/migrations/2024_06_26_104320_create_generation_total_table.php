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
        Schema::create('generation_total', function (Blueprint $table) {
            $table->id();
            $table->integer('generation_id')->default(0);
            $table->integer('generation_head_id')->default(0);
            $table->integer('row')->default(0);
            $table->decimal('sub_total',15,2)->default(0);
            $table->decimal('ewt_total',15,2)->default(0);
            $table->integer('user_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generation_total');
    }
};
