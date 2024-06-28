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
            $table->decimal('overall_ewt',15,2)->default(0)->after('atc_percentage');
            $table->decimal('overall_total_amount',15,2)->default(0)->after('atc_percentage');
            $table->decimal('third_month_total',15,2)->default(0)->after('atc_percentage');
            $table->decimal('second_month_total',15,2)->default(0)->after('atc_percentage');
            $table->decimal('first_month_total',15,2)->default(0)->after('atc_percentage');
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
