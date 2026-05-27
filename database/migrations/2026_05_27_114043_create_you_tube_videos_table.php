<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('youtube_id')->unique(); // ID на видеото от YouTube URL
            $table->string('thumbnail')->nullable();
            $table->boolean('is_live')->default(false); // дали е лайфстрийм
            $table->boolean('is_active')->default(true);
            $table->timestamp('scheduled_at')->nullable(); // кога да се пусне
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('youtube_videos');
    }
};