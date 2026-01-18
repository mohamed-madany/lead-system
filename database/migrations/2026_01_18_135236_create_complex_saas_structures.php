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
        // 1. Multiple Assignees Pivot Table
        Schema::create('lead_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('primary'); // primary, secondary
            $table->timestamps();

            $table->unique(['lead_id', 'user_id']);
        });

        // 2. Real Subscriptions Table
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->string('status')->default('active'); // active, expired, cancelled
            $table->string('payment_id')->nullable(); // external provider ID
            $table->timestamps();
        });

        // 3. Automations Table
        Schema::create('automations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // whatsapp, crm, email, webhook
            $table->string('trigger_event')->default('lead.created');
            $table->json('config');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automations');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('lead_user');
    }
};
