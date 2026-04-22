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
    private array $wheres = [];
    private array $params = [];
    private array $joins = [];
    private array $select = [];
    private ?string $orderBy = null;
    private string $orderDir = 'ASC';
    private ?int $limit = null;
    private ?int $offset = null;

    // NEW: raw SQL support
    private ?string $rawSql = null;

    public function __construct(PDO $pdo, string $table)
    {
        $this->pdo = $pdo;
        $this->table = $table; // no strict id() validation
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
    // Raw SQL
    // ----------------------------
    public function raw(string $sql, array $params = []): self
    {
        $this->rawSql = $sql;
        $this->params = $params;
        return $this;
    }

    // ----------------------------
    // Select / Join / Where
    // ----------------------------
    public function select(string|array $columns): self
    {
        if (is_string($columns)) $columns = explode(',', $columns);
        $this->select = array_map('trim', $columns);
        return $this;
    }

    public function join(string $table, string $first, string $operator, string $second, string $type = 'INNER'): self
    {
        $this->joins[] = strtoupper($type) . " JOIN {$table} ON {$first} {$operator} {$second}";
        return $this;
    }

    public function where(string|array $field, mixed $opOrValue = null, mixed $value = null): self
    {
        if ($this->rawSql) {
            throw new RuntimeException("Cannot use where() with raw SQL");
        }

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
            $op = strtoupper(trim((string)$opOrValue));
            $val = $value;
        }

        $ph = $this->param($val);
        $this->wheres[] = "{$field} {$op} {$ph}";
        return $this;
    }

    public function orderBy(string $column, string $dir = 'ASC'): self
    {
        $this->orderBy = $column;
        $this->orderDir = strtoupper(trim($dir)) === 'DESC' ? 'DESC' : 'ASC';
        return $this;
    }

    public function limit(int $limit, int $offset = 0): self
    {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

    // ----------------------------
    // Execute
    // ----------------------------
    public function get(): array
    {
        if ($this->rawSql) {
            $sql = $this->rawSql;
            if ($this->orderBy) $sql .= " ORDER BY {$this->orderBy} {$this->orderDir}";
            if ($this->limit !== null) {
                $sql .= " LIMIT {$this->limit}";
                if ($this->offset) $sql .= " OFFSET {$this->offset}";
            }
        } else {
            $sql = $this->buildSelectSql();
        }

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
        $cols = [];
        $vals = [];
        foreach ($data as $k => $v) {
            $cols[] = $k;
            $vals[] = $this->param($v);
        }

        $sql = "INSERT INTO {$this->table} (" . implode(',', $cols) . ") VALUES (" . implode(',', $vals) . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $this->pdo->lastInsertId();
    }

    public function update(array $data): int
    {
        if (!$this->wheres) throw new RuntimeException("Refusing to UPDATE without WHERE");

        $sets = [];
        foreach ($data as $k => $v) {
            $sets[] = "{$k} = " . $this->param($v);
        }

        $sql = "UPDATE {$this->table} SET " . implode(',', $sets) . $this->buildWhereSql();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    public function delete(): int
    {
        if (!$this->wheres) throw new RuntimeException("Refusing to DELETE without WHERE");

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

    public function truncate(): bool
    {
        $sql = "TRUNCATE TABLE {$this->table}";
        return $this->pdo->exec($sql) !== false;
    }

    // ----------------------------
    // Private helpers
    // ----------------------------
    private function buildSelectSql(): string
    {
        $cols = $this->select ? implode(',', $this->select) : '*';
        $sql = "SELECT {$cols} FROM {$this->table}";
        if ($this->joins) $sql .= ' ' . implode(' ', $this->joins);
        $sql .= $this->buildWhereSql();
        if ($this->orderBy) $sql .= " ORDER BY {$this->orderBy} {$this->orderDir}";
        if ($this->limit !== null) $sql .= " LIMIT {$this->limit}" . ($this->offset ? " OFFSET {$this->offset}" : '');
        return $sql;
    }

    private function buildWhereSql(): string
    {
        if (!$this->wheres) return '';
        return ' WHERE ' . implode(' AND ', $this->wheres);
    }

    private function param(mixed $value): string
    {
        $key = ':p' . (count($this->params) + 1);
        $this->params[$key] = $value;
        return $key;
    }
}
