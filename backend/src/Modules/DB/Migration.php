<?php

declare(strict_types=1);

namespace App\Modules\DB;

abstract class Migration
{
    abstract public function getName(): string;

    abstract public function sql(): string;
}