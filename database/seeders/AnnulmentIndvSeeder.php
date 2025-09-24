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
                'annulment_indv_id' => '104081',
                'no_involvency' => 'INV001',
                'annulment_indv_position' => 'Branch Manager',
                'annulment_indv_branch' => 'KUALA LUMPUR SALES HUB',
                'name' => 'Ahmad Rahman',
                'ic_no' => '123456789012',
                'ic_no_2' => '987654321098',
                'court_case_number' => 'CC2024001',
                'ro_date' => '2024-01-15',
                'ao_date' => '2024-02-15',
                'updated_date' => '2024-03-15',
                'branch_name' => 'Kuala Lumpur Branch',
                'email' => 'ahmad.rahman@company.com',
                'phone' => '+60123456789',
                'is_active' => true,
            ],
            [
                'annulment_indv_id' => '104082',
                'no_involvency' => 'INV002',
                'annulment_indv_position' => 'Senior Sales Executive',
                'annulment_indv_branch' => 'KUALA LUMPUR SALES HUB',
                'name' => 'Siti Nurhaliza',
                'ic_no' => '234567890123',
                'ic_no_2' => '876543210987',
                'court_case_number' => 'CC2024002',
                'ro_date' => '2024-01-20',
                'ao_date' => '2024-02-20',
                'updated_date' => '2024-03-20',
                'branch_name' => 'Kuala Lumpur Branch',
                'email' => 'siti.nurhaliza@company.com',
                'phone' => '+60123456790',
                'is_active' => true,
            ],
            [
                'annulment_indv_id' => '104083',
                'no_involvency' => 'INV003',
                'annulment_indv_position' => 'Sales Executive',
                'annulment_indv_branch' => 'JOHOR BAHRU BRANCH',
                'name' => 'Muhammad Ali',
                'ic_no' => '345678901234',
                'ic_no_2' => '765432109876',
                'court_case_number' => 'CC2024003',
                'ro_date' => '2024-01-25',
                'ao_date' => '2024-02-25',
                'updated_date' => '2024-03-25',
                'branch_name' => 'Johor Bahru Branch',
                'email' => 'muhammad.ali@company.com',
                'phone' => '+60123456791',
                'is_active' => true,
            ],
            [
                'annulment_indv_id' => '104084',
                'no_involvency' => 'INV004',
                'annulment_indv_position' => 'Branch Manager',
                'annulment_indv_branch' => 'PENANG BRANCH',
                'name' => 'Fatimah Zahra',
                'ic_no' => '456789012345',
                'ic_no_2' => '654321098765',
                'court_case_number' => 'CC2024004',
                'ro_date' => '2024-01-30',
                'ao_date' => '2024-02-28',
                'updated_date' => '2024-03-30',
                'branch_name' => 'Penang Branch',
                'email' => 'fatimah.zahra@company.com',
                'phone' => '+60123456792',
                'is_active' => true,
            ],
            [
                'annulment_indv_id' => '104085',
                'no_involvency' => 'INV005',
                'annulment_indv_position' => 'Sales Coordinator',
                'annulment_indv_branch' => 'SABAH BRANCH',
                'name' => 'Abdul Rahman',
                'ic_no' => '567890123456',
                'ic_no_2' => '543210987654',
                'court_case_number' => 'CC2024005',
                'ro_date' => '2024-02-05',
                'ao_date' => '2024-03-05',
                'updated_date' => '2024-04-05',
                'branch_name' => 'Sabah Branch',
                'email' => 'abdul.rahman@company.com',
                'phone' => '+60123456793',
                'is_active' => true,
            ],
        ];

        foreach ($annulmentIndvData as $annulmentIndv) {
            AnnulmentIndv::create($annulmentIndv);
        }
    }
}
