<?php

namespace Database\Seeders;

use App\Application\Lead\Services\LeadScoringService;
use App\Domain\Lead\Models\Lead;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scoringService = new LeadScoringService;
        $users = User::all();

        $leads = [
            [
                'name' => 'أحمد محمد علي',
                'email' => 'ahmed.ali@techcorp.com',
                'phone' => '01012345678',
                'company_name' => 'شركة التقنية المتطورة',
                'job_title' => 'مدير تقني',
                'notes' => 'مهتم بالحلول المؤسسية لأكثر من 500 موظف.',
                'source' => 'referral',
                'status' => 'new',
            ],
            [
                'name' => 'سارة محمود الهاشمي',
                'email' => 'sarah.m@gmail.com',
                'phone' => '01123456789',
                'company_name' => 'ستارت أب المنار',
                'job_title' => 'المدير التنفيذي',
                'notes' => 'تبحث عن حل ميسر لفريق صغير.',
                'source' => 'form',
                'status' => 'contacted',
            ],
            [
                'name' => 'محمود كمال الجندى',
                'email' => 'm.kamal@innovate.io',
                'phone' => '01234567890',
                'company_name' => 'حلول الابتكار',
                'job_title' => 'نائب رئيس المبيعات',
                'notes' => 'يحتاج إلى عرض توضيحي عاجل. الميزانية معتمدة.',
                'source' => 'campaign',
                'status' => 'qualified',
            ],
            [
                'name' => 'ليلى إبراهيم فوزي',
                'email' => 'laila.f@megacorp.ae',
                'phone' => '971501234567',
                'company_name' => 'ميجاكورب العالمية',
                'job_title' => 'مديرة التسويق',
                'notes' => 'حضرت الندوة عبر الإنترنت، مهتمة جداً بالتنفيذ.',
                'source' => 'campaign',
                'status' => 'new',
            ],
            [
                'name' => 'ياسين منصور ذكي',
                'email' => 'yassin@fastgrow.com',
                'phone' => '01545678901',
                'company_name' => 'شركة النمو السريع',
                'job_title' => 'رئيس العمليات',
                'notes' => 'يقارن مع المنافسين. مهتم جداً بالسعر.',
                'source' => 'form',
                'status' => 'contacted',
            ],
            [
                'name' => 'منى عيسى السعدني',
                'email' => 'mona.e@enterprise.co',
                'phone' => '0506789012',
                'company_name' => 'المؤسسة المتحدة',
                'job_title' => 'المدير المالي',
                'notes' => 'عميل مؤسسي كبير. فرصة ذات قيمة عالية.',
                'source' => 'referral',
                'status' => 'qualified',
            ],
            [
                'name' => 'عادل وجدي خليل',
                'email' => 'adel.w@yahoo.com',
                'phone' => '0127890123',
                'company_name' => null,
                'job_title' => null,
                'notes' => 'استفسار فردي. لم يتم المتابعة بعد.',
                'source' => 'form',
                'status' => 'new',
            ],
            [
                'name' => 'نورا حسن جلال',
                'email' => 'nora@digitalagency.net',
                'phone' => '0118901234',
                'company_name' => 'وكالة ديجيتال',
                'job_title' => 'مديرة حسابات',
                'notes' => 'تمت التوصية بها من قبل عميل قديم.',
                'source' => 'referral',
                'status' => 'won',
                'estimated_value' => 150000.00,
                'probability_percentage' => 100,
            ],
            [
                'name' => 'خالد عبد الرحمن السيف',
                'email' => 'khaled@oldschool.com',
                'phone' => '0559012345',
                'company_name' => 'المجموعة التقليدية',
                'job_title' => 'مدير عام',
                'notes' => 'غير مهتم بحلول السحابة حالياً.',
                'source' => 'campaign',
                'status' => 'lost',
                'metadata' => ['lost_reason' => 'يفضل العمل على خوادم محلية'],
            ],
            [
                'name' => 'إياد كامل بدوي',
                'email' => 'eyad.b@moderntech.io',
                'phone' => '0100123456',
                'company_name' => 'مودرن تك',
                'job_title' => 'مدير منتج',
                'notes' => 'موعد العرض التجريبي الأسبوع القادم.',
                'source' => 'form',
                'status' => 'contacted',
            ],
        ];

        foreach ($leads as $leadData) {
            $lead = Lead::create($leadData);

            // Calculate and set score
            $score = $scoringService->calculateScore($lead);
            $leadType = $scoringService->determineLeadType($score);
            $qualityRating = $scoringService->determineQualityRating($score);

            $lead->update([
                'score' => $score,
                'lead_type' => $leadType,
                'quality_rating' => $qualityRating,
            ]);

            // Assign some leads randomly
            if (rand(0, 1) && $users->isNotEmpty()) {
                $lead->assignTo($users->random()->id);
            }

            // Set qualified and won dates for appropriate statuses
            if ($lead->status->value === 'qualified') {
                $lead->update(['qualified_at' => now()->subDays(rand(1, 5))]);
            }
            if ($lead->status->value === 'won') {
                $lead->update([
                    'qualified_at' => now()->subDays(rand(10, 20)),
                    'won_at' => now()->subDays(rand(1, 5)),
                ]);
            }
        }

        $this->command->info('✅ Created '.count($leads).' sample leads with Arabic data');
    }
}
