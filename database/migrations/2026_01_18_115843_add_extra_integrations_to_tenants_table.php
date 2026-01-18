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
        Schema::table('tenants', function (Blueprint $table) {
            // n8n Integration
            $table->string('n8n_webhook_url')->nullable()->after('settings');
            
            // AI Classification
            $table->boolean('ai_classification_enabled')->default(false)->after('n8n_webhook_url');
            
            // Telegram Notifications
            $table->string('telegram_bot_token')->nullable()->after('ai_classification_enabled');
            $table->string('telegram_chat_id')->nullable()->after('telegram_bot_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'n8n_webhook_url',
                'ai_classification_enabled',
                'telegram_bot_token',
                'telegram_chat_id'
            ]);
        });
    }
};
