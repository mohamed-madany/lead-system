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
            if (!Schema::hasColumn('tenants', 'facebook_access_token')) {
                $table->text('facebook_access_token')->nullable()->after('facebook_page_id');
            }
            if (!Schema::hasColumn('tenants', 'facebook_webhook_verify_token')) {
                $table->string('facebook_webhook_verify_token')->nullable()->after('facebook_access_token');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['facebook_access_token', 'facebook_webhook_verify_token']);
        });
    }
};
