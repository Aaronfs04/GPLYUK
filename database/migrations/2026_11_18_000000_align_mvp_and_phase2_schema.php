<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * ponytail: single baseline schema alignment so RD and AS never collide on migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->enum('category', ['public', 'internal'])->default('public')->after('location_type');
            $table->decimal('price', 10, 2)->default(0)->after('quota');
            $table->json('form_schema')->nullable()->after('is_featured');
        });

        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique(['user_id', 'event_id']);
            $table->foreignId('user_id')->nullable()->change();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

            $table->string('guest_name', 150)->nullable()->after('event_id');
            $table->string('guest_email', 150)->nullable()->after('guest_name');
            $table->string('guest_wa', 20)->nullable()->after('guest_email');
            $table->enum('approval_status', ['pending', 'accepted', 'rejected'])->default('accepted')->after('status');
            $table->json('answers')->nullable()->after('commitment_agreed');

            $table->index(['event_id', 'approval_status']);
            $table->index(['event_id', 'guest_email']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->timestamp('revoked_at')->nullable()->after('check_in_time');
            $table->foreignId('revoked_by_id')->nullable()->after('revoked_at')->constrained('users')->nullOnDelete();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->string('pdf_url')->nullable()->after('cover_url');
        });

        Schema::create('org_members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('position', 100);
            $table->string('division', 100);
            $table->string('period', 20)->index();
            $table->string('photo_url')->nullable();
            $table->json('social_links')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('volunteer_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('division_choice_id')->constrained('divisions')->restrictOnDelete();
            $table->string('cv_path');
            $table->string('cv_original_name');
            $table->json('extra_fields')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->index();
            $table->text('admin_note')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_applications');
        Schema::dropIfExists('org_members');

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('pdf_url');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropConstrainedForeignId('revoked_by_id');
            $table->dropColumn('revoked_at');
        });

        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropIndex(['event_id', 'approval_status']);
            $table->dropIndex(['event_id', 'guest_email']);
            $table->dropColumn(['guest_name', 'guest_email', 'guest_wa', 'approval_status', 'answers']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['category', 'price', 'form_schema']);
        });
    }
};
