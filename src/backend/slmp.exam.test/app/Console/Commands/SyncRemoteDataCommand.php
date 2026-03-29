<?php

namespace App\Console\Commands;

use App\Services\RemoteDataSyncService;
use Illuminate\Console\Command;
use Throwable;

class SyncRemoteDataCommand extends Command
{
    protected $signature = 'remote-data:sync';

    protected $description = 'Fetch remote API data and persist it locally.';

    public function __construct(private readonly RemoteDataSyncService $syncService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $result = $this->syncService->sync();
        } catch (Throwable $throwable) {
            $this->components->error($throwable->getMessage());

            report($throwable);

            return self::FAILURE;
        }

        $this->components->info('Remote API data synchronized successfully.');
        $this->newLine();
        $this->table(
            ['Resource', 'Imported'],
            collect($result->toArray())
                ->map(fn (int $count, string $resource): array => [ucfirst($resource), $count])
                ->values()
                ->all(),
        );

        return self::SUCCESS;
    }
}
