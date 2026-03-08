<?php

require_once 'app/core/Query.php';

class User_Model extends Query
{
    public function MOD_GET_USER_BY_USERNAME_AND_ROLE($username, $role): ?array
    {
        $data = $this->table('users')->where('username', '=', $username)->where('role', '=', $role)->first();

        return $data;
    }

    public function MOD_GET_QUESTIONS_BY_USER_ID($user_id): array
    {
        $data = $this->table('security_questions')->where('user_id', '=', $user_id)->get();

        return $data;
    }

    public function MOD_VERIFY_SECURITY_ANSWERS($user_id, $answers): bool
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

    public function MOD_RESET_PASSWORD($user_id, $password): bool
    {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        return $this->table('users')
            ->where('id', '=', $user_id)
            ->update([
                'password_hash' => $password_hash
            ]);
    }
}
