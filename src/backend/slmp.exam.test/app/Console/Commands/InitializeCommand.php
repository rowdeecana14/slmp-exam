<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class InitializeCommand extends Command
{
    protected $signature = 'app:initialize {--skip-seed : Skip seeding the database}';

    protected $description = 'Initialize the application by running migrations, seeding, and other setup tasks.';

    public function handle(): int
    {
        try {
            $this->components->info('Initializing the application...');
            $this->newLine();

            if (!$this->runMigrations()) {
                return self::FAILURE;
            }

            if (!$this->option('skip-seed') && !$this->seedDatabase()) {
                return self::FAILURE;
            }

            if (!$this->optimizeApplication()) {
                return self::FAILURE;
            }

            $this->components->info('Application initialized successfully!');
            $this->components->info('Run "php artisan app:create-admin-user" to create an admin account.');
            $this->newLine();

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->components->error('Initialization failed: ' . $exception->getMessage());
            report($exception);

            return self::FAILURE;
        }
    }

    /**
     * Run database migrations.
     */
    private function runMigrations(): bool
    {
        try {
            $this->components->info('Running migrations...');

            $exitCode = Artisan::call('migrate', ['--force' => true]);

            if ($exitCode !== 0) {
                $this->components->error('Migration failed.');
                return false;
            }

            $this->components->bulletList(['Migrations completed']);
            $this->newLine();

            return true;
        } catch (Throwable $exception) {
            $this->components->error('Migration error: ' . $exception->getMessage());
            return false;
        }
    }

    /**
     * Seed the database.
     */
    private function seedDatabase(): bool
    {
        try {
            $this->components->info('Seeding the database...');

            $exitCode = Artisan::call('db:seed', ['--force' => true]);

            if ($exitCode !== 0) {
                $this->components->error('Seeding failed.');
                return false;
            }

            $this->components->bulletList(['Database seeded']);
            $this->newLine();

            return true;
        } catch (Throwable $exception) {
            $this->components->error('Seeding error: ' . $exception->getMessage());
            return false;
        }
    }

    /**
     * Optimize the application.
     */
    private function optimizeApplication(): bool
    {
        try {
            $this->components->info('Optimizing application...');

            $exitCode = Artisan::call('optimize');

            if ($exitCode !== 0) {
                $this->components->warn('Optimization skipped.');
                return true;
            }

            $this->components->bulletList(['Cache cleared and optimized']);
            $this->newLine();

            return true;
        } catch (Throwable $exception) {
            $this->components->warn('Optimization warning: ' . $exception->getMessage());
            return true; // Don't fail on optimization issues
        }
    }
}
