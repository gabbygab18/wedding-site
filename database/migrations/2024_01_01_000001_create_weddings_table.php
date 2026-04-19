<?php
// database/migrations/2024_01_01_000001_create_weddings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->string('bride_name');
            $table->string('groom_name');
            $table->date('wedding_date');
            $table->time('ceremony_time');
            $table->time('reception_time')->nullable();
            $table->string('venue_name');
            $table->text('venue_address')->nullable();
            $table->string('reception_venue')->nullable();
            $table->text('love_story')->nullable();
            $table->string('hashtag')->nullable();
            $table->boolean('rsvp_enabled')->default(true);
            $table->date('rsvp_deadline')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weddings');
    }
};
