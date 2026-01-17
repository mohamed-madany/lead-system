<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use App\Application\Lead\Services\LeadService;
use App\Application\Lead\DTOs\LeadData;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateLead extends CreateRecord
{
    protected static string $resource = LeadResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Lead created')
            ->body('The lead has been created successfully and scored automatically.');
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set defaults
        $data['status'] = $data['status'] ?? 'new';
        $data['source'] = $data['source'] ?? 'manual';
        $data['lead_type'] = $data['lead_type'] ?? 'cold';
        $data['quality_rating'] = $data['quality_rating'] ?? 'fair';
        $data['score'] = $data['score'] ?? 0;
        
        return $data;
    }
    
    protected function afterCreate(): void
    {
        // Lead is automatically scored by the model events
        // The SendLeadToN8n job is dispatched automatically
    }
}
