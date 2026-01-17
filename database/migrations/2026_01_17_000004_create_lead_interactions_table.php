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
        Schema::create('lead_interactions', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->enum('interaction_type', [
                'website_visit', 
                'email_open', 
                'link_click', 
                'form_submission', 
                'download', 
                'chat'
            ]);
            
            $table->json('interaction_data')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            
            $table->timestamp('created_at');
            
            // Indexes
            $table->index('lead_id');
            $table->index('interaction_type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_interactions');
    }
};
