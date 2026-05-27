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
    Schema::create('volunteers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('role'); // вода, храна, лайф оператор, ескорт
        $table->string('phone');
        $table->string('time_slot'); // 08:00-12:00
        $table->string('checkpoint_location')->nullable();
        $table->boolean('confirmed')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
