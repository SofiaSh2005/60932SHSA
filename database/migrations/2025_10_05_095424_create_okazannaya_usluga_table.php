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
        Schema::create('okazannaya_usluga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seans_id')->constrained('seans')->onDelete('cascade');
            $table->foreignId('usluga_id')->constrained('usluga')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('okazannaya_usluga');
    }
};
