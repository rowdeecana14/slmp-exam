<?php

namespace App\Console\Commands;

use App\Models\AuthUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Throwable;

class CreateAdminUserCommand extends Command
{
    protected $signature = 'app:create-admin-user';

    protected $description = 'Create a new admin user account interactively';

    public function handle(): int
    {
        try {
            $this->components->info('Creating a new admin user account...');
            $this->newLine();

            // Get name
            $name = $this->ask('Full name');

            // Get email with validation
            $email = $this->getEmail();

            // Get password with confirmation
            $password = $this->getPassword();

            // Create the user
            $user = AuthUser::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->newLine();
            $this->components->info('Admin user created successfully!');
            $this->components->bulletList([
                "ID: {$user->id}",
                "Name: {$user->name}",
                "Email: {$user->email}",
            ]);
            $this->newLine();

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->components->error('Failed to create admin user: ' . $exception->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Get and validate email address.
     */
    private function getEmail(): string
    {
        while (true) {
            $email = $this->ask('Email address');

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->components->error('Invalid email format. Please try again.');
                $this->newLine();
                continue;
            }

            // Check if email already exists
            if (AuthUser::where('email', $email)->exists()) {
                $this->components->error('Email is already in use. Please try again.');
                $this->newLine();
                continue;
            }

            return $email;
        }
    }

    /**
     * Get and confirm password.
     */
    private function getPassword(): string
    {
        while (true) {
            $password = $this->secret('Provide a password');

            // Validate password length
            if (strlen($password) < 8) {
                $this->components->error('Password must be at least 8 characters long. Try again.');
                $this->newLine();
                continue;
            }

            $confirmation = $this->secret('Confirm the password');

            if ($password !== $confirmation) {
                $this->components->error('Passwords do not match. Try again.');
                $this->newLine();
                continue;
            }

            return $password;
        }
    }
}
