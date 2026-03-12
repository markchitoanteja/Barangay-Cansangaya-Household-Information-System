<?php

require_once 'app/core/Query.php';

class Seed_Database_Model extends Query
{
    /**
     * Run the full database seed.
     *
     * @return bool
     */
    public function MOD_SEED_DATABASE(): bool
    {
        $this->createTables();
        $this->seedUsers();
        $this->seedSecurityQuestions();

        return true;
    }

    /**
     * Create necessary tables if they don't exist.
     */
    private function createTables(): void
    {
        // USERS TABLE
        $usersColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(120) NOT NULL,
            username VARCHAR(60) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            role ENUM('ADMIN', 'STAFF') NOT NULL DEFAULT 'STAFF',

            is_active TINYINT(1) NOT NULL DEFAULT 1,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ";

        self::table('users')->createTableIfNotExists($usersColumns);

        // SECURITY QUESTIONS TABLE
        $securityColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            question VARCHAR(255) NOT NULL,
            answer_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT fk_security_questions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT uq_user_question UNIQUE (user_id, question)
        ";

        self::table('security_questions')->createTableIfNotExists($securityColumns);
    }

    /**
     * Seed default users if the table is empty.
     */
    private function seedUsers(): void
    {
        if (!self::table('users')->exists()) {

            self::table('users')->insert([
                'full_name'     => 'System Administrator',
                'username'      => 'admin',
                'password_hash' => '$2y$10$avell4wi0IzOscScWW8HW.ozWZnL.pkcpUnVpaSGlEd1f2B/OT27y',
                'role'          => 'ADMIN',
                'is_active'     => 1
            ]);

            self::table('users')->insert([
                'full_name'     => 'Barangay Staff',
                'username'      => 'staff',
                'password_hash' => '$2y$10$cRLnC4R97XVT9A7Whi8HB.I2IgOr3BCTFCFr7o4DWXEjPQB1WcMee',
                'role'          => 'STAFF',
                'is_active'     => 1
            ]);
        }
    }

    /**
     * Seed default security questions if the table is empty.
     */
    private function seedSecurityQuestions(): void
    {
        if (!self::table('security_questions')->exists()) {

            $defaultQuestions = [
                1 => [
                    ['question' => 'What is your favorite color?', 'answer_hash' => '$2a$12$tz2Eh3rDTv2HxGrpayprcuZLLR7nw5neAUNZmXOLrm2SiFsk./Dhi'],
                    ['question' => 'What is the name of your first pet?', 'answer_hash' => '$2a$12$tz2Eh3rDTv2HxGrpayprcuZLLR7nw5neAUNZmXOLrm2SiFsk./Dhi']
                ],
                2 => [
                    ['question' => 'What is your mother\'s maiden name?', 'answer_hash' => '$2a$12$tz2Eh3rDTv2HxGrpayprcuZLLR7nw5neAUNZmXOLrm2SiFsk./Dhi'],
                    ['question' => 'What was your first school?', 'answer_hash' => '$2a$12$tz2Eh3rDTv2HxGrpayprcuZLLR7nw5neAUNZmXOLrm2SiFsk./Dhi']
                ]
            ];

            foreach ($defaultQuestions as $userId => $questions) {
                foreach ($questions as $q) {
                    self::table('security_questions')->insert([
                        'user_id'     => $userId,
                        'question'    => $q['question'],
                        'answer_hash' => $q['answer_hash']
                    ]);
                }
            }
        }
    }
}
