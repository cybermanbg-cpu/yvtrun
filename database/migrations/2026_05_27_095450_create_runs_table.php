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
    Schema::create('runs', function (Blueprint $table) {
        $table->id();
        $table->string('name')->default('Yambol -> Veliko Tarnovo 133km');
        $table->dateTime('start_time')->nullable();
        $table->dateTime('end_time')->nullable();
        $table->decimal('current_lat', 10, 8)->nullable();
        $table->decimal('current_lng', 11, 8)->nullable();
        $table->decimal('distance_covered_km', 8, 2)->default(0);
        $table->boolean('is_active')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('runs');
    }
};
