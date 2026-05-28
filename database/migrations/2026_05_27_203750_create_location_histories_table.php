<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('location_histories', function (Blueprint $table) {
            $table->id();
            $table->decimal('lat', 10, 8);
            $table->decimal('lng', 11, 8);
            $table->decimal('distance_km', 8, 2)->default(0);
            $table->float('speed')->nullable();        // скорост в км/ч
            $table->float('battery')->nullable();      // батерия на телефона (%)
            $table->integer('accuracy')->nullable();    // точност в метри
            $table->string('device_id')->nullable();    // идентификатор на устройството
            $table->timestamp('recorded_at');           // кога е записана локацията
            $table->timestamps();
            
            // Индекси за бързо търсене
            $table->index('recorded_at');
            $table->index(['lat', 'lng']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('location_histories');
    }
};