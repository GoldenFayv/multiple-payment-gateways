<?php

namespace Database\Seeders;

use App\Actions\CreateAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(
            fn() =>
            app(CreateAdmin::class)->handle([
                'first_name' => 'Golden',
                'last_name' => 'Favour',
                'email' => "favour.e2002@gmail.com",
                'phone' => '09034568645',
                'password' => "P@ssw0rd!",
                'password_confirmation' => "P@ssw0rd!"
            ])
        );
    }
}
