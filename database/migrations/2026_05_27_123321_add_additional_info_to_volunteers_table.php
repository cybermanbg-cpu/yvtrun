<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            if (!Schema::hasColumn('volunteers', 'additional_info')) {
                $table->text('additional_info')->nullable()->after('checkpoint_location');
            }
        });
    }

    public function down()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn('additional_info');
        });
    }
};