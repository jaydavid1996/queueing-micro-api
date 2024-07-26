<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // $adminRole = Role::where('name', 'admin')->first();
        // $userRole = Role::where('name', 'user')->first();
        // $modRole = Role::where('name', 'moderator')->first();

        $barangay = \App\Models\Barangay::first();
        if($barangay == null) {
            $barangay = \App\Models\Barangay::factory(1)->create();
        }

        $user = User::create([
            'first_name' => 'Matt',
            'last_name' =>'Admin',
            'middle_name' =>'',
            'email' => 'matt@gmail.com',
            'password' => Hash::make('a123456'),
            'barangay_id' => $barangay->id,
        ]);
        $user->assignRole('admin');

        $user = User::create([
            'first_name' => 'Matt',
            'last_name' =>'User',
            'middle_name' =>'',
            'email' => 'matt-user@gmail.com',
            'password' => Hash::make('a123456'),
            'barangay_id' => $barangay->id,
        ]);
        $user->assignRole('user');

        $user = User::create([
            'first_name' => 'Matt',
            'last_name' =>'Moderator',
            'middle_name' =>'',
            'email' => 'matt-mod@gmail.com',
            'password' => Hash::make('a123456'),
            'barangay_id' => $barangay->id,
        ]);
        $user->assignRole('moderator');
    }
}
