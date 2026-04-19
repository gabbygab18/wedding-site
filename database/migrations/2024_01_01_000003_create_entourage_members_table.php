<?php
// database/migrations/2024_01_01_000003_create_entourage_members_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('entourage_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('role');
            $table->string('side')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('entourage_members'); }
};
