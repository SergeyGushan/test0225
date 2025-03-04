<?php

declare(strict_types=1);

namespace App\Commands;

abstract class Command
{
    abstract static public function getName(): string;

    abstract public function handle(): void;
}