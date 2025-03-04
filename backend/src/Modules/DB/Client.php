<?php

declare(strict_types=1);

namespace App\Modules\DB;

use PDO;

class Client
{
    private PDO $pdo;

    public function __construct(
        string $host,
        string $port,
        string $user,
        string $pass,
        string $dbname,
        string $dbConnection,
        string $charset = 'utf8',
        array $options = [],
    ) {
        $dsn = "$dbConnection:host=$host;port=$port;dbname=$dbname;options='--client_encoding=$charset'";

        $this->pdo = new PDO($dsn, $user, $pass, $options);
    }

    public function execMigration(Migration $migration): void
    {
        $this->pdo->exec($migration->sql());
    }

    public function insert(string $tableName, array $data): void
    {
        if (empty($data)) {
            return;
        }

        $this->insertMany($tableName, [$data]);
    }

    public function insertMany(string $tableName, array $data): void
    {
        if (empty($data)) {
            return;
        }

        $columns = implode(', ', array_keys($data[0]));
        $placeholders = [];

        foreach ($data as $key => $row) {
            $placeholders[] = '(' . implode(', ', array_map(fn($col) => ':' . $col . $key, array_keys($row))) . ')';
        }

        $query = $this->pdo->prepare(
            "INSERT INTO $tableName ($columns) VALUES " . implode(', ', $placeholders)
        );


        foreach ($data as  $key => $row) {
            foreach ($row as $column => $value) {
                $query->bindValue(':' . $column . $key, $value, $this->getType($value));
            }
        }

        $query->execute();
    }

    public function select(
        string $tableName,
        array $fields = ['*'],
        array $pagination = [],
        array $where = [],
        array $orderBy = []
    ): array {
        $fieldsSql = implode(', ', $fields);

        $whereSql = '';
        if (!empty($where)) {
            $whereClauses = [];

            foreach ($where as $column => $value) {
                $whereClauses[] = "$column = :$column";
            }

            $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
        }

        $orderBySql = '';
        if (!empty($orderBy)) {
            $orderByClauses = [];
            foreach ($orderBy as $column => $direction) {
                $orderByClauses[] = "$column $direction";
            }
            $orderBySql = 'ORDER BY ' . implode(', ', $orderByClauses);
        }

        $paginationSql = '';
        if (!empty($pagination)) {
            $limit = isset($pagination['limit']) ? (int)$pagination['limit'] : 25;
            $offset = isset($pagination['offset']) ? (int)$pagination['offset'] : 0;
            $paginationSql = "LIMIT $limit OFFSET $offset";
        }

        $query = "SELECT $fieldsSql FROM $tableName $whereSql $orderBySql $paginationSql";

        $query = $this->pdo->prepare($query);

        foreach ($where as $column => $value) {
            $query->bindValue(":$column", $value, $this->getType($value));
        }

        $query->execute();

        return $query->fetchAll();
    }

    private function getType(mixed $value): int
    {
        return match (gettype($value)) {
            'integer' => PDO::PARAM_INT,
            'boolean' => PDO::PARAM_BOOL,
            default => PDO::PARAM_STR,
        };
    }


}