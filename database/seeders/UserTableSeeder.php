<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::exists()) {
            return;
        }

        $password = bcrypt('password'); // password
        collect([
            User::forceCreate([
                'name' => 'Taylor Otwell',
                'email' => 'taylor@laravel.com',
                'password' => $password,
            ]),
            User::forceCreate([
                'name' => 'Mohamed Said',
                'email' => 'mohamed@laravel.com',
                'password' => $password,
            ]),
            User::forceCreate([
                'name' => 'David Hemphill',
                'email' => 'david@laravel.com',
                'password' => $password,
            ]),
            User::forceCreate([
                'name' => 'Laravel Nova',
                'email' => 'nova@laravel.com',
                'password' => $password,
            ]),
        ])->each(fn (User $user) => Profile::forceCreate([
            'user_id' => $user->getKey(),
            'notification' => Arr::random(['mail', 'push']),
            'country' => Arr::random(['AF', 'AX', 'GB', 'US']),
            'timezone' => Arr::random(\DateTimeZone::listIdentifiers(\DateTimeZone::ALL)),
        ]));
    }
}
