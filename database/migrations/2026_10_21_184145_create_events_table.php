<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('location');
            $table->enum('location_type', ['physical', 'virtual']);
            $table->dateTime('start_at')->index();
            $table->dateTime('end_at');
            $table->integer('quota');
            $table->string('banner_url');
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->index();
            $table->foreignId('created_by_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
