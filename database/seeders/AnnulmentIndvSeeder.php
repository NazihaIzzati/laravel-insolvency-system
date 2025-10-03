<?php

namespace Database\Seeders;

use App\Models\AnnulmentIndv;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnulmentIndvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $annulmentIndvData = [
            [
                'name' => 'Ahmad Rahman',
                'ic_no' => '123456789012',
                'court_case_no' => 'CC2024001',
                'release_date' => '2024-02-15',
                'updated_date' => '2024-03-15',
                'release_type' => 'Annulment',
                'branch' => 'Kuala Lumpur Branch',
                'others' => 'Branch Manager - KUALA LUMPUR SALES HUB',
                'is_active' => true,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'ic_no' => '234567890123',
                'court_case_no' => 'CC2024002',
                'release_date' => '2024-02-20',
                'updated_date' => '2024-03-20',
                'release_type' => 'Annulment',
                'branch' => 'Kuala Lumpur Branch',
                'others' => 'Senior Sales Executive - KUALA LUMPUR SALES HUB',
                'is_active' => true,
            ],
            [
                'name' => 'Muhammad Ali',
                'ic_no' => '345678901234',
                'court_case_no' => 'CC2024003',
                'release_date' => '2024-02-25',
                'updated_date' => '2024-03-25',
                'release_type' => 'Annulment',
                'branch' => 'Johor Bahru Branch',
                'others' => 'Sales Executive - JOHOR BAHRU BRANCH',
                'is_active' => true,
            ],
            [
                'name' => 'Fatimah Zahra',
                'ic_no' => '456789012345',
                'court_case_no' => 'CC2024004',
                'release_date' => '2024-02-28',
                'updated_date' => '2024-03-30',
                'release_type' => 'Discharge',
                'branch' => 'Penang Branch',
                'others' => 'Branch Manager - PENANG BRANCH',
                'is_active' => true,
            ],
            [
                'name' => 'Abdul Rahman',
                'ic_no' => '567890123456',
                'court_case_no' => 'CC2024005',
                'release_date' => '2024-03-05',
                'updated_date' => '2024-04-05',
                'release_type' => 'Discharge',
                'branch' => 'Sabah Branch',
                'others' => 'Sales Coordinator - SABAH BRANCH',
                'is_active' => true,
            ],
        ];

        foreach ($annulmentIndvData as $annulmentIndv) {
            AnnulmentIndv::create($annulmentIndv);
        }
    }
}
