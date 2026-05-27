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
    Schema::create('checkpoints', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Нова Загора, Твърдица...
        $table->decimal('lat', 10, 8);
        $table->decimal('lng', 11, 8);
        $table->integer('distance_km'); // от Ямбол
        $table->integer('order_position');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkpoints');
    }
};
