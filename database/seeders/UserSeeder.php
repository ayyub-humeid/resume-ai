<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Ahmad',
            'email'=>'ahmad@app.com',
            'password'=>Hash::make('password'),
            'role'=>'job_seeker'
        ]);
        User::create([
            'name'=>'sammer',
            'email'=>'sammer@app.com',
            'password'=>Hash::make('password'),
            'role'=>'recruiter'
        ]);
        User::create([
            'name'=>'ayyub',
            'email'=>'ayyub@app.com',
            'password'=>Hash::make('password'),
            'role'=>'admin'
        ]);
    }
}