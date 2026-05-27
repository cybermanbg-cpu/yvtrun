<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->text('address')->nullable()->after('email');
            $table->boolean('is_anonymous')->default(false)->after('address');
            $table->string('status')->default('pending')->after('is_anonymous');
            // Ако нямаш message, го добави
            if (!Schema::hasColumn('donations', 'message')) {
                $table->text('message')->nullable()->after('amount');
            }
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['address', 'is_anonymous', 'status']);
        });
    }
};