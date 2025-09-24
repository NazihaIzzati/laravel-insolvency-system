<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffData = [
            [
                'staff_id' => '104081',
                'staff_position' => 'Branch Manager',
                'staff_branch' => 'KUALA LUMPUR SALES HUB',
                'name' => 'Ahmad Rahman',
                'email' => 'ahmad.rahman@company.com',
                'phone' => '+60123456789',
                'is_active' => true,
            ],
            [
                'staff_id' => '104082',
                'staff_position' => 'Senior Sales Executive',
                'staff_branch' => 'KUALA LUMPUR SALES HUB',
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@company.com',
                'phone' => '+60123456790',
                'is_active' => true,
            ],
            [
                'staff_id' => '104083',
                'staff_position' => 'Sales Executive',
                'staff_branch' => 'JOHOR BAHRU BRANCH',
                'name' => 'Muhammad Ali',
                'email' => 'muhammad.ali@company.com',
                'phone' => '+60123456791',
                'is_active' => true,
            ],
            [
                'staff_id' => '104084',
                'staff_position' => 'Branch Manager',
                'staff_branch' => 'PENANG BRANCH',
                'name' => 'Fatimah Zahra',
                'email' => 'fatimah.zahra@company.com',
                'phone' => '+60123456792',
                'is_active' => true,
            ],
            [
                'staff_id' => '104085',
                'staff_position' => 'Sales Coordinator',
                'staff_branch' => 'SABAH BRANCH',
                'name' => 'Abdul Rahman',
                'email' => 'abdul.rahman@company.com',
                'phone' => '+60123456793',
                'is_active' => true,
            ],
        ];

        foreach ($staffData as $staff) {
            Staff::create($staff);
        }
    }
}
