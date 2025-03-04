<?php

declare(strict_types=1);

namespace App\Commands;

use App\App;
use App\Modules\DB\Migration;
use Exception;

class MigrateCommand extends Command
{
    private array $migrations = [];

    public function __construct(
        readonly string $migrateName,
    ) {
        $this->loadMigrations();
    }

    public static function getName(): string
    {
        return 'migrate';
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $migration = $this->migrations[$this->migrateName] ?? null;

        if (is_null($migration)) {
            throw new Exception("Migration with name {$this->migrateName} not found");
        }

        App::db()->execMigration($migration);
    }

    private function loadMigrations(): void
    {
        $filesNamesMigrations = files_from_folder($this->pathMigrations());

        foreach ($filesNamesMigrations as $fileNameMigration) {
            $migration = require_once $this->pathMigration($fileNameMigration);

            if ($migration instanceof Migration) {
                $this->migrations[$migration->getName()] = $migration;
            }
        }
    }

    private function pathMigration(string $fileName): string
    {
        return $this->pathMigrations() . DIRECTORY_SEPARATOR . $fileName;
    }

    private function pathMigrations(): string
    {
        return base_path(config('migrations_patch'));
    }
}