<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 1)->create([
            'email' => 'user@test.com',
            'name' => 'admin',
            'role' => App\User::ADMIN,
        ]);
    }
}
