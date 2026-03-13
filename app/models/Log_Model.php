<?php

require_once 'app/core/Query.php';

class Log_Model extends Query
{
    /**
     * Fetch logs with optional search filter (action, description, or user's full_name)
     *
     * @param string $search Search term (optional)
     * @return array List of logs with user full_name
     */
    public function MOD_GET_LOGS(string $search = ''): array
    {
        // Base SQL with LEFT JOIN
        $sql = "
            SELECT logs.*, users.full_name
            FROM logs
            LEFT JOIN users ON users.id = logs.user_id
        ";

        $params = [];

        // Apply search filter if provided
        if (trim($search) !== '') {
            $sql .= " WHERE logs.action LIKE :search1 
                      OR logs.description LIKE :search2 
                      OR users.full_name LIKE :search3";
            $params[':search1'] = '%' . $search . '%';
            $params[':search2'] = '%' . $search . '%';
            $params[':search3'] = '%' . $search . '%';
        }

        // Order by creation date descending
        $sql .= " ORDER BY logs.created_at DESC";

        // Execute query using the new QueryBuilder raw() method
        return $this->table('logs')
            ->raw($sql, $params)
            ->get();
    }

    /**
     * Delete all logs from the logs table
     *
     * @return bool
     */
    public function MOD_CLEAR_LOGS(): bool
    {
        $sql = "TRUNCATE TABLE logs";

        $this->table('logs')
            ->raw($sql)
            ->get();

        return true;
    }

    /**
     * Get all logs for export
     *
     * @return array
     */
    public function MOD_GET_LOGS_FOR_EXPORT(): array
    {
        $sql = "
            SELECT 
                users.full_name,
                logs.action,
                logs.description,
                logs.created_at
            FROM logs
            LEFT JOIN users ON users.id = logs.user_id
            ORDER BY logs.created_at DESC
        ";

        return Query::table('logs')
            ->raw($sql)
            ->get();
    }
}
