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
        // 1. Create Plans Table
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Starter, Pro
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('max_leads')->default(100);
            $table->integer('max_users')->default(1);
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Create Tenants Table
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('domain')->nullable()->unique();
            $table->string('slug')->unique(); // for subdomain or path
            $table->foreignId('plan_id')->constrained()->default(1); // Default to first plan
            $table->string('status')->default('active'); // active, suspended, trial
            $table->date('trial_ends_at')->nullable();
            
            // Integrations Config
            $table->string('facebook_page_id')->nullable()->index();
            $table->string('whatsapp_phone_number_id')->nullable()->index();
            $table->json('settings')->nullable(); // For integration tokens, etc.
            
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Update Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->boolean('is_platform_admin')->default(false)->after('role');
        });

        // 4. Update Leads Table
        Schema::table('leads', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });
        
        // 5. Update Activity/Interaction Tables (Optional but recommended for strict isolation)
        Schema::table('lead_activities', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::table('lead_interactions', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_interactions', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });

        Schema::table('lead_activities', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
            $table->dropColumn('is_platform_admin');
        });

        Schema::dropIfExists('tenants');
        Schema::dropIfExists('plans');
    }
};
