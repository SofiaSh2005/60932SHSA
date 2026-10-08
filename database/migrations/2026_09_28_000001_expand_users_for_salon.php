<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefon', 30)->nullable()->unique()->after('name');
            $table->string('role', 20)->default('user')->after('password');
            $table->foreignId('klient_id')->nullable()->after('role')
                ->constrained('klient')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['klient_id']);
            $table->dropColumn(['telefon', 'role', 'klient_id']);
        });
    }
};
