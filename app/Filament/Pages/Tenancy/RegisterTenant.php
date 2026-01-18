<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Tenant;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Pages\Tenancy\RegisterTenant as BaseRegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\ViewField;

class RegisterTenant extends BaseRegisterTenant
{
    public static function getLabel(): string
    {
        return 'إعداد حساب الشركة';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('اسم الشركة / العلامة التجارية')
                    ->placeholder('مثلاً: شركة المنار للتطوير العقاري')
                    ->required()
                    ->maxLength(255),
                
                Radio::make('plan_id')
                    ->label('اختر باقة الاشتراك')
                    ->options(Plan::where('is_active', true)->pluck('name', 'id'))
                    ->default(fn() => Plan::where('slug', 'starter')->first()?->id)
                    ->descriptions(
                        Plan::where('is_active', true)->get()->mapWithKeys(function ($plan) {
                            return [$plan->id => "{$plan->price} ريال / شهر - (حد أقصى {$plan->max_leads} عميل)"];
                        })->toArray()
                    )
                    ->required(),
            ]);
    }

    protected function handleRegistration(array $data): Model
    {
        $tenant = Tenant::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . rand(1000, 9999),
            'plan_id' => $data['plan_id'],
            'status' => 'active',
            'trial_ends_at' => now()->addDays(14),
        ]);

        $tenant->users()->save(Auth::user());
        
        // تحديث المستخدم ليكون هو الـ Admin الافتراضي لهذه الشركة
        Auth::user()->update(['role' => 'admin']);

        return $tenant;
    }
}
