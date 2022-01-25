<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AclSeeder::class);
        $this->command->info('ACL Data seeded!');

        $this->call(UserSeeder::class);
        $this->command->info('User Data seeded!');
    }
}
