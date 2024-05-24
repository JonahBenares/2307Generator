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
        Schema::table('generation_amount', function (Blueprint $table) {
            $table->integer('generation_id')->unsigned()->default(0)->after('generation_head_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generation_amount', function (Blueprint $table) {
            //
        });
    }
};
