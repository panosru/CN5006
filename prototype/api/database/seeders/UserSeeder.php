<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\AppRole;
use App\Models\UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Feed admin user
        UserModel::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Panagiotis',
            'surname' => 'Kosmidis',
            'email' => 'no-reply@mycinema.none',
            'password' => Hash::make('12345678'),
            'api_key' => UserModel::createToken()
        ])->assignRole(
            AppRole::ADMIN->value,
            AppRole::STAFF->value,
            AppRole::USER->value
        );

        // Feed staff user
        UserModel::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Jane',
            'surname' => 'Doe',
            'email' => 'jane.doe@mycinema.none',
            'password' => Hash::make('123123123'),
            'api_key' => UserModel::createToken()
        ])->AssignRole(
            AppRole::STAFF->value,
            AppRole::USER->value
        );

        // Feed client user
        UserModel::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@anywhere.none',
            'password' => Hash::make('123123'),
            'api_key' => UserModel::createToken()
        ])->AssignRole(AppRole::USER->value);
    }
}
