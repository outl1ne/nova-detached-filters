<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Workbench\Database\Factories\UserFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password

        UserFactory::new()->create([
            'name' => 'Laravel Nova',
            'email' => 'nova@laravel.com',
            'password' => $password,
        ]);

        UserFactory::new()->times(100)->create([
            'password' => $password,
        ]);
    }
}
