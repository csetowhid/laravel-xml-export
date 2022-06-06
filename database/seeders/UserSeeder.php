<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'xyz',
            'email' => 'x@x.com',
            'password' => Hash::make('123456')
        ]);
        User::create([
            'name' => 'xyz',
            'email' => 'y@y.com',
            'password' => Hash::make('123456')
        ]);
        User::create([
            'name' => 'xyz',
            'email' => 'z@z.com',
            'password' => Hash::make('123456')
        ]);
    }
}
