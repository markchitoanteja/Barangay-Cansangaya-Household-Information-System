<?php

class Seed_Database_Model extends Query
{
    public function MOD_SEED_DATABASE(): bool
    {
        $this->createTables();
        $this->seedUsers();
        $this->seedSecurityQuestions();
        $this->seedSystemInformation();

        // 🔥 FIX: ensure data consistency after seeding
        $this->syncDataConsistency();

        return true;
    }

    public function dropAllTables(): void
    {
        $pdo = Database::pdo();

        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            $pdo->exec("DROP TABLE IF EXISTS `$table`");
        }

        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    public function is_seeded(): bool
    {
        try {
            return self::table('users')->exists();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * =========================
     * CREATE TABLES
     * =========================
     */
    private function createTables(): void
    {
        /* USERS */
        $usersColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(120) NOT NULL,
            username VARCHAR(60) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            role ENUM('SUPER_ADMIN','ADMIN','STAFF') NOT NULL DEFAULT 'STAFF',
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ";
        self::table('users')->createTableIfNotExists($usersColumns);

        /* SECURITY QUESTIONS */
        $securityColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            question VARCHAR(255) NOT NULL,
            answer_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
            ON DELETE CASCADE ON UPDATE CASCADE
        ";
        self::table('security_questions')->createTableIfNotExists($securityColumns);

        /* HOUSEHOLDS */
        $householdsColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            household_code VARCHAR(20) NOT NULL UNIQUE,
            purok VARCHAR(50) NOT NULL,
            address TEXT,
            housing_type ENUM('Concrete','Semi-concrete','Wood') NOT NULL,
            ownership_status ENUM('Owned','Rented','Informal Settler') DEFAULT NULL,
            comfort_room ENUM('Owned','Shared','None') NOT NULL,
            water_system ENUM('Level 1','Level 2','Level 3') NOT NULL,
            electricity_access TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ";
        self::table('households')->createTableIfNotExists($householdsColumns);

        /* RESIDENTS */
        $residentsColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            household_id INT NOT NULL,
            first_name VARCHAR(100) NOT NULL,
            middle_name VARCHAR(100),
            last_name VARCHAR(100) NOT NULL,
            sex ENUM('Male','Female') NOT NULL,
            birthdate DATE NOT NULL,
            civil_status ENUM('Single','Married','Widowed','Separated'),
            relationship ENUM('Head','Spouse','Child','Relative','Other'),
            status ENUM('Active','Deceased','Transferred') DEFAULT 'Active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_household (household_id),
            INDEX idx_name (last_name, first_name),
            FOREIGN KEY (household_id) REFERENCES households(id)
            ON DELETE CASCADE ON UPDATE CASCADE
        ";
        self::table('residents')->createTableIfNotExists($residentsColumns);

        /* SOCIO ECONOMIC */
        $socioEconomicColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            resident_id INT NOT NULL UNIQUE,
            occupation VARCHAR(150),
            employment_status ENUM('Employed','Unemployed','Self-employed','Student','Retired'),
            monthly_income DECIMAL(10,2),
            education_level ENUM('None','Elementary','High School','Senior High','College','Postgraduate'),
            is_literate TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (resident_id) REFERENCES residents(id)
            ON DELETE CASCADE ON UPDATE CASCADE
        ";
        self::table('socio_economic_profiles')->createTableIfNotExists($socioEconomicColumns);

        /* HEALTH */
        $healthColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            resident_id INT NOT NULL UNIQUE,
            is_pwd TINYINT(1) DEFAULT 0,
            is_senior TINYINT(1) DEFAULT 0,
            has_chronic_illness TINYINT(1) DEFAULT 0,
            chronic_illness_details TEXT,
            blood_type VARCHAR(5),
            vaccinated TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (resident_id) REFERENCES residents(id)
            ON DELETE CASCADE ON UPDATE CASCADE
        ";
        self::table('health_records')->createTableIfNotExists($healthColumns);

        /* PROGRAMS */
        $programsColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            program_name VARCHAR(150) NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ";
        self::table('programs')->createTableIfNotExists($programsColumns);

        /* BENEFICIARIES */
        $beneficiariesColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            resident_id INT NOT NULL,
            program_id INT NOT NULL,
            date_enrolled DATE,
            status ENUM('Active','Inactive') DEFAULT 'Active',
            UNIQUE KEY unique_beneficiary (resident_id, program_id),
            FOREIGN KEY (resident_id) REFERENCES residents(id)
            ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (program_id) REFERENCES programs(id)
            ON DELETE CASCADE ON UPDATE CASCADE
        ";
        self::table('program_beneficiaries')->createTableIfNotExists($beneficiariesColumns);

        /* LOGS */
        $logsColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            action VARCHAR(255) NOT NULL,
            target_table VARCHAR(100),
            target_id INT,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
            ON DELETE CASCADE ON UPDATE CASCADE
        ";
        self::table('logs')->createTableIfNotExists($logsColumns);

        /* SYSTEM INFO */
        $systemInfoColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            barangay_name VARCHAR(150) NOT NULL,
            official_logo VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ";
        self::table('system_information')->createTableIfNotExists($systemInfoColumns);

        /* TOKENS */
        $rememberTokensColumns = "
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            token VARCHAR(128) NOT NULL,
            expires_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX(user_id),
            INDEX(token),
            FOREIGN KEY (user_id) REFERENCES users(id)
            ON DELETE CASCADE ON UPDATE CASCADE
        ";
        self::table('user_remember_tokens')->createTableIfNotExists($rememberTokensColumns);

        /* DEATH / MIGRATION / FEATURES TABLES (UNCHANGED) */
        self::table('birth_records')->createTableIfNotExists("
            id INT AUTO_INCREMENT PRIMARY KEY,
            child_resident_id INT,
            mother_resident_id INT,
            date_of_birth DATE NOT NULL,
            sex ENUM('Male','Female') NOT NULL,
            FOREIGN KEY (child_resident_id) REFERENCES residents(id),
            FOREIGN KEY (mother_resident_id) REFERENCES residents(id)
        ");

        self::table('death_records')->createTableIfNotExists("
            id INT AUTO_INCREMENT PRIMARY KEY,
            resident_id INT NOT NULL,
            date_of_death DATE NOT NULL,
            cause_of_death VARCHAR(255),
            manner_of_death VARCHAR(255),
            FOREIGN KEY (resident_id) REFERENCES residents(id)
        ");

        self::table('migration_records')->createTableIfNotExists("
            id INT AUTO_INCREMENT PRIMARY KEY,
            resident_id INT,
            migration_type ENUM('IN','OUT') NOT NULL,
            date_of_migration DATE NOT NULL,
            origin VARCHAR(150),
            destination VARCHAR(150),
            FOREIGN KEY (resident_id) REFERENCES residents(id)
        ");

        self::table('population_features')->createTableIfNotExists("
            id INT AUTO_INCREMENT PRIMARY KEY,
            year INT NOT NULL,
            total_population INT,
            births INT DEFAULT 0,
            deaths INT DEFAULT 0,
            net_migration INT DEFAULT 0,
            male_ratio DECIMAL(5,2),
            female_ratio DECIMAL(5,2),
            avg_household_size DECIMAL(5,2),
            dependency_ratio DECIMAL(5,2),
            employment_rate DECIMAL(5,2),
            avg_income DECIMAL(10,2),
            growth_rate DECIMAL(6,4),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY unique_year (year)
        ");
    }

    /**
     * =========================
     * DATA CONSISTENCY FIX
     * =========================
     */
    private function syncDataConsistency(): void
    {
        $residents = self::table('residents')->get();

        foreach ($residents as $resident) {

            /* -------------------------
               DECEASED SYNC
            -------------------------- */
            if ($resident['status'] === 'Deceased') {

                $death = self::table('death_records')
                    ->where('resident_id', $resident['id'])
                    ->first();

                if (!$death) {
                    self::table('death_records')->insert([
                        'resident_id'   => $resident['id'],
                        'date_of_death' => date('Y-m-d'),
                        'cause'         => 'Auto-synced from resident status'
                    ]);
                }
            }

            $deathExists = self::table('death_records')
                ->where('resident_id', $resident['id'])
                ->exists();

            if ($deathExists && $resident['status'] !== 'Deceased') {
                self::table('residents')
                    ->where('id', $resident['id'])
                    ->update(['status' => 'Deceased']);
            }

            /* -------------------------
               TRANSFERRED SYNC
            -------------------------- */
            if ($resident['status'] === 'Transferred') {

                $migration = self::table('migration_records')
                    ->where('resident_id', $resident['id'])
                    ->where('migration_type', 'OUT')
                    ->first();

                if (!$migration) {
                    self::table('migration_records')->insert([
                        'resident_id'      => $resident['id'],
                        'migration_type'   => 'OUT',
                        'date_of_migration' => date('Y-m-d'),
                        'origin'           => 'Auto-synced',
                        'destination'      => 'Unknown'
                    ]);
                }
            }

            $migrationExists = self::table('migration_records')
                ->where('resident_id', $resident['id'])
                ->where('migration_type', 'OUT')
                ->exists();

            if ($migrationExists && $resident['status'] !== 'Transferred') {
                self::table('residents')
                    ->where('id', $resident['id'])
                    ->update(['status' => 'Transferred']);
            }
        }
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
