<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('location_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('location_histories', 'altitude')) {
                $table->float('altitude')->nullable()->after('accuracy');
            }
            if (!Schema::hasColumn('location_histories', 'user_id')) {
                $table->string('user_id')->nullable()->after('device_id');
            }
        });
    }

    public function down()
    {
        Schema::table('location_histories', function (Blueprint $table) {
            $table->dropColumn(['altitude', 'user_id']);
        });
    }
};