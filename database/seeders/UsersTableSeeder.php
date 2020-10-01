<?php

namespace Database\Seeders;

use Api\Users\Models\User;
use Illuminate\Support\Str;
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
        $user = new User;
        
        $user->fill([
            'first_name' => Str::random(10),
            'last_name' => Str::random(10),
            'email' => Str::random(10). '@gmail.com',
            'password' => 'secret',
        ]);

        $user->save();
    }
}
