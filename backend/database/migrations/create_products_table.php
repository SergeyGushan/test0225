<?php

declare(strict_types=1);

use App\Modules\DB\Migration;

return new class extends Migration
{
    public function getName(): string
    {
        return 'create-products-table';
    }

    public function sql(): string
    {
        return <<<SQL
            CREATE TABLE products (
                id SERIAL PRIMARY KEY,
                code VARCHAR(50) NOT NULL,
                name VARCHAR(255) NOT NULL,
                level1 VARCHAR(255),
                level2 VARCHAR(255),
                level3 VARCHAR(255),
                price INT,
                price_sp INT,
                quantity INT DEFAULT 0,
                property_fields JSONB,
                joint_purchases BOOLEAN DEFAULT FALSE,
                unit VARCHAR(50),
                image VARCHAR(255),
                show_on_main BOOLEAN DEFAULT FALSE,
                description TEXT
            );
        SQL;
    }
};
