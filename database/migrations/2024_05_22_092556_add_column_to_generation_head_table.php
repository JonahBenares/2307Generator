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
        Schema::table('generation_head', function (Blueprint $table) {
            $table->integer('status')->default(0)->after('user_id')->comment('draft=0, saved=1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generation_head', function (Blueprint $table) {
            //
        });
    }
};
