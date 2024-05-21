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
        Schema::table('generations', function (Blueprint $table) {
            $table->integer('accountant_id')->unsigned()->default(0)->after('reference_number');
            $table->string('accountant_name')->nullable()->after('accountant_id');
            $table->string('accountant_position')->nullable()->after('accountant_name');
            $table->string('accountant_tin')->nullable()->after('accountant_position');
            $table->string('accountant_sign')->nullable()->after('accountant_tin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generations', function (Blueprint $table) {
            //
        });
    }
};
