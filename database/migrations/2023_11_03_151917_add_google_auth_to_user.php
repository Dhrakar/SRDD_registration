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
        Schema::table('users', function ($table) {
            $table->string('gauth_id')->nullable();
            $table->string('gauth_type')->nullable();
            // additional fields for auth and tracking logins
            $table->timestamp('last_login')->nullable();
            $table->smallInteger('level')->default(0);
            $table->integer('login_count')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('gauth_id');
            $table->dropColumn('gauth_type');
            $table->dropColumn('last_login');
            $table->dropColumn('level');
            $table->dropColumn('login_count');
         });
    }
};
