<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usluga', function (Blueprint $table) {
            $table->unsignedSmallInteger('prodolzhitelnost')->default(60)->after('stoimost');
        });

        Schema::table('kosmetolog', function (Blueprint $table) {
            $table->time('nachalo_raboty')->default('09:00:00');
            $table->time('konec_raboty')->default('18:00:00');
        });

        Schema::create('kosmetolog_usluga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kosmetolog_id')->constrained('kosmetolog')->cascadeOnDelete();
            $table->foreignId('usluga_id')->constrained('usluga')->cascadeOnDelete();
            $table->unique(['kosmetolog_id', 'usluga_id']);
        });

        Schema::table('seans', function (Blueprint $table) {
            $table->foreignId('usluga_id')->nullable()->after('kosmetolog_id')
                ->constrained('usluga')->nullOnDelete();
            $table->dateTime('data_okonchaniya')->nullable()->after('data_vremya');
            $table->string('status', 20)->default('new')->after('data_okonchaniya');
        });
    }

    public function down(): void
    {
        Schema::table('seans', function (Blueprint $table) {
            $table->dropForeign(['usluga_id']);
            $table->dropColumn(['usluga_id', 'data_okonchaniya', 'status']);
        });

        Schema::dropIfExists('kosmetolog_usluga');

        Schema::table('kosmetolog', function (Blueprint $table) {
            $table->dropColumn(['nachalo_raboty', 'konec_raboty']);
        });

        Schema::table('usluga', function (Blueprint $table) {
            $table->dropColumn('prodolzhitelnost');
        });
    }
};
