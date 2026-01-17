<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Lead System Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for the Lead Management System
    |
    */

    'scoring' => [
        /**
         * Lead scoring thresholds
         */
        'qualification_threshold' => 70,
        'hot_lead_threshold' => 90,
        'cold_lead_threshold' => 30,

        /**
         * Base scoring points
         */
        'points' => [
            'email_provided' => 20,
            'phone_provided' => 25,
            'corporate_email' => 10,
            'company_name' => 5,
            'job_title' => 5,
            'full_message' => 10,
            'source_referral' => 10,
            'source_campaign' => 8,
            'source_form' => 5,
            'business_hours_bonus' => 10,
            'email_bounce_penalty' => -10,
            'wrong_phone_penalty' => -5,
            'spam_keywords_penalty' => -15,
            'unsubscribe_penalty' => -20,
        ],

        /**
         * Free email providers (for corporate email detection)
         */
        'free_email_providers' => [
            'gmail.com',
            'yahoo.com',
            'hotmail.com',
            'outlook.com',
            'live.com',
            'aol.com',
            'icloud.com',
            'mail.com',
        ],

        /**
         * Spam keywords
         */
        'spam_keywords' => [
            'nospam',
            'test',
            'fake',
            'invalid',
            'spam',
            'temp',
        ],
    ],

    'form' => [
        /**
         * Rate limiting for form submissions
         */
        'rate_limit' => [
            'max_attempts' => 1,
            'decay_minutes' => 5,
        ],

        /**
         * Validation rules
         */
        'validation' => [
            'name_min_length' => 3,
            'name_max_length' => 255,
            'phone_min_length' => 10,
            'phone_max_length' => 50,
            'notes_max_length' => 2000,
        ],
    ],

    'pagination' => [
        /**
         * Items per page options
         */
        'per_page_options' => [10, 25, 50, 100],
        'default_per_page' => 25,
    ],

    'cache' => [
        /**
         * Cache TTL in seconds
         */
        'stats_ttl' => 3600, // 1 hour
        'list_ttl' => 1800, // 30 minutes
        'dashboard_ttl' => 1800, // 30 minutes
        'user_list_ttl' => 86400, // 24 hours
        'config_ttl' => 86400, // 24 hours
    ],

    'cleanup' => [
        /**
         * Archive old leads (in days)
         */
        'archive_after_days' => 730, // 2 years

        /**
         * Delete archived leads (in days)
         */
        'delete_archived_after_days' => 90, // 3 months after archiving
    ],

    'webhooks' => [
        'facebook_verify_token' => env('FACEBOOK_VERIFY_TOKEN', 'lead-system-verify-token'),
        /**
         * N8n webhook configuration
         */
        'n8n' => [
            'enabled' => env('N8N_ENABLED', false),
            'timeout' => 30, // seconds
            'retry_attempts' => 3,
            'retry_delays' => [60, 300, 900], // 1min, 5min, 15min
        ],
    ],

    'notifications' => [
        /**
         * Email notification settings
         */
        'admin_email' => env('MAIL_FROM_ADDRESS', 'admin@example.com'),
        'send_lead_confirmation' => true,
        'send_admin_notification' => true,
        'send_daily_summary' => true,
        'send_weekly_report' => true,
        'daily_summary_time' => '09:00', // 9 AM
        'weekly_report_day' => 'monday',
        'weekly_report_time' => '09:00',
    ],

    'security' => [
        /**
         * Security settings
         */
        'enable_honeypot' => true,
        'honeypot_field_name' => 'website',
        'enable_recaptcha' => false, // Optional
        'recaptcha_site_key' => env('RECAPTCHA_SITE_KEY'),
        'recaptcha_secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],

];
