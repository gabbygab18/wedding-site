<?php
// database/migrations/2024_01_01_000004_create_rsvps_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained()->cascadeOnDelete();
            $table->string('guest_name');
            $table->string('email')->nullable();
            $table->boolean('attending')->default(true);
            $table->integer('guests_count')->default(1);
            $table->text('message')->nullable();
            $table->boolean('notified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('rsvps'); }
};
