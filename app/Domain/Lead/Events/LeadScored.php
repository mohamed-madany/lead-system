<?php

namespace App\Domain\Lead\Events;

use App\Domain\Lead\Models\Lead;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadScored
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Lead $lead
    ) {}
}
