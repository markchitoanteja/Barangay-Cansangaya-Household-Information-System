<?php

class Sample_Data_Seeder_Model extends Query
{
    private int $householdCount;
    private array $residentIds = [];
    private array $householdIds = [];
    private array $programIds = [];
    private array $householdMembers = [];

    // ================= UTIL =================
    private function random(array $arr)
    {
        return $arr[array_rand($arr)];
    }

    private function weighted(array $items)
    {
        $pool = [];
        foreach ($items as $item) {
            for ($i = 0; $i < $item['weight']; $i++) {
                $pool[] = $item;
            }
        }
        return $this->random($pool);
    }

    private function batchInsert(string $table, array $rows): void
    {
        foreach ($rows as $row) {
            self::table($table)->insert($row);
        }
    }

    // ================= POPULATION =================
    private function initializePopulation(): void
    {
        $type = $this->random(['small', 'medium', 'large']);

        if ($type === 'small') {
            $this->householdCount = rand(150, 300);
        } elseif ($type === 'medium') {
            $this->householdCount = rand(300, 700);
        } else {
            $this->householdCount = rand(700, 1200);
        }
    }

    // ================= ENTRY =================
    public function seedSampleData(): bool
    {
        $this->resetTables();
        $this->initializePopulation();

        $this->seedHouseholds();
        $this->seedResidentsStructured();

        $this->seedSocioEconomic();
        $this->seedHealth();

        $this->seedPrograms();
        $this->seedBeneficiariesSmart();

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
    private function seedResidentsStructured(): void
    {
        $rows = [];
        $id   = 1;

        foreach ($this->householdIds as $householdId) {

            $members = [];

            // -----------------------------------------------
            // STEP 1: Decide household surname (family name)
            // -----------------------------------------------
            $familyLastName = $this->randomLastName();

            // -----------------------------------------------
            // STEP 2: Decide head profile
            // 85% chance father is head, 15% mother is head
            // (solo parent, widow, separated, etc.)
            // -----------------------------------------------
            $headIsMale   = rand(1, 100) <= 85;
            $headSex      = $headIsMale ? 'Male' : 'Female';
            $headAge      = rand(28, 65);
            $headLastName = $familyLastName;

            // Head civil status
            // Heads are usually Married, but sometimes Single/Widowed/Separated
            $headCivilRoll = rand(1, 100);
            if ($headCivilRoll <= 70)       $headCivilStatus = 'Married';
            elseif ($headCivilRoll <= 82)   $headCivilStatus = 'Widowed';
            elseif ($headCivilRoll <= 92)   $headCivilStatus = 'Separated';
            else                            $headCivilStatus = 'Single';

            $rows[]    = $this->createPerson($householdId, $headSex, $headAge, 'Head', $headCivilStatus, $headLastName);
            $members[] = $id++;

            // -----------------------------------------------
            // STEP 3: Spouse (only if head is Married)
            // -----------------------------------------------
            $hasSpouse = false;

            if ($headCivilStatus === 'Married') {

                $spouseSex      = $headIsMale ? 'Female' : 'Male';
                $spouseAge      = $headAge + rand(-6, 6);
                $spouseAge      = max(18, $spouseAge);
                // Spouse takes the family last name (Filipino tradition: wife takes husband's surname)
                $spouseLastName = $familyLastName;

                $rows[]    = $this->createPerson($householdId, $spouseSex, $spouseAge, 'Spouse', 'Married', $spouseLastName);
                $members[] = $id++;
                $hasSpouse = true;
            }

            // -----------------------------------------------
            // STEP 4: Children
            // Number of children weighted realistically
            // -----------------------------------------------
            $roll = rand(1, 100);
            if ($roll <= 10)       $childCount = 0;
            elseif ($roll <= 28)   $childCount = 1;
            elseif ($roll <= 55)   $childCount = 2;
            elseif ($roll <= 78)   $childCount = 3;
            elseif ($roll <= 92)   $childCount = 4;
            else                   $childCount = rand(5, 7);

            // Max child age is constrained by head age (can't be older than parent)
            $maxChildAge = max(1, $headAge - 18);
            $maxChildAge = min($maxChildAge, 30); // adult children still living at home

            for ($c = 0; $c < $childCount; $c++) {

                $childAge      = rand(0, $maxChildAge);
                $childSex      = rand(0, 1) ? 'Male' : 'Female';
                $childLastName = $familyLastName; // children share family surname

                // Children under 18 are Single; older ones may vary
                if ($childAge < 18) {
                    $childCivilStatus = 'Single';
                } else {
                    $childCivilStatus = $this->random(['Single', 'Single', 'Single', 'Married', 'Separated']);
                }

                $rows[]    = $this->createPerson($householdId, $childSex, $childAge, 'Child', $childCivilStatus, $childLastName);
                $members[] = $id++;
            }

            // -----------------------------------------------
            // STEP 5: Extended family members (Relative)
            // ~25% of households have a relative living in
            // e.g., grandparent, sibling, cousin, etc.
            // -----------------------------------------------
            if (rand(1, 100) <= 25) {

                $relativeCount = rand(1, 2);

                for ($r = 0; $r < $relativeCount; $r++) {

                    // Relatives could be elderly parents OR young siblings
                    $relativeRoll = rand(1, 100);

                    if ($relativeRoll <= 35) {
                        // Grandparent
                        $relativeAge  = $headAge + rand(20, 35);
                        $relativeSex  = rand(0, 1) ? 'Male' : 'Female';
                        $relativeCivil = $this->random(['Married', 'Widowed', 'Widowed']);
                    } elseif ($relativeRoll <= 65) {
                        // Sibling of head (close in age)
                        $relativeAge  = $headAge + rand(-8, 8);
                        $relativeAge  = max(15, $relativeAge);
                        $relativeSex  = rand(0, 1) ? 'Male' : 'Female';
                        $relativeCivil = $this->random(['Single', 'Married', 'Separated']);
                    } else {
                        // Younger relative / nephew / niece
                        $relativeAge  = rand(5, 22);
                        $relativeSex  = rand(0, 1) ? 'Male' : 'Female';
                        $relativeCivil = $relativeAge < 18 ? 'Single' : $this->random(['Single', 'Single', 'Married']);
                    }

                    // Relatives MAY share the family surname or have a different one
                    $relativeLastName = rand(1, 100) <= 60
                        ? $familyLastName
                        : $this->randomLastName();

                    $rows[]    = $this->createPerson($householdId, $relativeSex, $relativeAge, 'Relative', $relativeCivil, $relativeLastName);
                    $members[] = $id++;
                }
            }

            // -----------------------------------------------
            // STEP 6: Other (boarder / helper / non-relative)
            // ~8% of households
            // -----------------------------------------------
            if (rand(1, 100) <= 8) {

                $otherAge      = rand(18, 45);
                $otherSex      = rand(0, 1) ? 'Male' : 'Female';
                $otherCivil    = $this->random(['Single', 'Single', 'Married', 'Separated']);
                // Boarders/helpers almost always have a different surname
                $otherLastName = $this->randomLastName();

                $rows[]    = $this->createPerson($householdId, $otherSex, $otherAge, 'Other', $otherCivil, $otherLastName);
                $members[] = $id++;
            }

            $this->householdMembers[$householdId] = $members;
        }

        $this->batchInsert('residents', $rows);
        $this->residentIds = range(1, $id - 1);

        // Apply deaths and migrations AFTER insert so IDs exist
        $this->applyDeathsAndMigrations();
    }

    private function createPerson($householdId, $sex, $age, $relationship, $civilStatus, $lastName): array
    {
        [$firstName, $middleName] = $this->generateName($sex);

        $birthYear = (int) date('Y') - $age;

        $birthdate = date(
            'Y-m-d',
            strtotime($birthYear . '-' . rand(1, 12) . '-' . rand(1, 28))
        );

        return [
            'household_id' => $householdId,
            'first_name'   => $firstName,
            'middle_name'  => rand(0, 1) ? $middleName : null,
            'last_name'    => $lastName,
            'sex'          => $sex,
            'birthdate'    => $birthdate,
            'civil_status' => $civilStatus,
            'relationship' => $relationship,
            'status'       => 'Active',
        ];
    }

    // ================= DEATHS & MIGRATIONS =================
    private function applyDeathsAndMigrations(): void
    {
        $deathRows     = [];
        $migrationRows = [];

        $causesOfDeath = [
            'Cardiovascular Disease',
            'Pneumonia',
            'Hypertension',
            'Diabetes Mellitus',
            'Stroke',
            'Cancer',
            'Renal Failure',
            'COVID-19 Complications',
            'Tuberculosis',
            'Accident',
            'Old Age',
            'Sepsis',
        ];

        $destinations = [
            'Cebu City',
            'Davao City',
            'Manila',
            'Quezon City',
            'Cagayan de Oro',
            'Zamboanga City',
            'Iloilo City',
            'Bacolod',
            'Antipolo',
            'Pasig City',
            'Taguig City',
            'Makati City',
            'General Santos City',
            'Butuan City',
            'Tagum City',
            'Digos City',
            'Iligan City',
            'Ozamiz City',
        ];

        foreach ($this->residentIds as $rid) {

            $r   = self::table('residents')->where('id', $rid)->first();
            $age = $this->calculateAge($r['birthdate']);

            // -------------------------
            // DEATH PROBABILITY
            // -------------------------
            $deathChance = 0;
            if ($age >= 75)      $deathChance = 20;
            elseif ($age >= 70)  $deathChance = 15;
            elseif ($age >= 60)  $deathChance = 10;
            elseif ($age >= 50)  $deathChance = 5;
            elseif ($age >= 18)  $deathChance = 2;
            elseif ($age <= 1)   $deathChance = 5;
            elseif ($age <= 5)   $deathChance = 2;
            else                 $deathChance = 1;

            if (rand(1, 100) <= $deathChance) {

                self::table('residents')
                    ->where('id', $rid)
                    ->update(['status' => 'Deceased']);

                $daysAgo     = rand(1, 365 * 10);
                $dateOfDeath = date('Y-m-d', strtotime("-{$daysAgo} days"));

                $manner = ($age >= 50)
                    ? $this->random(['Natural', 'Natural', 'Natural', 'Natural', 'Unknown'])
                    : $this->random(['Natural', 'Accident', 'Accident', 'Unknown']);

                $cause = ($age >= 60)
                    ? $this->random([
                        'Cardiovascular Disease',
                        'Cardiovascular Disease',
                        'Stroke',
                        'Stroke',
                        'Cancer',
                        'Renal Failure',
                        'Pneumonia',
                        'Diabetes Mellitus',
                        'Old Age',
                        'Old Age',
                    ])
                    : $this->random($causesOfDeath);

                $deathRows[] = [
                    'resident_id'     => $rid,
                    'date_of_death'   => $dateOfDeath,
                    'cause_of_death'  => $cause,
                    'manner_of_death' => $manner,
                ];

                continue;
            }

            // -------------------------
            // MIGRATION (OUT) PROBABILITY
            // -------------------------
            $migrateChance = 0;
            if ($age >= 18 && $age <= 30)        $migrateChance = 10;
            elseif ($age > 30 && $age <= 40)     $migrateChance = 6;
            elseif ($age > 40 && $age <= 55)     $migrateChance = 3;
            elseif ($age > 55)                   $migrateChance = 1;

            if (rand(1, 100) <= $migrateChance) {

                self::table('residents')
                    ->where('id', $rid)
                    ->update(['status' => 'Transferred']);

                $daysAgo         = rand(1, 365 * 5);
                $dateOfMigration = date('Y-m-d', strtotime("-{$daysAgo} days"));

                $migrationRows[] = [
                    'resident_id'       => $rid,
                    'migration_type'    => 'OUT',
                    'date_of_migration' => $dateOfMigration,
                    'origin'            => 'Barangay (Local)',
                    'destination'       => $this->random($destinations),
                ];
            }
        }

        $this->batchInsert('death_records',     $deathRows);
        $this->batchInsert('migration_records', $migrationRows);
    }

    // ================= SOCIO ECONOMIC =================
    private function seedSocioEconomic(): void
    {
        $rows = [];

        foreach ($this->residentIds as $id) {

            $r       = self::table('residents')->where('id', $id)->first();
            $age     = $this->calculateAge($r['birthdate']);
            $profile = $this->generateEconomicProfile($r['sex'], $age);

            $rows[] = [
                'resident_id'       => $id,
                'occupation'        => $profile['occupation'],
                'employment_status' => $profile['employment_status'],
                'monthly_income'    => $profile['monthly_income'],
                'education_level'   => $profile['education_level'],
                'is_literate'       => $this->generateLiteracy($profile['education_level']),
            ];
        }

        $this->batchInsert('socio_economic_profiles', $rows);
    }

    private function generateEconomicProfile(string $sex, int $age): array
    {
        if ($age < 18) {
            return [
                'occupation'        => 'Student',
                'employment_status' => 'Student',
                'monthly_income'    => 0,
                'education_level'   => $age < 12
                    ? 'Elementary'
                    : $this->random(['Elementary', 'High School']),
            ];
        }

        if ($age >= 60 && rand(1, 100) <= 70) {
            return [
                'occupation'        => 'Retired',
                'employment_status' => 'Retired',
                'monthly_income'    => rand(2000, 15000),
                'education_level'   => $this->random(['Elementary', 'High School', 'College']),
            ];
        }

        $shared = [
            ['occupation' => 'Vendor',        'employment_status' => 'Self-Employed', 'education' => ['Elementary', 'High School'],   'income' => [3000, 15000],  'weight' => 12],
            ['occupation' => 'Office Clerk',   'employment_status' => 'Employed',      'education' => ['Senior High', 'College'],      'income' => [15000, 30000], 'weight' => 10],
            ['occupation' => 'Teacher',        'employment_status' => 'Employed',      'education' => ['College'],                     'income' => [25000, 50000], 'weight' => 8],
            ['occupation' => 'Factory Worker', 'employment_status' => 'Employed',      'education' => ['High School'],                 'income' => [12000, 22000], 'weight' => 8],
            ['occupation' => 'Unemployed',     'employment_status' => 'Unemployed',    'education' => ['None'],                        'income' => [0, 0],         'weight' => 10],
        ];

        $extra = $sex === 'Male'
            ? [
                ['occupation' => 'Laborer',         'employment_status' => 'Employed',      'education' => ['Elementary'],  'income' => [8000, 16000],  'weight' => 10],
                ['occupation' => 'Driver',           'employment_status' => 'Self-Employed', 'education' => ['Elementary'],  'income' => [6000, 18000],  'weight' => 8],
            ]
            : [
                ['occupation' => 'Nurse',            'employment_status' => 'Employed',      'education' => ['College'],     'income' => [30000, 60000], 'weight' => 8],
                ['occupation' => 'Home-based Worker', 'employment_status' => 'Self-Employed', 'education' => ['Elementary'],  'income' => [3000, 12000],  'weight' => 8],
            ];

        $p = $this->weighted(array_merge($shared, $extra));

        return [
            'occupation'        => $p['occupation'],
            'employment_status' => $p['employment_status'],
            'monthly_income'    => rand($p['income'][0], $p['income'][1]),
            'education_level'   => $this->random($p['education']),
        ];
    }

    // ================= HEALTH =================
    private function seedHealth(): void
    {
        $rows = [];

        foreach ($this->residentIds as $id) {
            $rows[] = [
                'resident_id'             => $id,
                'is_pwd'                  => rand(1, 100) <= 5  ? 1 : 0,
                'is_senior'               => rand(1, 100) <= 10 ? 1 : 0,
                'has_chronic_illness'     => rand(1, 100) <= 15 ? 1 : 0,
                'chronic_illness_details' => null,
                'blood_type'              => $this->random(['A+', 'B+', 'O+', 'AB+']),
                'vaccinated'              => rand(1, 100) <= 80 ? 1 : 0,
            ];
        }

        $this->batchInsert('health_records', $rows);
    }

    // ================= PROGRAMS =================
    private function seedPrograms(): void
    {
        $this->batchInsert('programs', [
            [
                'program_name' => 'Pantawid Pamilyang Pilipino Program (4Ps)',
                'description'  => 'Conditional cash transfer program for low-income households provided by DSWD. Supports health, nutrition, and education of children aged 0–18 through compliance with school attendance and health check-up requirements.',
            ],
            [
                'program_name' => 'Social Pension for Indigent Senior Citizens',
                'description'  => 'Monthly financial assistance provided to senior citizens aged 60 and above who are frail, sickly, or without regular income or family support, implemented under the Social Welfare and Development programs.',
            ],
            [
                'program_name' => 'Assistance to Persons with Disabilities (PWD Assistance Program)',
                'description'  => 'Support program providing financial aid, medical assistance, and priority access services to registered persons with disabilities to improve mobility, livelihood, and healthcare access.',
            ],
            [
                'program_name' => 'Barangay Health and Medical Assistance Program',
                'description'  => 'Local health initiative offering free basic consultations, maternal care services, immunization, and financial assistance for hospital referrals and emergency medical cases.',
            ],
            [
                'program_name' => 'Educational Assistance and Scholarship Program',
                'description'  => 'Financial support for elementary, high school, and college students from low-income families, including tuition assistance, school supplies, and allowance subsidies based on academic performance and household income.',
            ],
            [
                'program_name' => 'Livelihood Assistance and Skills Training Program',
                'description'  => 'Capability-building program providing TESDA-accredited skills training, startup capital assistance, and livelihood kits for unemployed and underemployed residents to promote self-sufficiency.',
            ],
            [
                'program_name' => 'Emergency Shelter Assistance Program',
                'description'  => 'Disaster-response housing support for families affected by fires, typhoons, and other emergencies, including temporary shelter aid, construction materials, and relocation assistance.',
            ],
            [
                'program_name' => 'Solo Parent Welfare Assistance Program',
                'description'  => 'Support program for registered solo parents providing monthly financial aid, counseling services, and priority access to livelihood and educational assistance programs.',
            ],
        ]);

        $this->programIds = range(1, 8);
    }

    private function seedBeneficiariesSmart(): void
    {
        $rows = [];

        foreach ($this->householdMembers as $householdId => $members) {

            $householdIncome = 0;
            $hasChild        = false;

            foreach ($members as $rid) {

                $profile = self::table('socio_economic_profiles')
                    ->where('resident_id', $rid)
                    ->first();

                $householdIncome += $profile['monthly_income'] ?? 0;

                $resident = self::table('residents')
                    ->where('id', $rid)
                    ->first();

                if ($resident && $this->calculateAge($resident['birthdate']) < 18) {
                    $hasChild = true;
                }
            }

            $isLowIncome = $householdIncome < 20000;

            foreach ($members as $rid) {

                $r = self::table('residents')->where('id', $rid)->first();
                if (!$r) continue;

                if (in_array($r['status'], ['Deceased', 'Transferred'])) continue;

                $age     = $this->calculateAge($r['birthdate']);
                $profile = self::table('health_records')->where('resident_id', $rid)->first();

                // 1. 4Ps
                if ($isLowIncome && $hasChild) {
                    $rows[] = $this->beneficiaryRow($rid, 1);
                }

                // 2. Senior Pension
                if ($age >= 60) {
                    $rows[] = $this->beneficiaryRow($rid, 2);
                }

                // 3. PWD Assistance
                if (!empty($profile['is_pwd'])) {
                    $rows[] = $this->beneficiaryRow($rid, 3);
                }

                // 4. Scholarship Program
                if ($age >= 6 && $age <= 24 && $isLowIncome) {
                    $rows[] = $this->beneficiaryRow($rid, 5);
                }

                // 5. Livelihood Program
                if ($age >= 18 && $age <= 59 && $isLowIncome && rand(1, 100) <= 60) {
                    $rows[] = $this->beneficiaryRow($rid, 6);
                }

                // 6. Health Program (default coverage)
                if (rand(1, 100) <= 80) {
                    $rows[] = $this->beneficiaryRow($rid, 4);
                }
            }
        }

        $this->batchInsert('program_beneficiaries', $rows);
    }

    private function beneficiaryRow($rid, $pid): array
    {
        return [
            'resident_id'   => $rid,
            'program_id'    => $pid,
            'date_enrolled' => date('Y-m-d'),
            'status'        => 'Active',
        ];
    }

    // ================= HELPERS =================
    private function calculateAge($birthdate): int
    {
        return (int) date_diff(date_create($birthdate), date_create('today'))->y;
    }

    private function generateLiteracy(string $education): int
    {
        return rand(1, 100) <= 90 ? 1 : 0;
    }

    private function randomLastName(): string
    {
        $lastNames = [
            'Dela Cruz',
            'Santos',
            'Reyes',
            'Garcia',
            'Torres',
            'Flores',
            'Ramos',
            'Mendoza',
            'Gonzales',
            'Cruz',
            'Bautista',
            'Navarro',
            'Castro',
            'Diaz',
            'Domingo',
            'Aquino',
            'Villanueva',
            'Salvador',
            'Aguilar',
            'Santiago',
            'Valdez',
            'Mercado',
            'De Guzman',
            'Padilla',
            'Alvarez',
            'Morales',
            'Jimenez',
            'Lopez',
            'Hernandez',
            'Sison',
            'Buenaventura',
            'Manalo',
            'Pascual',
            'Tolentino',
            'Delos Reyes',
            'Ocampo',
            'Macaraeg',
            'Soriano',
            'Espiritu',
            'Cordero',
            'Generoso',
            'Catalan',
            'Magno',
            'Tiongson',
        ];

        return $lastNames[array_rand($lastNames)];
    }

    private function generateName(string $sex): array
    {
        $male = [
            'Juan',
            'Jose',
            'Mark',
            'John',
            'Paul',
            'Miguel',
            'Andres',
            'Pedro',
            'Rafael',
            'Luis',
            'Gabriel',
            'Antonio',
            'Carlos',
            'Daniel',
            'Joseph',
            'Michael',
            'Christopher',
            'Jonathan',
            'Ramon',
            'Edgar',
            'Leo',
            'Victor',
            'Francis',
            'Jomar',
            'Kevin',
            'Bryan',
            'Jerome',
            'Allan',
            'Arvin',
            'Christian',
            'Ronald',
            'Alfred',
            'Dennis',
            'Reynaldo',
            'Jesse',
            'Nico',
            'Julius',
            'Erwin',
            'Ian',
            'Noel',
            'Paolo',
            'Marco',
            'Ryan',
            'Elmer',
            'Rey',
            'Emmanuel',
            'Arthur',
            'Vincent',
            'Earl',
            'Brylle',
            'Ken',
            'Lester',
        ];

        $female = [
            'Maria',
            'Ana',
            'Rosa',
            'Angela',
            'Andrea',
            'Princess',
            'Joy',
            'Grace',
            'Jasmine',
            'Rose',
            'Alyssa',
            'Kimberly',
            'Nicole',
            'Patricia',
            'Christine',
            'Angelica',
            'Janelle',
            'Kathleen',
            'Rachelle',
            'Mary',
            'Lea',
            'Liza',
            'Micaela',
            'Bianca',
            'Krizia',
            'Clarisse',
            'Lovely',
            'Danica',
            'Reina',
            'Cheska',
            'Shaina',
            'Janine',
            'Gretchen',
            'Carla',
            'Mae',
            'Ella',
            'Sophia',
            'Chloe',
            'Yvonne',
            'Hazel',
            'Angel',
            'April',
            'Denise',
            'Joyce',
            'Michelle',
            'Kim',
            'Aira',
            'Megan',
            'Paula',
            'Sarah',
            'Trisha',
        ];

        $middle = [
            'Santos',
            'Reyes',
            'Garcia',
            'Torres',
            'Flores',
            'Ramos',
            'Mendoza',
            'Gonzales',
            'Cruz',
            'Bautista',
            'Navarro',
            'Castro',
            'Diaz',
            'Domingo',
            'Aquino',
            'Dela Cruz',
            'Villanueva',
            'Salvador',
            'Aguilar',
            'Santiago',
            'Valdez',
            'Mercado',
            'De Guzman',
            'Padilla',
            'Alvarez',
            'Morales',
            'Jimenez',
            'Lopez',
            'Hernandez',
            'Sison',
        ];

        $firstName  = $sex === 'Male'
            ? $male[array_rand($male)]
            : $female[array_rand($female)];

        $middleName = $middle[array_rand($middle)];

        return [$firstName, $middleName];
    }
}
