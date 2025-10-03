<?php

namespace Database\Seeders;

use App\Models\Bankruptcy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankruptcySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bankruptcyData = [
            [
                'insolvency_no' => 'INS001',
                'name' => 'Ali bin Ahmad',
                'ic_no' => '780101051234',
                'others' => 'Business Owner - Food & Beverage',
                'court_case_no' => 'BC2024001',
                'ro_date' => '2024-01-10',
                'ao_date' => '2024-02-10',
                'updated_date' => '2024-03-10',
                'branch' => 'Kuala Lumpur',
                'is_active' => true,
            ],
            [
                'insolvency_no' => 'INS002',
                'name' => 'Lim Wei Ming',
                'ic_no' => '820215101234',
                'others' => 'Property Developer',
                'court_case_no' => 'BC2024002',
                'ro_date' => '2024-01-15',
                'ao_date' => '2024-02-15',
                'updated_date' => '2024-03-15',
                'branch' => 'Penang',
                'is_active' => true,
            ],
            [
                'insolvency_no' => 'INS003',
                'name' => 'Siti Aminah binti Hassan',
                'ic_no' => '851020145678',
                'others' => 'Retail Store Owner',
                'court_case_no' => 'BC2024003',
                'ro_date' => '2024-01-20',
                'ao_date' => '2024-02-20',
                'updated_date' => '2024-03-20',
                'branch' => 'Johor Bahru',
                'is_active' => true,
            ],
            [
                'insolvency_no' => 'INS004',
                'name' => 'Raj Kumar a/l Selvam',
                'ic_no' => '791105089876',
                'others' => 'Transportation Business',
                'court_case_no' => 'BC2024004',
                'ro_date' => '2024-01-25',
                'ao_date' => '2024-02-25',
                'updated_date' => '2024-03-25',
                'branch' => 'Ipoh',
                'is_active' => true,
            ],
            [
                'insolvency_no' => 'INS005',
                'name' => 'Chen Li Hua',
                'ic_no' => '880630121234',
                'others' => 'Manufacturing',
                'court_case_no' => 'BC2024005',
                'ro_date' => '2024-02-01',
                'ao_date' => '2024-03-01',
                'updated_date' => '2024-04-01',
                'branch' => 'Selangor',
                'is_active' => true,
            ],
        ];

        foreach ($bankruptcyData as $bankruptcy) {
            Bankruptcy::create($bankruptcy);
        }
    }
}