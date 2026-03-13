<?php

require_once __DIR__ . '/../core/Query.php';

if (!function_exists('write_log')) {

    /**
     * Write an action log to the database using Query builder style
     *
     * Usage:
     * write_log('ADD_USER', 'users', 12, 'Created a new user account');
     * write_log('LOGIN_SUCCESS'); // current session user is used automatically
     *
     * @param string $action Action type (e.g., ADD_USER, UPDATE_USER)
     * @param string|null $target_table Optional table affected
     * @param int|null $target_id Optional record ID affected
     * @param string|null $description Optional detailed description
     * @param int|null $user_id Optional user performing the action (defaults to session user)
     */
    function write_log(
        string $action,
        ?string $target_table = null,
        ?int $target_id = null,
        ?string $description = null,
        ?int $user_id = null
    ): void {
        static $query;

        if (!$query) {
            $query = new Query();
        }

        // Use current session user if no user_id provided
        if ($user_id === null && function_exists('session_get')) {
            $current_user = session_get('user', null);
            $user_id = $current_user['id'] ?? 0;
        }

        if ($user_id === 0) {
            return; // cannot log without a valid user
        }

        $query->table('logs')->insert([
            'user_id' => $user_id,
            'action' => $action,
            'target_table' => $target_table,
            'target_id' => $target_id,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}