<?php

class User_Model extends Query
{
    // =========================================
// REMEMBER ME TOKEN MANAGEMENT
// =========================================

    /**
     * Store a remember token for a user
     *
     * @param int $user_id
     * @param string $token
     * @param int $expiry_seconds Optional expiration time in seconds (default 30 days)
     * @return bool
     */
    public function MOD_STORE_REMEMBER_TOKEN(int $user_id, string $token, int $expiry_seconds = 2592000): bool
    {
        $expires_at = date('Y-m-d H:i:s', time() + $expiry_seconds);

        // Store in dedicated table
        return $this->table('user_remember_tokens')->insert([
            'user_id'    => $user_id,
            'token'      => $token,
            'expires_at' => $expires_at,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Validate a remember token
     *
     * @param int $user_id
     * @param string $token
     * @return bool
     */
    public function VALIDATE_REMEMBER_TOKEN(int $user_id, string $token): bool
    {
        $row = $this->table('user_remember_tokens')
            ->where('user_id', '=', $user_id)
            ->where('token', '=', $token)
            ->where('expires_at', '>', date('Y-m-d H:i:s')) // Not expired
            ->first();

        return !empty($row);
    }

    /**
     * Clear all remember tokens for a user
     *
     * @param int $user_id
     * @return bool
     */
    public function MOD_CLEAR_REMEMBER_TOKENS(int $user_id): bool
    {
        return $this->table('user_remember_tokens')
            ->where('user_id', '=', $user_id)
            ->delete();
    }
    // =========================================
    // AUTH METHODS
    // =========================================

    public function MOD_GET_USER_BY_USERNAME_AND_ROLE(string $username, string $role): ?array
    {
        return $this->table('users')
            ->where('username', '=', $username)
            ->where('role', '=', $role)
            ->first();
    }

    // ✅ NEW (used for SUPER_ADMIN login bypass)
    public function MOD_GET_USER_BY_USERNAME(string $username): ?array
    {
        return $this->table('users')
            ->where('username', '=', $username)
            ->first();
    }

    // =========================================
    // SECURITY QUESTIONS
    // =========================================
    public function MOD_GET_QUESTIONS_BY_USER_ID($user_id): array
    {
        return $this->table('security_questions')
            ->where('user_id', '=', $user_id)
            ->get();
    }

    public function MOD_VERIFY_SECURITY_ANSWERS(int $user_id, mixed $answers): bool
    {
        $stored_answers = $this->MOD_GET_QUESTIONS_BY_USER_ID($user_id);

        if (empty($stored_answers) || empty($answers)) return false;

        $stored_map = [];
        foreach ($stored_answers as $stored) {
            $stored_map[$stored['id']] = $stored['answer_hash'];
        }

        if (count($answers) !== count($stored_map)) return false;

        foreach ($answers as $submitted) {
            if (!isset($submitted['id'], $submitted['answer'])) return false;

            $question_id  = (int)$submitted['id'];
            $plain_answer = strtolower(trim($submitted['answer']));

            if (!isset($stored_map[$question_id])) return false;
            if (!password_verify($plain_answer, $stored_map[$question_id])) return false;
        }

        return true;
    }

    public function MOD_INSERT_SECURITY_QUESTIONS(int $user_id, array $questions): bool
    {
        foreach ($questions as $question) {
            $this->table('security_questions')->insert([
                'user_id'     => $user_id,
                'question'    => $question,
                // ✅ secure default (normalized)
                'answer_hash' => password_hash(strtolower('test'), PASSWORD_BCRYPT)
            ]);
        }
        return true;
    }

    public function MOD_UPDATE_SECURITY_QUESTION_BY_ID(int $user_id, int $question_id, string $newQuestion, ?string $newAnswer = null): bool
    {
        $data = [
            'question'   => $newQuestion,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($newAnswer !== null && $newAnswer !== '') {
            $data['answer_hash'] = password_hash(strtolower($newAnswer), PASSWORD_BCRYPT);
        }

        return $this->table('security_questions')
            ->where('user_id', '=', $user_id)
            ->where('id', '=', $question_id)
            ->update($data);
    }

    public function MOD_GET_QUESTIONS_BY_ID(int $user_id): array
    {
        return $this->table('security_questions')
            ->where('user_id', $user_id)
            ->get();
    }

    public function MOD_GET_RANDOM_SECURITY_QUESTIONS(int $limit = 3): array
    {
        $questionBank = [
            'What is your favorite color?',
            'What is the name of your first pet?',
            'What city were you born in?',
            'What is your mother\'s maiden name?',
            'What was the name of your first school?',
            'What is your favorite food?',
            'What was your childhood nickname?',
            'What was your first job?',
            'What is your favorite movie?'
        ];

        shuffle($questionBank);
        return array_slice($questionBank, 0, $limit);
    }

    // =========================================
    // PASSWORD MANAGEMENT
    // =========================================
    
    public function MOD_RESET_PASSWORD(int $user_id, string $password): bool
    {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        return $this->table('users')
            ->where('id', '=', $user_id)
            ->update(['password_hash' => $password_hash]);
    }

    public function MOD_GET_HASHED_PASSWORD_BY_ID(int $user_id): ?string
    {
        $row = $this->table('users')
            ->select('password_hash')
            ->where('id', $user_id)
            ->first();

        return $row['password_hash'] ?? null;
    }

    // =========================================
    // USER VALIDATION
    // =========================================

    public function MOD_CHECK_IF_USERNAME_EXISTS(string $username, ?int $user_id = null): bool
    {
        $query = $this->table('users')->where('username', $username);

        if ($user_id) {
            $query->where('id', '!=', $user_id);
        }

        return $query->exists();
    }

    // =========================================
    // USER CRUD
    // =========================================

    public function MOD_GET_USER_BY_ID($user_id): ?array
    {
        return $this->table('users')
            ->where('id', $user_id)
            ->first();
    }

    public function MOD_GET_ALL_USERS_EXCLUDE_CURRENT_USER($user_id): array
    {
        return $this->table('users')
            ->where('id', '!=', $user_id)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function MOD_GET_USERS_PAGINATED($exclude_user_id, int $limit, int $offset): array
    {
        return $this->table('users')
            ->where('id', '!=', $exclude_user_id)
            ->orderBy('id', 'DESC')
            ->limit($limit, $offset)
            ->get();
    }

    public function MOD_GET_USERS_COUNT($exclude_user_id): int
    {
        $users = $this->table('users')
            ->where('id', '!=', $exclude_user_id)
            ->get();

        return $users ? count($users) : 0;
    }

    public function MOD_SEARCH_USERS(string $search_input, string $role, string $status, int $exclude_user_id): array
    {
        $search_input = trim($search_input);
        $role         = trim($role);
        $status       = trim($status);

        $query = $this->table('users')
            ->where('id', '!=', $exclude_user_id);

        if ($role !== '') {
            $query->where('role', '=', $role);
        }

        if ($status !== '') {
            $query->where('is_active', '=', (int)$status);
        }

        $users = $query->orderBy('id', 'DESC')->get();

        if ($search_input !== '') {
            $search_lower = strtolower($search_input);

            $users = array_filter($users, function ($user) use ($search_lower) {
                return str_contains(strtolower($user['full_name']), $search_lower) ||
                    str_contains(strtolower($user['username']), $search_lower);
            });
        }

        return array_values($users);
    }

    public function MOD_ADD_USER_ACCOUNT(array $data): string
    {
        return $this->table('users')->insert($data);
    }

    public function MOD_UPDATE_USER_ACCOUNT(int $user_id, array $data): int
    {
        return $this->table('users')
            ->where('id', $user_id)
            ->update($data);
    }

    public function MOD_UPDATE_USER_ACCOUNT_SUPER_ADMIN_MODE(int $user_id, array $data): int
    {
        return $this->table('users')
            ->where('id', $user_id)
            ->update($data);
    }

    public function MOD_ENABLE_DISABLE_USER_ACCOUNT(int $user_id, array $data): bool
    {
        return $this->table('users')
            ->where('id', $user_id)
            ->update($data);
    }

    public function MOD_UPDATE_ACCOUNT(int $user_id, array $data): bool
    {
        return $this->table('users')->where('id', $user_id)->update($data);
    }
}
