<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalaryAdvanced;
use Faker\Factory as Faker;

class SalaryAdvancedSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 0; $i < 1000; $i++) {
            $data[] = [
                'employee_id'  => 'EMP' . $faker->unique()->numberBetween(1000, 99999), // string ok
                'user_id'      => $faker->numberBetween(1, 10000), // integer
                'amount'       => $faker->numberBetween(1000, 10000),
                'branch_name'  => $faker->randomElement(['Dhaka', 'Chattogram', 'Khulna', 'Rajshahi']),
                'remarks'      => $faker->sentence(),
                'salary_month' => $faker->monthName . '-' . $faker->year,
                'status'       => $faker->randomElement(['Pending', 'Approved', 'Rejected']),
                'adjustment'   => $faker->numberBetween(0, 500),
                'created_by'   => 'Seeder',
                'created_at'   => now(),
                'updated_at'   => now()
            ];
        }

        // Bulk insert
        SalaryAdvanced::insert($data);
    }
}
