<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected $defaultUsers = [
        User::TYPE_ADMIN => ['email' => 'admin@example.com', 'password' => 'adminpassword'],
        User::TYPE_AGENT1 => ['email' => 'agent1@example.com', 'password' => 'agent1password'],
        User::TYPE_AGENT2 => ['email' => 'agent2@example.com', 'password' => 'agent2password'],
        User::TYPE_EMPLOYEE => ['email' => 'employee@example.com', 'password' => 'employeepassword'],
    ];

    public function run()
    {
        foreach ($this->defaultUsers as $type => $credentials) {
            $email = $credentials['email'];
            $password = $credentials['password'];
            $name = ucfirst($type);

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'username' => strtolower($type) . '_user',
                    'password' => Hash::make($password),
                    'user_type' => $type,
                    'email_verified_at' => now(),
                    'security_question' => null,
                    'security_answer' => null,
                ]
            );

            $this->command->info("Created $name with email: $email and password: $password");
        }
    }
}
