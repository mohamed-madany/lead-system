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
        Schema::create('lead_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->enum('activity_type', [
                'call',
                'email',
                'meeting',
                'note',
                'status_change',
                'score_update',
                'assignment',
                'qualification',
            ]);
            $table->text('description');
            $table->json('metadata')->nullable();

            // Contact attempt tracking
            $table->enum('contact_method', ['phone', 'email', 'sms', 'in_person', 'video_call'])->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->enum('result', ['successful', 'failed', 'no_answer', 'voicemail', 'pending'])->nullable();

            $table->timestamps();

            // Indexes
            $table->index('lead_id');
            $table->index('user_id');
            $table->index('activity_type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_activities');
    }
};
