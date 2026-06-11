<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedTinyInteger('seats_allotted')->default(1);
            $table->timestamps();
        });

        Schema::table('rsvps', function (Blueprint $table) {
            $table->foreignId('wedding_guest_id')
                  ->nullable()->after('wedding_id')
                  ->constrained('wedding_guests')->nullOnDelete();
            $table->json('guest_names')->nullable()->after('guests_count');
        });
    }

    public function down(): void
    {
        Schema::table('rsvps', function (Blueprint $table) {
            $table->dropForeign(['wedding_guest_id']);
            $table->dropColumn(['wedding_guest_id', 'guest_names']);
        });
        Schema::dropIfExists('wedding_guests');
    }
};
