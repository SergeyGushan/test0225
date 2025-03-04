<?php

declare(strict_types=1);

namespace App;

use App\Commands\Command;
use App\Commands\MigrateCommand;
use App\Controllers\ControllerAbstract;
use App\Modules\DB\Client;
use App\Modules\Request\Request;
use App\Modules\Router\Router;
use PDO;

class App
{
    private static array $loadedCommands = [];

    private static Client $dbClient;

    public static function start(): void
    {
        self::cors();
        self::loadRoutes();
        self::connect();

        $request = Request::make();
        $handle = Router::getHandler($request->method(), $request->path());

        if ($handle instanceof ControllerAbstract) {
            render($handle($request));
        }
    }

    public static function command(string $commandName, ...$args): void
    {
        self::loadCommands();
        self::connect();

        if (isset(self::$loadedCommands[$commandName])) {
            $commandClass = self::$loadedCommands[$commandName];

            /** @var Command $command */
            $command = new $commandClass(...$args);
            $command->handle();
        }
    }

    public static function db(): Client
    {
        return self::$dbClient;
    }

    private static function commands(): array
    {
        return [
            MigrateCommand::class
        ];
    }

    private static function connect(): void
    {
        self::$dbClient = new Client(
            config('db_host', 'localhost'),
            config('db_port', '5432'),
            config('db_user', 'root'),
            config('db_pass', ''),
            config('db_name', 'root'),
            config('db_connection', 'pgsql'),
            config('db_charset', 'utf8'),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    private static function loadRoutes(): void
    {
        require_once base_path(config('routes_path'));
    }

    private static function loadCommands(): void
    {
        foreach(self::commands() as $command) {
            if (is_subclass_of($command, Command::class)) {
                self::$loadedCommands[$command::getName()] = $command;
            }
        }
    }

    private static function cors(): void
    {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Origin: " . config('frontend_url'));
        header("Access-Control-Allow-Credentials: true");
    }
}