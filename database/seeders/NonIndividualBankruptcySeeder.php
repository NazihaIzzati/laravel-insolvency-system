<?php

namespace Database\Seeders;

use App\Models\NonIndividualBankruptcy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NonIndividualBankruptcySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nonIndividualBankruptcyData = [
            [
                'insolvency_no' => 'NIINS001',
                'company_name' => 'ABC Trading Sdn Bhd',
                'company_registration_no' => '202301001234',
                'others' => 'Import/Export Business',
                'court_case_no' => 'WU2024001',
                'date_of_winding_up_resolution' => '2024-01-15',
                'updated_date' => '2024-03-15',
                'branch' => 'Kuala Lumpur',
                'is_active' => true,
            ],
            [
                'insolvency_no' => 'NIINS002',
                'company_name' => 'Tech Solutions Sdn Bhd',
                'company_registration_no' => '202301002345',
                'others' => 'IT Services & Software Development',
                'court_case_no' => 'WU2024002',
                'date_of_winding_up_resolution' => '2024-01-20',
                'updated_date' => '2024-03-20',
                'branch' => 'Selangor',
                'is_active' => true,
            ],
            [
                'insolvency_no' => 'NIINS003',
                'company_name' => 'Green Energy Sdn Bhd',
                'company_registration_no' => '202301003456',
                'others' => 'Renewable Energy Solutions',
                'court_case_no' => 'WU2024003',
                'date_of_winding_up_resolution' => '2024-01-25',
                'updated_date' => '2024-03-25',
                'branch' => 'Penang',
                'is_active' => true,
            ],
            [
                'insolvency_no' => 'NIINS004',
                'company_name' => 'Ocean Shipping Sdn Bhd',
                'company_registration_no' => '202301004567',
                'others' => 'Logistics & Transportation',
                'court_case_no' => 'WU2024004',
                'date_of_winding_up_resolution' => '2024-02-01',
                'updated_date' => '2024-04-01',
                'branch' => 'Johor Bahru',
                'is_active' => true,
            ],
            [
                'insolvency_no' => 'NIINS005',
                'company_name' => 'Golden Palm Hotels Sdn Bhd',
                'company_registration_no' => '202301005678',
                'others' => 'Hospitality & Tourism',
                'court_case_no' => 'WU2024005',
                'date_of_winding_up_resolution' => '2024-02-10',
                'updated_date' => '2024-04-10',
                'branch' => 'Langkawi',
                'is_active' => true,
            ],
        ];

        foreach ($nonIndividualBankruptcyData as $nonIndividualBankruptcy) {
            NonIndividualBankruptcy::create($nonIndividualBankruptcy);
        }
    }
}