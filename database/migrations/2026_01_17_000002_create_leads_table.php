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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            // Contact Information
            $table->string('name');
            $table->string('email');
            $table->string('phone', 50);
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable();

            // Lead Management
            $table->enum('status', ['new', 'contacted', 'qualified', 'won', 'lost', 'archived'])->default('new');
            $table->enum('source', ['form', 'referral', 'campaign', 'manual', 'import', 'api'])->default('form');
            $table->enum('lead_type', ['cold', 'warm', 'hot', 'customer'])->default('cold');

            // Scoring & Classification
            $table->integer('score')->default(0)->comment('Lead score 0-100');
            $table->json('score_breakdown')->nullable()->comment('Detailed score breakdown');
            $table->enum('quality_rating', ['poor', 'fair', 'good', 'excellent'])->default('fair');

            // Notes & Information
            $table->text('notes')->nullable();
            $table->text('internal_comments')->nullable();
            $table->json('metadata')->nullable()->comment('Custom fields and data');

            // Assignment & Ownership
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('assigned_at')->nullable();

            // Dates
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamp('qualified_at')->nullable();
            $table->timestamp('won_at')->nullable();

            // Additional
            $table->decimal('estimated_value', 15, 2)->nullable();
            $table->integer('probability_percentage')->default(0);

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Indexes for Performance
            $table->index('email');
            $table->index('phone');
            $table->index('status');
            $table->index('source');
            $table->index('score');
            $table->index('assigned_to');
            $table->index('created_at');
            $table->index(['status', 'created_at']);
            $table->index(['email', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
