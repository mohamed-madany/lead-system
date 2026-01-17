<?php

namespace App\Application\Lead\DTOs;

use App\Domain\Lead\Enums\LeadSource;
use App\Domain\Lead\Enums\LeadType;

class LeadData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly ?int $tenant_id = null,
        public readonly ?string $company_name = null,
        public readonly ?string $job_title = null,
        public readonly ?string $notes = null,
        public readonly LeadSource|string $source = 'form',
        public readonly LeadType|string $lead_type = 'cold',
        public readonly ?array $metadata = null,
    ) {}

    /**
     * Create from request data
     */
    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            tenant_id: $data['tenant_id'] ?? null,
            company_name: $data['company_name'] ?? null,
            job_title: $data['job_title'] ?? null,
            notes: $data['notes'] ?? null,
            source: $data['source'] ?? 'form',
            lead_type: $data['lead_type'] ?? 'cold',
            metadata: $data['metadata'] ?? null,
        );
    }

    /**
     * Convert to array for database
     */
    public function toArray(): array
    {
        return array_filter([
            'tenant_id' => $this->tenant_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'job_title' => $this->job_title,
            'notes' => $this->notes,
            'source' => $this->source instanceof LeadSource ? $this->source->value : $this->source,
            'lead_type' => $this->lead_type instanceof LeadType ? $this->lead_type->value : $this->lead_type,
            'metadata' => $this->metadata,
        ], fn ($value) => $value !== null);
    }

    /**
     * Validate data
     */
    public static function validate(array $data): array
    {
        return validator($data, [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:10|max:50',
            'company_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:2000',
            'source' => 'nullable|string|in:form,referral,campaign,manual,import,api',
            'lead_type' => 'nullable|string|in:cold,warm,hot,customer',
            'metadata' => 'nullable|array',
        ])->validate();
    }
}
