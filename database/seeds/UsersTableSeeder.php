<?php

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $adminRole = Role::whereName('Admin')->first();

        // Seed test admin
        $seededTesterEmail = 'admin@test.loc';
        $user = User::where('email', '=', $seededTesterEmail)->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => $faker->userName,
                'email'                          => $seededTesterEmail,
                'password'                       => Hash::make('password')
            ]);

            $user->attachRole($adminRole);
        }

        //Create test users
        $userRole = Role::whereName('User')->first();

        $i = 0;
        while($i < 15) {
            $user = User::create([
                'name'                           => $faker->userName,
                'email'                          => $faker->unique()->safeEmail,
                'password'                       => Hash::make('password')
            ]);

            $user->attachRole($userRole);
            $i++;
        }
    }
}
