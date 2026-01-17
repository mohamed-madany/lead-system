<?php

namespace App\Livewire;

use App\Application\Lead\DTOs\LeadData;
use App\Application\Lead\Services\LeadService;
use App\Domain\Lead\Enums\LeadSource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Component;

class LeadCaptureForm extends Component
{
    // Form fields
    public $name = '';

    public $email = '';

    public $phone = '';

    public $company_name = '';

    public $job_title = '';

    public $notes = '';

    public $source = '';

    // Honeypot (spam protection)
    public $website = '';

    // UI state
    public $isSubmitting = false;

    public $showSuccess = false;

    public $leadTrackingId = null;

    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:10|max:20',
            'company_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:2000',
            'source' => ['required', Rule::enum(LeadSource::class)],
        ];
    }

    protected $messages = [
        'name.required' => 'الرجاء إدخال الاسم الكامل',
        'name.min' => 'الاسم يجب أن يكون 3 أحرف على الأقل',
        'email.required' => 'الرجاء إدخال البريد الإلكتروني',
        'email.email' => 'البريد الإلكتروني غير صحيح',
        'phone.required' => 'الرجاء إدخال رقم الهاتف',
        'phone.min' => 'رقم الهاتف يجب أن يكون 10 أرقام على الأقل',
        'notes.max' => 'الرسالة يجب ألا تتجاوز 2000 حرف',
        'source.required' => 'الرجاء اختيار كيف سمعت عنا',
    ];

    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        // Check rate limiting (1 submission per 5 minutes per IP)
        $key = 'lead-form-'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('rate_limit', "لقد تجاوزت الحد المسموح. الرجاء المحاولة بعد {$seconds} ثانية");

            return;
        }

        // Honeypot check (spam protection)
        if (! empty($this->website)) {
            // Bot detected - silently fail
            sleep(2); // Make it look like processing
            $this->showSuccess = true;

            return;
        }

        // Validate
        $validated = $this->validate();

        $this->isSubmitting = true;

        try {
            // Create lead using the service
            $leadService = app(LeadService::class);

            // Map the source enum value from string
            $sourceEnum = LeadSource::from($validated['source']);

            $leadData = LeadData::fromRequest([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company_name' => $validated['company_name'] ?? null,
                'job_title' => $validated['job_title'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'source' => $sourceEnum->value, // Helper DTO expects string or enum? check LeadData
            ]);

            $lead = $leadService->createLead($leadData);

            // Mark rate limit
            RateLimiter::hit($key, 300); // 5 minutes = 300 seconds

            // Store tracking ID
            $this->leadTrackingId = 'LEAD-'.str_pad($lead->id, 6, '0', STR_PAD_LEFT);

            // Show success
            $this->showSuccess = true;

            // Reset form
            $this->reset(['name', 'email', 'phone', 'company_name', 'job_title', 'notes', 'source']);

        } catch (\Exception $e) {
            $this->addError('submission', 'حدث خطأ أثناء إرسال الطلب. الرجاء المحاولة مرة أخرى.');
            Log::error('Lead capture form submission error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        } finally {
            $this->isSubmitting = false;
        }
    }

    public function render()
    {
        return view('livewire.lead-capture-form');
    }
}
