<?php

class Sample_Data_Seeder_Model extends Query
{
    private int $householdCount = 100;
    private int $residentTarget = 2000;

    private array $residentIds = [];
    private array $householdIds = [];
    private array $programIds = [];

    private array $usedIdentityKeys = [];

    // ================= UTIL =================
    private function random(array $arr)
    {
        return $arr[array_rand($arr)];
    }

    private function batchInsert(string $table, array $rows): void
    {
        foreach ($rows as $row) {
            self::table($table)->insert($row);
        }
    }

    private function makeIdentityKey(string $first, ?string $middle, string $last, string $birthdate): string
    {
        return strtolower($first . '|' . ($middle ?? '') . '|' . $last . '|' . $birthdate);
    }

    // ================= ENTRY =================
    public function seedSampleData(): bool
    {
        $this->resetTables();

        $this->seedHouseholds();
        $this->seedResidents();

        $this->seedSocioEconomic();
        $this->seedHealth();

        $this->seedResidentStatusEvents();
        $this->enforceStatusConsistency();

        $this->seedPrograms();
        $this->seedBeneficiaries();

        return true;
    }

    // ================= RESET =================
    private function resetTables(): void
    {
        foreach (
            [
                'households',
                'residents',
                'socio_economic_profiles',
                'health_records',
                'death_records',
                'migration_records',
                'programs',
                'program_beneficiaries'
            ] as $table
        ) {
            if (self::table($table)->exists()) {
                self::table($table)->truncate();
            }
        }
    }

    // ================= HOUSEHOLDS =================
    private function seedHouseholds(): void
    {
        $rows = [];
        $purokCounters = [];

        for ($i = 1; $i <= $this->householdCount; $i++) {

            $purok = rand(1, 10);

            if (!isset($purokCounters[$purok])) {
                $purokCounters[$purok] = 1;
            }

            $code = sprintf('PRK%02d-%04d', $purok, $purokCounters[$purok]++);

            $rows[] = [
                'household_code'     => $code,
                'purok'              => "Purok $purok",
                'address'            => "Generated Address $i",
                'housing_type'       => $this->random(['Concrete', 'Semi-concrete', 'Wood']),
                'ownership_status'   => $this->random(['Owned', 'Rented', 'Informal Settler']),
                'comfort_room'       => $this->random(['Owned', 'Shared', 'None']),
                'water_system'       => $this->random(['Level 1', 'Level 2', 'Level 3']),
                'electricity_access' => rand(0, 1),
            ];
        }

        $this->batchInsert('households', $rows);
        $this->householdIds = range(1, $this->householdCount);
    }

    // ================= RESIDENTS =================
    private function seedResidents(): void
    {
        $rows = [];

        for ($i = 1; $i <= $this->residentTarget; $i++) {

            $attempts = 0;

            do {
                $age = $this->generateAge();
                $sex = rand(0, 1) ? 'Male' : 'Female';

                [$f, $m, $l] = $this->name($sex);

                $birthdate = date('Y-m-d', strtotime("-$age years"));

                $middle = rand(0, 1) ? $m : null;

                $key = $this->makeIdentityKey($f, $middle, $l, $birthdate);

                $attempts++;

                if ($attempts > 10) break;
            } while (isset($this->usedIdentityKeys[$key]));

            $this->usedIdentityKeys[$key] = true;

            $rows[] = [
                'household_id' => $this->random($this->householdIds),
                'first_name'   => $f,
                'middle_name'  => $middle,
                'last_name'    => $l,
                'sex'          => $sex,
                'birthdate'    => $birthdate,
                'civil_status' => $this->civilStatusByAge($age),
                'relationship' => $this->relationshipByAge($age),
                'status'       => 'Active',
            ];
        }

        $this->batchInsert('residents', $rows);
        $this->residentIds = range(1, $this->residentTarget);
    }

    // ================= SOCIO ECONOMIC =================
    private function seedSocioEconomic(): void
    {
        $rows = [];

        foreach ($this->residentIds as $id) {

            $profile = $this->generateEconomicProfile();

            $rows[] = [
                'resident_id'        => $id,
                'occupation'         => $profile['occupation'],
                'employment_status'  => $profile['employment_status'],
                'monthly_income'     => $profile['monthly_income'],
                'education_level'    => $profile['education_level'],
                'is_literate'        => $this->generateLiteracy($profile['education_level']),
            ];
        }

        $this->batchInsert('socio_economic_profiles', $rows);
    }

    // ================= REALISTIC PHILIPPINE ECONOMIC MODEL =================
    private function generateEconomicProfile(): array
    {
        $profiles = [

            ['occupation' => 'Unemployed', 'employment_status' => 'Unemployed', 'education' => ['None', 'Elementary', 'High School'], 'income' => [0, 0]],

            ['occupation' => 'Student', 'employment_status' => 'Student', 'education' => ['Elementary', 'High School', 'Senior High', 'College'], 'income' => [0, 5000]],

            ['occupation' => 'Vendor', 'employment_status' => 'Self-Employed', 'education' => ['Elementary', 'High School'], 'income' => [3000, 15000]],

            ['occupation' => 'Tricycle Driver', 'employment_status' => 'Self-Employed', 'education' => ['Elementary', 'High School'], 'income' => [6000, 18000]],

            ['occupation' => 'Laborer', 'employment_status' => 'Employed', 'education' => ['Elementary', 'High School'], 'income' => [8000, 16000]],

            ['occupation' => 'Factory Worker', 'employment_status' => 'Employed', 'education' => ['High School', 'Senior High'], 'income' => [12000, 22000]],

            ['occupation' => 'Office Clerk', 'employment_status' => 'Employed', 'education' => ['Senior High', 'College'], 'income' => [15000, 30000]],

            ['occupation' => 'Teacher', 'employment_status' => 'Employed', 'education' => ['College', 'Postgraduate'], 'income' => [25000, 50000]],

            ['occupation' => 'Nurse', 'employment_status' => 'Employed', 'education' => ['College'], 'income' => [30000, 60000]],

            ['occupation' => 'Engineer', 'employment_status' => 'Employed', 'education' => ['College'], 'income' => [35000, 90000]],

            ['occupation' => 'Retired', 'employment_status' => 'Retired', 'education' => ['Elementary', 'High School', 'College'], 'income' => [2000, 15000]],
        ];

        $p = $this->random($profiles);
        $education = $this->random($p['education']);

        return [
            'occupation'        => $p['occupation'],
            'employment_status' => $p['employment_status'],
            'monthly_income'    => rand($p['income'][0], $p['income'][1]),
            'education_level'   => $education,
        ];
    }

    // ================= LITERACY (EDUCATION-BASED PROBABILITY) =================
    private function generateLiteracy(string $education): int
    {
        $chance = match ($education) {
            'Postgraduate' => 99,
            'College'      => 98,
            'Senior High'  => 96,
            'High School'  => 92,
            'Elementary'   => 80,
            'None'         => 50,
            default         => 85
        };

        $chance = max(25, min(100, $chance + rand(-2, 2)));

        return rand(1, 100) <= $chance ? 1 : 0;
    }

    // ================= STATUS EVENTS =================
    private function seedResidentStatusEvents(): void
    {
        $deathRows = [];
        $migrationRows = [];

        foreach ($this->residentIds as $id) {

            $roll = rand(1, 100);

            if ($roll <= 6) {

                $deathRows[] = [
                    'resident_id'   => $id,
                    'date_of_death' => date('Y-m-d', strtotime('-' . rand(1, 10) . ' years')),
                    'cause'         => 'Natural Causes'
                ];

                self::table('residents')->where('id', $id)->update(['status' => 'Deceased']);
            } elseif ($roll <= 18) {

                $migrationRows[] = [
                    'resident_id'       => $id,
                    'migration_type'    => 'OUT',
                    'date_of_migration' => date('Y-m-d', strtotime('-' . rand(1, 5) . ' years')),
                    'origin'            => 'Barangay',
                    'destination'       => 'Unknown City'
                ];

                self::table('residents')->where('id', $id)->update(['status' => 'Transferred']);
            }
        }

        if ($deathRows) $this->batchInsert('death_records', $deathRows);
        if ($migrationRows) $this->batchInsert('migration_records', $migrationRows);
    }

    // ================= CONSISTENCY =================
    private function enforceStatusConsistency(): void
    {
        $residents = self::table('residents')->get();

        foreach ($residents as $r) {

            $hasDeath = self::table('death_records')->where('resident_id', $r['id'])->exists();

            $hasMigration = self::table('migration_records')
                ->where('resident_id', $r['id'])
                ->where('migration_type', 'OUT')
                ->exists();

            if ($hasDeath) {
                self::table('residents')->where('id', $r['id'])->update(['status' => 'Deceased']);
            }

            if ($hasMigration) {
                self::table('residents')->where('id', $r['id'])->update(['status' => 'Transferred']);
            }
        }
    }

    // ================= PROGRAMS =================
    private function seedPrograms(): void
    {
        $programs = [
            ['4Ps', 'Cash assistance'],
            ['Senior Aid', 'Elder support'],
            ['PWD Aid', 'Disability support'],
            ['Health Program', 'Medical services'],
            ['Scholarship', 'Education support'],
        ];

        $rows = [];

        foreach ($programs as $p) {
            $rows[] = [
                'program_name' => $p[0],
                'description'  => $p[1],
            ];
        }

        $this->batchInsert('programs', $rows);
        $this->programIds = range(1, count($programs));
    }

    // ================= BENEFICIARIES =================
    private function seedBeneficiaries(): void
    {
        $rows = [];

        foreach ($this->residentIds as $id) {

            if (rand(1, 100) > 60) continue;

            $rows[] = [
                'resident_id'   => $id,
                'program_id'    => $this->random($this->programIds),
                'date_enrolled' => date('Y-m-d'),
                'status'        => $this->random(['Active', 'Inactive']),
            ];
        }

        $this->batchInsert('program_beneficiaries', $rows);
    }

    // ================= DEMOGRAPHICS =================
    private function generateAge(): int
    {
        $r = rand(1, 100);

        if ($r <= 30) return rand(0, 14);
        if ($r <= 60) return rand(15, 34);
        if ($r <= 85) return rand(35, 59);
        return rand(60, 85);
    }

    private function civilStatusByAge(int $age): string
    {
        if ($age < 18) return 'Single';
        return $this->random(['Single', 'Married', 'Married', 'Widowed', 'Separated']);
    }

    private function relationshipByAge(int $age): string
    {
        if ($age >= 35) return $this->random(['Head', 'Spouse', 'Head']);
        if ($age >= 18) return $this->random(['Spouse', 'Child', 'Relative']);
        return 'Child';
    }

    private function name(string $sex): array
    {
        $male = ['Juan', 'Jose', 'Mark', 'John', 'Paul', 'Leo', 'Carlo', 'Miguel', 'Rafael', 'Daniel'];
        $female = ['Maria', 'Ana', 'Rosa', 'Angela', 'Catherine', 'Patricia', 'Andrea', 'Elena', 'Camille'];
        $middle = ['Santos', 'Reyes', 'Garcia', 'Torres', 'Flores', 'Ramos', 'Mendoza'];
        $last = ['Dela Cruz', 'Santos', 'Reyes', 'Garcia', 'Torres', 'Flores', 'Ramos'];

        $first = $sex === 'Male'
            ? $male[array_rand($male)]
            : $female[array_rand($female)];

        return [
            $first,
            $middle[array_rand($middle)],
            $last[array_rand($last)]
        ];
    }

    // ================= HEALTH =================
    private function seedHealth(): void
    {
        $rows = [];

        foreach ($this->residentIds as $id) {

            $rows[] = [
                'resident_id'             => $id,
                'is_pwd'                  => rand(1, 100) <= 5,
                'is_senior'              => rand(1, 100) <= 10,
                'has_chronic_illness'    => rand(1, 100) <= 15,
                'chronic_illness_details' => null,
                'blood_type'             => $this->random(['A+', 'B+', 'O+', 'AB+']),
                'vaccinated'             => rand(1, 100) <= 80,
            ];
        }

        $this->batchInsert('health_records', $rows);
    }
}
