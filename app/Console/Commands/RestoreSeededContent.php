<?php

namespace App\Console\Commands;

use Database\Seeders\ContentRestoreSeeder;
use Illuminate\Console\Command;

class RestoreSeededContent extends Command
{
    protected $signature = 'right:restore-content {--force : Restore without confirmation}';

    protected $description = 'Restore demo content for translatable models (experts, bags, activities, etc.)';

    public function handle(): int
    {
        if (! $this->option('force') && ! $this->confirm('This will replace existing content records. Continue?')) {
            $this->info('Cancelled.');

            return self::SUCCESS;
        }

        $this->call('db:seed', ['--class' => ContentRestoreSeeder::class, '--force' => true]);

        $this->info('Content restored successfully.');

        return self::SUCCESS;
    }
}
