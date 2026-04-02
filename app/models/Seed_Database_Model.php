<?php

class Seed_Database_Model extends Query
{
    /**
     * Run the full database seed.
     */
    public function MOD_SEED_DATABASE(): bool
    {
        $this->createTables();
        $this->seedUsers();
        $this->seedSecurityQuestions();
        $this->seedSystemInformation();

        return true;
    }

    /**
     * Check if the database has already been seeded.
     */
    public function is_seeded(): bool
    {
        try {
            // If the 'users' table exists and has at least one row, consider the DB seeded
            return self::table('users')->exists();
        } catch (PDOException $e) {
            // Table does not exist yet
            return false;
        }
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
            role ENUM('SUPER_ADMIN', 'ADMIN', 'STAFF') NOT NULL DEFAULT 'STAFF',
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
            CONSTRAINT fk_security_questions_user 
                FOREIGN KEY (user_id) REFERENCES users(id) 
                ON DELETE CASCADE ON UPDATE CASCADE
        ";
        self::table('security_questions')->createTableIfNotExists($securityColumns);

        // LOGS TABLE
        $logsColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            action VARCHAR(255) NOT NULL,
            target_table VARCHAR(100) DEFAULT NULL,
            target_id INT DEFAULT NULL,
            description TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT fk_logs_user 
                FOREIGN KEY (user_id) REFERENCES users(id) 
                ON DELETE CASCADE ON UPDATE CASCADE
        ";
        self::table('logs')->createTableIfNotExists($logsColumns);

        // HOUSEHOLDS TABLE
        $householdsColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            household_code VARCHAR(20) NOT NULL UNIQUE,
            purok VARCHAR(50) NOT NULL,
            address TEXT,
            housing_type ENUM('Concrete','Semi-concrete','Wood') NOT NULL,
            comfort_room ENUM('Owned','Shared','None') NOT NULL,
            water_system ENUM('Level 1','Level 2','Level 3') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ";
        self::table('households')->createTableIfNotExists($householdsColumns);


        // RESIDENTS TABLE
        $residentsColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,

            household_id INT NOT NULL,

            first_name VARCHAR(100) NOT NULL,
            middle_name VARCHAR(100),
            last_name VARCHAR(100) NOT NULL,

            sex ENUM('Male','Female') NOT NULL,
            birthdate DATE NOT NULL,

            civil_status ENUM('Single','Married','Widowed','Separated'),

            relationship ENUM('Head','Spouse','Child','Relative'),

            -- LIVELIHOOD
            is_farmer TINYINT(1) DEFAULT 0,
            is_fisherfolk TINYINT(1) DEFAULT 0,
            has_sari_sari TINYINT(1) DEFAULT 0,

            -- SOCIAL SECTORS
            is_pwd TINYINT(1) DEFAULT 0,
            is_solo_parent TINYINT(1) DEFAULT 0,
            is_4ps TINYINT(1) DEFAULT 0,

            -- HEALTH
            teen_pregnancy TINYINT(1) DEFAULT 0,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

            CONSTRAINT fk_residents_household
                FOREIGN KEY (household_id)
                REFERENCES households(id)
                ON DELETE CASCADE ON UPDATE CASCADE
        ";
        self::table('residents')->createTableIfNotExists($residentsColumns);

        // SYSTEM INFORMATION TABLE
        $systemInfoColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            barangay_name VARCHAR(150) NOT NULL,
            official_logo VARCHAR(255) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ";
        self::table('system_information')->createTableIfNotExists($systemInfoColumns);

        // REMEMBER TOKENS TABLE
        $rememberTokensColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            token VARCHAR(128) NOT NULL,
            expires_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT fk_remember_tokens_user
                FOREIGN KEY (user_id) REFERENCES users(id)
                ON DELETE CASCADE ON UPDATE CASCADE,
            INDEX(user_id),
            INDEX(token)
        ";
        self::table('user_remember_tokens')->createTableIfNotExists($rememberTokensColumns);
    }

    /**
     * Seed default users if the table is empty.
     */
    private function seedUsers(): void
    {
        if (!self::table('users')->exists()) {
            self::table('users')->insert([
                'full_name'     => 'System Super Administrator',
                'username'      => 'superadmin',
                'password_hash' => password_hash('superadmin123', PASSWORD_BCRYPT),
                'role'          => 'SUPER_ADMIN',
                'is_active'     => 1
            ]);

            self::table('users')->insert([
                'full_name'     => 'System Administrator',
                'username'      => 'admin',
                'password_hash' =>  password_hash('admin123', PASSWORD_BCRYPT),
                'role'          => 'ADMIN',
                'is_active'     => 1
            ]);

            self::table('users')->insert([
                'full_name'     => 'Barangay Staff',
                'username'      => 'staff',
                'password_hash' =>  password_hash('staff123', PASSWORD_BCRYPT),
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

            $defaultAnswerHash = password_hash('test', PASSWORD_BCRYPT);

            $defaultQuestions = [
                1 => [
                    'What is your favorite color?',
                    'What is the name of your first pet?',
                    'What city were you born in?'
                ],
                2 => [
                    'What is your mother\'s maiden name?',
                    'What was the name of your first school?',
                    'What is your favorite food?'
                ],
                3 => [
                    'What was your childhood nickname?',
                    'What was your first job?',
                    'What is your favorite movie?'
                ]
            ];

            foreach ($defaultQuestions as $userId => $questions) {
                foreach ($questions as $question) {
                    self::table('security_questions')->insert([
                        'user_id'     => $userId,
                        'question'    => $question,
                        'answer_hash' => $defaultAnswerHash
                    ]);
                }
            }
        }
    }

    /**
     * Seed default system information if table is empty.
     */
    private function seedSystemInformation(): void
    {
        if (!self::table('system_information')->exists()) {
            self::table('system_information')->insert([
                'barangay_name'   => 'Sample',
                'official_logo'   => 'default_logo.png'
            ]);
        }
    }
}
