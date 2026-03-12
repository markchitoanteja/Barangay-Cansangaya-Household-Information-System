<?php

require_once 'app/core/Query.php';

class User_Model extends Query
{
    public function MOD_GET_USER_BY_USERNAME_AND_ROLE(string $username, string $role): ?array
    {
        $data = $this->table('users')->where('username', '=', $username)->where('role', '=', $role)->first();

        return $data;
    }

    public function MOD_GET_QUESTIONS_BY_USER_ID($user_id): array
    {
        $data = $this->table('security_questions')->where('user_id', '=', $user_id)->get();

        return $data;
    }

    public function MOD_VERIFY_SECURITY_ANSWERS(int $user_id, mixed $answers): bool
    {
        $stored_answers = $this->table('security_questions')
            ->where('user_id', '=', $user_id)
            ->get();

        if (empty($stored_answers) || empty($answers)) {
            return false;
        }

        $stored_map = [];
        foreach ($stored_answers as $stored) {
            $stored_map[$stored['id']] = $stored['answer_hash'];
        }

        if (count($answers) !== count($stored_map)) {
            return false;
        }

        foreach ($answers as $submitted) {

            if (!isset($submitted['id'], $submitted['answer'])) {
                return false;
            }

            $question_id = (int)$submitted['id'];
            $plain_answer = strtolower(trim($submitted['answer']));

            if (!isset($stored_map[$question_id])) {
                return false;
            }

            if (!password_verify($plain_answer, $stored_map[$question_id])) {
                return false;
            }
        }

        return true;
    }

    public function MOD_RESET_PASSWORD(int $user_id, string $password): bool
    {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        return $this->table('users')
            ->where('id', '=', $user_id)
            ->update([
                'password_hash' => $password_hash
            ]);
    }

    public function MOD_CHECK_IF_USERNAME_EXISTS(string $username, int $user_id): bool
    {
        return $this->table('users')->where('username', $username)->where('id', '!=', $user_id)->exists();
    }

    public function MOD_GET_HASHED_PASSWORD_BY_ID(int $user_id): string
    {
        $row = $this->table('users')->select('password_hash')->where('id', $user_id)->first();

        return $row['password_hash'];
    }

    public function MOD_UPDATE_ACCOUNT(int $user_id, array $data): bool
    {
        return $this->table('users')->where('id', $user_id)->update($data);
    }

    public function MOD_GET_USER_BY_ID($user_id): ?array
    {
        $data = $this->table('users')->where('id', $user_id)->first();

        return $data;
    }

    public function MOD_GET_ALL_USERS_EXCLUDE_CURRENT_USER($user_id): array
    {
        $data = $this->table('users')->where('id', '!=', $user_id)->orderBy('id', 'DESC')->get();

        return $data;
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
        return $this->table('users')
            ->where('id', '!=', $exclude_user_id)
            ->get() // fetch all matching rows
            ? count($this->table('users')->where('id', '!=', $exclude_user_id)->get())
            : 0;
    }

    public function MOD_SEARCH_USERS(string $search_input, string $role, string $status, int $exclude_user_id): array
    {
        // Ensure inputs are strings
        $search_input = trim((string)$search_input);
        $role = trim((string)$role);
        $status = trim((string)$status);

        // Start query excluding current user
        $query = $this->table('users')->where('id', '!=', $exclude_user_id);

        // Apply role filter if provided
        if ($role !== '') {
            $query->where('role', '=', $role);
        }

        // Apply status filter if provided
        if ($status !== '') {
            $status_int = (int)$status;
            $query->where('is_active', '=', $status_int);
        }

        // Fetch initial results from DB
        $users = $query->orderBy('id', 'DESC')->get();

        // Apply search input filter (name OR username, case-insensitive)
        if ($search_input !== '') {
            $search_lower = strtolower($search_input);

            $users = array_filter($users, function ($user) use ($search_lower) {
                return str_contains(strtolower($user['full_name']), $search_lower) ||
                    str_contains(strtolower($user['username']), $search_lower);
            });
        }

        // Re-index array to ensure consecutive keys
        return array_values($users);
    }
}
