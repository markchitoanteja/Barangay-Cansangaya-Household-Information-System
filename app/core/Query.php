<?php

require_once __DIR__ . '/Database.php';

class Query
{
    /**
     * Start a fluent query for a table.
     *
     * @param string $table Table name.
     */
    public static function table(string $table): QueryBuilder
    {
        return new QueryBuilder(Database::pdo(), $table);
    }
}

final class QueryBuilder
{
    private PDO $pdo;
    private string $table;
    private array $select = ['*'];
    private array $wheres = [];
    private array $params = [];
    private ?string $orderBy = null;
    private string $orderDir = 'ASC';
    private ?int $limit = null;
    private ?int $offset = null;

    public function __construct(PDO $pdo, string $table)
    {
        $this->pdo = $pdo;
        $this->table = $this->id($table);
    }

    // ----------------------------
    // New: Create table if not exists
    // ----------------------------
    /**
     * Create a table if it does not exist using raw SQL.
     *
     * @param string $columnsDefinition Example: "id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50)"
     * @param string|null $engine Optional table engine, default 'InnoDB'
     * @return bool True if executed successfully
     */
    public function createTableIfNotExists(string $columnsDefinition, ?string $engine = 'InnoDB'): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} ({$columnsDefinition}) ENGINE={$engine} DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    // ----------------------------
    // CRUD Methods
    // ----------------------------
    public function select(string $columns = '*'): self
    {
        $columns = trim($columns);
        if ($columns === '*') {
            $this->select = ['*'];
        } else {
            $parts = array_map('trim', explode(',', $columns));
            $this->select = array_map(fn($c) => $this->id($c), $parts);
        }
        return $this;
    }

    public function where(string|array $field, mixed $opOrValue = null, mixed $value = null): self
    {
        if (is_array($field)) {
            foreach ($field as $k => $v) {
                $this->where($k, '=', $v);
            }
            return $this;
        }

        if ($value === null) {
            $op = '=';
            $val = $opOrValue;
        } else {
            $op = (string)$opOrValue;
            $val = $value;
        }

        $op = strtoupper(trim($op));
        $allowedOps = ['=', '!=', '<>', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN'];
        if (!in_array($op, $allowedOps, true)) {
            throw new InvalidArgumentException("Invalid operator: {$op}");
        }

        $col = $this->id($field);

        if ($op === 'IN' || $op === 'NOT IN') {
            if (!is_array($val) || count($val) === 0) {
                throw new InvalidArgumentException("{$op} requires a non-empty array.");
            }
            $placeholders = [];
            foreach ($val as $v) {
                $placeholders[] = $this->param($v);
            }
            $this->wheres[] = "{$col} {$op} (" . implode(', ', $placeholders) . ")";
            return $this;
        }

        $ph = $this->param($val);
        $this->wheres[] = "{$col} {$op} {$ph}";
        return $this;
    }

    public function orderBy(string $column, string $dir = 'ASC'): self
    {
        $this->orderBy = $this->id($column);
        $dir = strtoupper(trim($dir));
        $this->orderDir = ($dir === 'DESC') ? 'DESC' : 'ASC';
        return $this;
    }

    public function limit(int $limit, int $offset = 0): self
    {
        $this->limit = max(0, $limit);
        $this->offset = max(0, $offset);
        return $this;
    }

    public function get(): array
    {
        $sql = $this->buildSelectSql();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first(): ?array
    {
        $prevLimit = $this->limit;
        $prevOffset = $this->offset;
        if ($this->limit === null) $this->limit(1, 0);
        $rows = $this->get();
        $this->limit = $prevLimit;
        $this->offset = $prevOffset;
        return $rows[0] ?? null;
    }

    public function insert(array $data): string
    {
        if (!$data) throw new InvalidArgumentException("Insert data cannot be empty.");

        $cols = [];
        $vals = [];
        foreach ($data as $k => $v) {
            $cols[] = $this->id((string)$k);
            $vals[] = $this->param($v);
        }

        $sql = "INSERT INTO {$this->table} (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $this->pdo->lastInsertId();
    }

    public function update(array $data): int
    {
        if (!$data) throw new InvalidArgumentException("Update data cannot be empty.");
        if (!$this->wheres) throw new RuntimeException("Refusing to UPDATE without WHERE.");

        $sets = [];
        foreach ($data as $k => $v) {
            $col = $this->id((string)$k);
            $ph = $this->param($v);
            $sets[] = "{$col} = {$ph}";
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . $this->buildWhereSql();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    public function delete(): int
    {
        if (!$this->wheres) throw new RuntimeException("Refusing to DELETE without WHERE.");

        $sql = "DELETE FROM {$this->table}" . $this->buildWhereSql();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    public function exists(): bool
    {
        $sql = "SELECT EXISTS(SELECT 1 FROM {$this->table}" . $this->buildWhereSql() . " LIMIT 1) AS exists_result";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return (bool) $stmt->fetchColumn();
    }

    // ----------------------------
    // Private helpers
    // ----------------------------
    private function buildSelectSql(): string
    {
        $sql = "SELECT " . implode(', ', $this->select) . " FROM {$this->table}";
        $sql .= $this->buildWhereSql();

        if ($this->orderBy) $sql .= " ORDER BY {$this->orderBy} {$this->orderDir}";
        if ($this->limit !== null) {
            $sql .= " LIMIT " . (int)$this->limit;
            if ($this->offset !== null && $this->offset > 0) $sql .= " OFFSET " . (int)$this->offset;
        }
        return $sql;
    }

    private function buildWhereSql(): string
    {
        if (!$this->wheres) return '';
        return " WHERE " . implode(' AND ', $this->wheres);
    }

    private function param(mixed $value): string
    {
        $key = ':p' . (count($this->params) + 1);
        $this->params[$key] = $value;
        return $key;
    }

    private function id(string $identifier): string
    {
        $identifier = trim($identifier);
        if ($identifier === '*') return '*';
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $identifier)) throw new InvalidArgumentException("Invalid identifier: {$identifier}");
        return $identifier;
    }
}
