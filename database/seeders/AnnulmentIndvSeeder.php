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
                'annulment_indv_position' => 'Branch Manager',
                'annulment_indv_branch' => 'KUALA LUMPUR SALES HUB',
                'name' => 'Ahmad Rahman',
                'email' => 'ahmad.rahman@company.com',
                'phone' => '+60123456789',
                'is_active' => true,
            ],
            [
                'annulment_indv_id' => '104082',
                'annulment_indv_position' => 'Senior Sales Executive',
                'annulment_indv_branch' => 'KUALA LUMPUR SALES HUB',
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@company.com',
                'phone' => '+60123456790',
                'is_active' => true,
            ],
            [
                'annulment_indv_id' => '104083',
                'annulment_indv_position' => 'Sales Executive',
                'annulment_indv_branch' => 'JOHOR BAHRU BRANCH',
                'name' => 'Muhammad Ali',
                'email' => 'muhammad.ali@company.com',
                'phone' => '+60123456791',
                'is_active' => true,
            ],
            [
                'annulment_indv_id' => '104084',
                'annulment_indv_position' => 'Branch Manager',
                'annulment_indv_branch' => 'PENANG BRANCH',
                'name' => 'Fatimah Zahra',
                'email' => 'fatimah.zahra@company.com',
                'phone' => '+60123456792',
                'is_active' => true,
            ],
            [
                'annulment_indv_id' => '104085',
                'annulment_indv_position' => 'Sales Coordinator',
                'annulment_indv_branch' => 'SABAH BRANCH',
                'name' => 'Abdul Rahman',
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
