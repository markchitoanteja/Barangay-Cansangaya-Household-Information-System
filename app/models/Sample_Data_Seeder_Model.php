<?php

class Sample_Data_Seeder_Model extends Query
{
    private int $householdCount;
    private array $residentIds = [];
    private array $householdIds = [];
    private array $programIds = [];
    private array $householdMembers = [];

    // =========================================================
    // UTILITIES
    // =========================================================

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

    // =========================================================
    // DATE HELPERS
    // =========================================================

    /**
     * Historical data begins at least 10 years before
     * the current year.
     *
     * Example:
     * Current year = 2026
     * Historical start = 2016-01-01
     */
    private function sampleStartDate(): string
    {
        return ((int) date('Y') - 10) . '-01-01';
    }

    /**
     * Generate a random date between two dates.
     */
    private function randomDateBetween(
        string $startDate,
        string $endDate
    ): string {
        $start = strtotime($startDate);
        $end = strtotime($endDate);

        if (
            $start === false ||
            $end === false ||
            $start > $end
        ) {
            return date('Y-m-d');
        }

        return date(
            'Y-m-d',
            rand($start, $end)
        );
    }

    /**
     * Generate a historical date while making sure
     * it is not earlier than the supplied minimum date.
     */
    private function randomHistoricalDate(
        ?string $minimumDate = null
    ): string {
        $historicalStart = strtotime(
            $this->sampleStartDate()
        );

        $minimumTimestamp = $minimumDate
            ? strtotime($minimumDate)
            : $historicalStart;

        if ($minimumTimestamp === false) {
            $minimumTimestamp = $historicalStart;
        }

        $start = max(
            $historicalStart,
            $minimumTimestamp
        );

        $today = strtotime(date('Y-m-d'));

        if ($start > $today) {
            return date('Y-m-d');
        }

        return $this->randomDateBetween(
            date('Y-m-d', $start),
            date('Y-m-d', $today)
        );
    }

    // =========================================================
    // POPULATION INITIALIZATION
    // =========================================================

    private function initializePopulation(): void
    {
        $type = $this->random([
            'small',
            'medium',
            'large'
        ]);

        if ($type === 'small') {

            $this->householdCount = rand(
                150,
                300
            );

        } elseif ($type === 'medium') {

            $this->householdCount = rand(
                300,
                700
            );

        } else {

            $this->householdCount = rand(
                700,
                1200
            );
        }
    }

    // =========================================================
    // MAIN SEEDER
    // =========================================================

    public function seedSampleData(): bool
    {
        $this->resetTables();

        $this->initializePopulation();

        $this->seedHouseholds();

        $this->seedResidentsStructured();

        $this->seedBirthRecords();

        $this->seedSocioEconomic();

        $this->seedHealth();

        $this->seedPrograms();

        $this->seedBeneficiariesSmart();

        return true;
    }

    // =========================================================
    // RESET
    // =========================================================

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
                'birth_records',
                'programs',
                'program_beneficiaries'
            ] as $table
        ) {

            if (self::table($table)->exists()) {
                self::table($table)->truncate();
            }
        }
    }

    // =========================================================
    // HOUSEHOLDS
    // =========================================================

    private function seedHouseholds(): void
    {
        $rows = [];
        $purokCounters = [];

        for (
            $i = 1;
            $i <= $this->householdCount;
            $i++
        ) {

            $purok = rand(1, 7);

            if (!isset($purokCounters[$purok])) {
                $purokCounters[$purok] = 1;
            }

            $code = sprintf(
                'PRK%02d-%04d',
                $purok,
                $purokCounters[$purok]++
            );

            $rows[] = [

                'household_code' => $code,

                'purok' => "Purok $purok",

                'address' =>
                    "Generated Address $i",

                'housing_type' => $this->random([
                    'Concrete',
                    'Semi-concrete',
                    'Wood'
                ]),

                'ownership_status' => $this->random([
                    'Owned',
                    'Rented',
                    'Informal Settler'
                ]),

                'comfort_room' => $this->random([
                    'Owned',
                    'Shared',
                    'None'
                ]),

                'water_system' => $this->random([
                    'Level 1: Well/Spring',
                    'Level 2: Communal faucet',
                    'Level 3: Household connection'
                ]),

                'electricity_access' => rand(0, 1),
            ];
        }

        $this->batchInsert(
            'households',
            $rows
        );

        $this->householdIds = range(
            1,
            $this->householdCount
        );
    }

    // =========================================================
    // RESIDENTS
    // =========================================================

    private function seedResidentsStructured(): void
    {
        $rows = [];

        $id = 1;

        foreach ($this->householdIds as $householdId) {

            $members = [];

            // -------------------------------------------------
            // FAMILY SURNAME
            // -------------------------------------------------

            $familyLastName =
                $this->randomLastName();

            // -------------------------------------------------
            // HOUSEHOLD HEAD
            // -------------------------------------------------

            $headIsMale =
                rand(1, 100) <= 85;

            $headSex =
                $headIsMale
                ? 'Male'
                : 'Female';

            $headAge = rand(28, 65);

            // -------------------------------------------------
            // HEAD CIVIL STATUS
            // -------------------------------------------------

            $headCivilRoll = rand(1, 100);

            if ($headCivilRoll <= 70) {

                $headCivilStatus = 'Married';

            } elseif ($headCivilRoll <= 82) {

                $headCivilStatus = 'Widowed';

            } elseif ($headCivilRoll <= 92) {

                $headCivilStatus = 'Separated';

            } else {

                $headCivilStatus = 'Single';
            }

            $rows[] = $this->createPerson(
                $householdId,
                $headSex,
                $headAge,
                'Head',
                $headCivilStatus,
                $familyLastName
            );

            $members[] = $id++;

            // -------------------------------------------------
            // SPOUSE
            // -------------------------------------------------

            if ($headCivilStatus === 'Married') {

                $spouseSex =
                    $headIsMale
                    ? 'Female'
                    : 'Male';

                $spouseAge =
                    $headAge + rand(-6, 6);

                $spouseAge =
                    max(18, $spouseAge);

                $rows[] = $this->createPerson(
                    $householdId,
                    $spouseSex,
                    $spouseAge,
                    'Spouse',
                    'Married',
                    $familyLastName
                );

                $members[] = $id++;
            }

            // -------------------------------------------------
            // CHILDREN
            // -------------------------------------------------

            $roll = rand(1, 100);

            if ($roll <= 10) {

                $childCount = 0;

            } elseif ($roll <= 28) {

                $childCount = 1;

            } elseif ($roll <= 55) {

                $childCount = 2;

            } elseif ($roll <= 78) {

                $childCount = 3;

            } elseif ($roll <= 92) {

                $childCount = 4;

            } else {

                $childCount = rand(5, 7);
            }

            $maxChildAge =
                max(1, $headAge - 18);

            $maxChildAge =
                min($maxChildAge, 30);

            for (
                $c = 0;
                $c < $childCount;
                $c++
            ) {

                $childAge =
                    rand(0, $maxChildAge);

                $childSex =
                    rand(0, 1)
                    ? 'Male'
                    : 'Female';

                if ($childAge < 18) {

                    $childCivilStatus =
                        'Single';

                } else {

                    $childCivilStatus =
                        $this->random([
                            'Single',
                            'Single',
                            'Single',
                            'Married',
                            'Separated'
                        ]);
                }

                $rows[] = $this->createPerson(
                    $householdId,
                    $childSex,
                    $childAge,
                    'Child',
                    $childCivilStatus,
                    $familyLastName
                );

                $members[] = $id++;
            }

            // -------------------------------------------------
            // EXTENDED FAMILY
            // -------------------------------------------------

            if (rand(1, 100) <= 25) {

                $relativeCount = rand(1, 2);

                for (
                    $r = 0;
                    $r < $relativeCount;
                    $r++
                ) {

                    $relativeRoll =
                        rand(1, 100);

                    if ($relativeRoll <= 35) {

                        // Grandparent

                        $relativeAge =
                            $headAge + rand(20, 35);

                        $relativeSex =
                            rand(0, 1)
                            ? 'Male'
                            : 'Female';

                        $relativeCivil =
                            $this->random([
                                'Married',
                                'Widowed',
                                'Widowed'
                            ]);

                    } elseif ($relativeRoll <= 65) {

                        // Sibling

                        $relativeAge =
                            $headAge + rand(-8, 8);

                        $relativeAge =
                            max(
                                15,
                                $relativeAge
                            );

                        $relativeSex =
                            rand(0, 1)
                            ? 'Male'
                            : 'Female';

                        $relativeCivil =
                            $this->random([
                                'Single',
                                'Married',
                                'Separated'
                            ]);

                    } else {

                        // Younger relative

                        $relativeAge =
                            rand(5, 22);

                        $relativeSex =
                            rand(0, 1)
                            ? 'Male'
                            : 'Female';

                        $relativeCivil =
                            $relativeAge < 18
                            ? 'Single'
                            : $this->random([
                                'Single',
                                'Single',
                                'Married'
                            ]);
                    }

                    $relativeLastName =
                        rand(1, 100) <= 60
                        ? $familyLastName
                        : $this->randomLastName();

                    $rows[] = $this->createPerson(
                        $householdId,
                        $relativeSex,
                        $relativeAge,
                        'Relative',
                        $relativeCivil,
                        $relativeLastName
                    );

                    $members[] = $id++;
                }
            }

            // -------------------------------------------------
            // OTHER HOUSEHOLD MEMBERS
            // -------------------------------------------------

            if (rand(1, 100) <= 8) {

                $otherAge =
                    rand(18, 45);

                $otherSex =
                    rand(0, 1)
                    ? 'Male'
                    : 'Female';

                $otherCivil =
                    $this->random([
                        'Single',
                        'Single',
                        'Married',
                        'Separated'
                    ]);

                $rows[] = $this->createPerson(
                    $householdId,
                    $otherSex,
                    $otherAge,
                    'Other',
                    $otherCivil,
                    $this->randomLastName()
                );

                $members[] = $id++;
            }

            $this->householdMembers[
                $householdId
            ] = $members;
        }

        $this->batchInsert(
            'residents',
            $rows
        );

        $this->residentIds =
            range(1, $id - 1);

        // Generate historical demographic events.
        $this->applyDeathsAndMigrations();
    }

    // =========================================================
    // CREATE PERSON
    // =========================================================

    private function createPerson(
        $householdId,
        $sex,
        $age,
        $relationship,
        $civilStatus,
        $lastName
    ): array {

        [$firstName, $middleName] =
            $this->generateName($sex);

        $birthYear =
            (int) date('Y') - $age;

        $birthdate = date(
            'Y-m-d',
            strtotime(
                $birthYear .
                '-' .
                rand(1, 12) .
                '-' .
                rand(1, 28)
            )
        );

        return [

            'household_id' =>
                $householdId,

            'first_name' =>
                $firstName,

            'middle_name' =>
                rand(0, 1)
                ? $middleName
                : null,

            'last_name' =>
                $lastName,

            'sex' =>
                $sex,

            'birthdate' =>
                $birthdate,

            'civil_status' =>
                $civilStatus,

            'relationship' =>
                $relationship,

            'status' =>
                'Active',
        ];
    }

    // =========================================================
    // DEATHS AND MIGRATIONS
    // =========================================================

    private function applyDeathsAndMigrations(): void
    {
        $deathRows = [];
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

        $origins = [

            'Cebu City',
            'Davao City',
            'Manila',
            'Quezon City',
            'Tacloban City',
            'Borongan City',
            'Ormoc City',
            'Catbalogan City',
            'Calbayog City',
            'Baybay City',
            'Guiuan',
            'Catarman',
            'Allen',
            'Sogod',
            'Basey',
            'Northern Samar',
            'Southern Leyte',
            'Biliran',
            'Leyte',
        ];

        // =====================================================
        // EXISTING RESIDENT EVENTS
        // =====================================================

        foreach ($this->residentIds as $rid) {

            $resident =
                self::table('residents')
                    ->where('id', $rid)
                    ->first();

            if (!$resident) {
                continue;
            }

            $age =
                $this->calculateAge(
                    $resident['birthdate']
                );

            // -------------------------------------------------
            // DEATH
            // -------------------------------------------------

            $deathChance = 0;

            if ($age >= 75) {

                $deathChance = 20;

            } elseif ($age >= 70) {

                $deathChance = 15;

            } elseif ($age >= 60) {

                $deathChance = 10;

            } elseif ($age >= 50) {

                $deathChance = 5;

            } elseif ($age >= 18) {

                $deathChance = 2;

            } elseif ($age <= 1) {

                $deathChance = 5;

            } elseif ($age <= 5) {

                $deathChance = 2;

            } else {

                $deathChance = 1;
            }

            if (
                rand(1, 100) <=
                $deathChance
            ) {

                /*
                 * Death must occur after birth.
                 */
                $dateOfDeath =
                    $this->randomHistoricalDate(
                        $resident['birthdate']
                    );

                /*
                 * If the generated resident is still alive
                 * today, the historical death record is still
                 * valid because it is generated in the past.
                 */
                self::table('residents')
                    ->where('id', $rid)
                    ->update([
                        'status' => 'Deceased'
                    ]);

                $ageAtDeath =
                    $this->calculateAge(
                        $resident['birthdate'],
                        $dateOfDeath
                    );

                $manner =
                    $ageAtDeath >= 50
                    ? $this->random([
                        'Natural',
                        'Natural',
                        'Natural',
                        'Natural',
                        'Unknown'
                    ])
                    : $this->random([
                        'Natural',
                        'Accident',
                        'Accident',
                        'Unknown'
                    ]);

                $cause =
                    $ageAtDeath >= 60
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
                    : $this->random(
                        $causesOfDeath
                    );

                $deathRows[] = [

                    'resident_id' =>
                        $rid,

                    'date_of_death' =>
                        $dateOfDeath,

                    'cause_of_death' =>
                        $cause,

                    'manner_of_death' =>
                        $manner,
                ];

                // A deceased resident does not migrate.
                continue;
            }

            // -------------------------------------------------
            // MIGRATION
            // -------------------------------------------------

            $migrateChance = 0;

            if (
                $age >= 18 &&
                $age <= 30
            ) {

                $migrateChance = 12;

            } elseif (
                $age > 30 &&
                $age <= 40
            ) {

                $migrateChance = 7;

            } elseif (
                $age > 40 &&
                $age <= 55
            ) {

                $migrateChance = 4;

            } elseif ($age > 55) {

                $migrateChance = 2;
            }

            if (
                rand(1, 100) >
                $migrateChance
            ) {
                continue;
            }

            /*
             * Existing residents are more likely to move OUT.
             * IN migration is handled by creating newcomers.
             */
            $migrationType =
                rand(1, 100) <= 65
                ? 'OUT'
                : 'IN';

            // =================================================
            // MIGRATION OUT
            // =================================================

            if ($migrationType === 'OUT') {

                $migrationStart =
                    date(
                        'Y-m-d',
                        strtotime(
                            $resident['birthdate'] .
                            ' +18 years'
                        )
                    );

                $dateOfMigration =
                    $this->randomHistoricalDate(
                        $migrationStart
                    );

                self::table('residents')
                    ->where('id', $rid)
                    ->update([
                        'status' => 'Transferred'
                    ]);

                $migrationRows[] = [

                    'resident_id' =>
                        $rid,

                    'migration_type' =>
                        'OUT',

                    'date_of_migration' =>
                        $dateOfMigration,

                    'origin' =>
                        'Barangay (Local)',

                    'destination' =>
                        $this->random(
                            $destinations
                        ),
                ];

                // =================================================
                // MIGRATION IN
                // =================================================

            } else {

                $sex =
                    rand(0, 1)
                    ? 'Male'
                    : 'Female';

                $ageNew =
                    rand(18, 55);

                [$firstName, $middleName] =
                    $this->generateName($sex);

                $birthYear =
                    (int) date('Y') - $ageNew;

                $birthdate = date(
                    'Y-m-d',
                    strtotime(
                        $birthYear .
                        '-' .
                        rand(1, 12) .
                        '-' .
                        rand(1, 28)
                    )
                );

                $minimumMigrationDate =
                    date(
                        'Y-m-d',
                        strtotime(
                            $birthdate .
                            ' +18 years'
                        )
                    );

                $migrationDate =
                    $this->randomHistoricalDate(
                        $minimumMigrationDate
                    );

                $resident = [

                    'household_id' =>
                        $this->random(
                            $this->householdIds
                        ),

                    'first_name' =>
                        $firstName,

                    'middle_name' =>
                        rand(0, 1)
                        ? $middleName
                        : null,

                    'last_name' =>
                        $this->randomLastName(),

                    'sex' =>
                        $sex,

                    'birthdate' =>
                        $birthdate,

                    'civil_status' =>
                        $this->random([
                            'Single',
                            'Married',
                            'Separated',
                            'Widowed'
                        ]),

                    'relationship' =>
                        'Relative',

                    'status' =>
                        'Active',
                ];

                self::table('residents')
                    ->insert($resident);

                /*
                 * Get the actual database ID.
                 *
                 * This is safer than assuming:
                 * count($this->residentIds) + 1
                 */
                $newResident =
                    self::table('residents')
                        ->orderBy(
                            'id',
                            'DESC'
                        )
                        ->first();

                if ($newResident) {

                    $newResidentId =
                        $newResident['id'];

                    $this->residentIds[] =
                        $newResidentId;

                    $migrationRows[] = [

                        'resident_id' =>
                            $newResidentId,

                        'migration_type' =>
                            'IN',

                        'date_of_migration' =>
                            $migrationDate,

                        'origin' =>
                            $this->random(
                                $origins
                            ),

                        'destination' =>
                            'Barangay (Local)',
                    ];
                }
            }
        }

        // =====================================================
        // ADDITIONAL MIGRATION-IN RESIDENTS
        // =====================================================

        $migrationInCount = rand(

            max(
                10,
                intval(
                    $this->householdCount * 0.05
                )
            ),

            max(
                20,
                intval(
                    $this->householdCount * 0.12
                )
            )
        );

        for (
            $i = 0;
            $i < $migrationInCount;
            $i++
        ) {

            $householdId =
                $this->random(
                    $this->householdIds
                );

            $sex =
                rand(0, 1)
                ? 'Male'
                : 'Female';

            $age =
                rand(18, 55);

            [$firstName, $middleName] =
                $this->generateName($sex);

            $birthYear =
                (int) date('Y') - $age;

            $birthdate = date(
                'Y-m-d',
                strtotime(
                    $birthYear .
                    '-' .
                    rand(1, 12) .
                    '-' .
                    rand(1, 28)
                )
            );

            $minimumMigrationDate =
                date(
                    'Y-m-d',
                    strtotime(
                        $birthdate .
                        ' +18 years'
                    )
                );

            $migrationDate =
                $this->randomHistoricalDate(
                    $minimumMigrationDate
                );

            $resident = [

                'household_id' =>
                    $householdId,

                'first_name' =>
                    $firstName,

                'middle_name' =>
                    rand(0, 1)
                    ? $middleName
                    : null,

                'last_name' =>
                    $this->randomLastName(),

                'sex' =>
                    $sex,

                'birthdate' =>
                    $birthdate,

                'civil_status' =>
                    $this->random([
                        'Single',
                        'Married',
                        'Separated',
                        'Widowed'
                    ]),

                'relationship' =>
                    'Relative',

                'status' =>
                    'Active',
            ];

            self::table('residents')
                ->insert($resident);

            $newResident =
                self::table('residents')
                    ->orderBy(
                        'id',
                        'DESC'
                    )
                    ->first();

            if (!$newResident) {
                continue;
            }

            $residentId =
                $newResident['id'];

            $this->residentIds[] =
                $residentId;

            $migrationRows[] = [

                'resident_id' =>
                    $residentId,

                'migration_type' =>
                    'IN',

                'date_of_migration' =>
                    $migrationDate,

                'origin' =>
                    $this->random(
                        $origins
                    ),

                'destination' =>
                    'Barangay (Local)',
            ];
        }

        // =====================================================
        // INSERT DEMOGRAPHIC EVENTS
        // =====================================================

        $this->batchInsert(
            'death_records',
            $deathRows
        );

        $this->batchInsert(
            'migration_records',
            $migrationRows
        );
    }

    // =========================================================
    // BIRTH RECORDS
    // =========================================================

    private function seedBirthRecords(): void
    {
        $rows = [];

        $mothers =
            self::table('residents')
                ->where('sex', 'Female')
                ->get();

        foreach ($mothers as $mother) {

            $motherAge =
                $this->calculateAge(
                    $mother['birthdate']
                );

            if (
                $motherAge < 18 ||
                $motherAge > 45
            ) {
                continue;
            }

            if (rand(1, 100) > 45) {
                continue;
            }

            $childCount =
                $this->weighted([
                    [
                        'count' => 1,
                        'weight' => 35
                    ],
                    [
                        'count' => 2,
                        'weight' => 30
                    ],
                    [
                        'count' => 3,
                        'weight' => 18
                    ],
                    [
                        'count' => 4,
                        'weight' => 10
                    ],
                    [
                        'count' => 5,
                        'weight' => 5
                    ],
                    [
                        'count' => 6,
                        'weight' => 2
                    ],
                ])['count'];

            $children =
                self::table('residents')
                    ->where(
                        'household_id',
                        $mother['household_id']
                    )
                    ->where(
                        'relationship',
                        'Child'
                    )
                    ->get();

            if (empty($children)) {
                continue;
            }

            shuffle($children);

            $used = 0;

            foreach ($children as $child) {

                if ($used >= $childCount) {
                    break;
                }

                $childAge =
                    $this->calculateAge(
                        $child['birthdate']
                    );

                if (
                    ($motherAge - $childAge) < 15
                ) {
                    continue;
                }

                $rows[] = [

                    'child_resident_id' =>
                        $child['id'],

                    'mother_resident_id' =>
                        $mother['id'],

                    'date_of_birth' =>
                        $child['birthdate'],

                    'sex' =>
                        $child['sex'],
                ];

                $used++;
            }
        }

        $this->batchInsert(
            'birth_records',
            $rows
        );
    }

    // =========================================================
    // SOCIO-ECONOMIC
    // =========================================================

    private function seedSocioEconomic(): void
    {
        $rows = [];

        foreach ($this->residentIds as $id) {

            $resident =
                self::table('residents')
                    ->where('id', $id)
                    ->first();

            if (!$resident) {
                continue;
            }

            $age =
                $this->calculateAge(
                    $resident['birthdate']
                );

            $profile =
                $this->generateEconomicProfile(
                    $resident['sex'],
                    $age
                );

            $rows[] = [

                'resident_id' =>
                    $id,

                'occupation' =>
                    $profile['occupation'],

                'employment_status' =>
                    $profile['employment_status'],

                'monthly_income' =>
                    $profile['monthly_income'],

                'education_level' =>
                    $profile['education_level'],

                'is_literate' =>
                    $this->generateLiteracy(
                        $profile['education_level']
                    ),
            ];
        }

        $this->batchInsert(
            'socio_economic_profiles',
            $rows
        );
    }

    private function generateEconomicProfile(
        string $sex,
        int $age
    ): array {

        if ($age < 18) {

            return [

                'occupation' =>
                    'Student',

                'employment_status' =>
                    'Student',

                'monthly_income' =>
                    0,

                'education_level' =>
                    $age < 12
                    ? 'Elementary'
                    : $this->random([
                        'Elementary',
                        'High School'
                    ]),
            ];
        }

        if (
            $age >= 60 &&
            rand(1, 100) <= 70
        ) {

            return [

                'occupation' =>
                    'Retired',

                'employment_status' =>
                    'Retired',

                'monthly_income' =>
                    rand(2000, 15000),

                'education_level' =>
                    $this->random([
                        'Elementary',
                        'High School',
                        'College'
                    ]),
            ];
        }

        $shared = [

            [
                'occupation' =>
                    'Vendor',

                'employment_status' =>
                    'Self-Employed',

                'education' =>
                    [
                        'Elementary',
                        'High School'
                    ],

                'income' =>
                    [3000, 15000],

                'weight' =>
                    12
            ],

            [
                'occupation' =>
                    'Office Clerk',

                'employment_status' =>
                    'Employed',

                'education' =>
                    [
                        'Senior High',
                        'College'
                    ],

                'income' =>
                    [15000, 30000],

                'weight' =>
                    10
            ],

            [
                'occupation' =>
                    'Teacher',

                'employment_status' =>
                    'Employed',

                'education' =>
                    ['College'],

                'income' =>
                    [25000, 50000],

                'weight' =>
                    8
            ],

            [
                'occupation' =>
                    'Factory Worker',

                'employment_status' =>
                    'Employed',

                'education' =>
                    ['High School'],

                'income' =>
                    [12000, 22000],

                'weight' =>
                    8
            ],

            [
                'occupation' =>
                    'Unemployed',

                'employment_status' =>
                    'Unemployed',

                'education' =>
                    ['Out of School Youth'],

                'income' =>
                    [0, 0],

                'weight' =>
                    10
            ],
        ];

        $extra =
            $sex === 'Male'
            ? [

                [
                    'occupation' =>
                        'Laborer',

                    'employment_status' =>
                        'Employed',

                    'education' =>
                        ['Elementary'],

                    'income' =>
                        [8000, 16000],

                    'weight' =>
                        10
                ],

                [
                    'occupation' =>
                        'Driver',

                    'employment_status' =>
                        'Self-Employed',

                    'education' =>
                        ['Elementary'],

                    'income' =>
                        [6000, 18000],

                    'weight' =>
                        8
                ],

            ]
            : [

                [
                    'occupation' =>
                        'Nurse',

                    'employment_status' =>
                        'Employed',

                    'education' =>
                        ['College'],

                    'income' =>
                        [30000, 60000],

                    'weight' =>
                        8
                ],

                [
                    'occupation' =>
                        'Home-based Worker',

                    'employment_status' =>
                        'Self-Employed',

                    'education' =>
                        ['Elementary'],

                    'income' =>
                        [3000, 12000],

                    'weight' =>
                        8
                ],
            ];

        $p =
            $this->weighted(
                array_merge(
                    $shared,
                    $extra
                )
            );

        return [

            'occupation' =>
                $p['occupation'],

            'employment_status' =>
                $p['employment_status'],

            'monthly_income' =>
                rand(
                    $p['income'][0],
                    $p['income'][1]
                ),

            'education_level' =>
                $this->random(
                    $p['education']
                ),
        ];
    }

    // =========================================================
    // HEALTH
    // =========================================================

    private function seedHealth(): void
    {
        $rows = [];

        foreach ($this->residentIds as $id) {

            $resident =
                self::table('residents')
                    ->where('id', $id)
                    ->first();

            if (!$resident) {
                continue;
            }

            $age =
                $this->calculateAge(
                    $resident['birthdate']
                );

            $hasChronicIllness =
                $age >= 18 &&
                rand(1, 100) <= 15;

            $chronicDetails =
                $hasChronicIllness
                ? $this->random([
                    'Hypertension',
                    'Diabetes',
                    'Asthma',
                    'Arthritis',
                    'Heart Disease',
                    'Chronic Kidney Disease',
                ])
                : null;

            $rows[] = [

                'resident_id' =>
                    $id,

                'is_pwd' =>
                    rand(1, 100) <= 5
                    ? 1
                    : 0,

                'is_senior' =>
                    $age >= 60
                    ? 1
                    : 0,

                'has_chronic_illness' =>
                    $hasChronicIllness
                    ? 1
                    : 0,

                'chronic_illness_details' =>
                    $chronicDetails,

                'blood_type' =>
                    $this->random([
                        'A+',
                        'A-',
                        'B+',
                        'B-',
                        'O+',
                        'O-',
                        'AB+',
                        'AB-'
                    ]),

                'vaccinated' =>
                    rand(1, 100) <= 80
                    ? 1
                    : 0,
            ];
        }

        $this->batchInsert(
            'health_records',
            $rows
        );
    }

    // =========================================================
    // PROGRAMS
    // =========================================================

    private function seedPrograms(): void
    {
        $this->batchInsert(
            'programs',
            [

                [
                    'program_name' =>
                        'Pantawid Pamilyang Pilipino Program (4Ps)',

                    'description' =>
                        'Conditional cash transfer program for low-income households provided by DSWD. Supports health, nutrition, and education of children aged 0–18 through compliance with school attendance and health check-up requirements.',
                ],

                [
                    'program_name' =>
                        'Social Pension for Indigent Senior Citizens',

                    'description' =>
                        'Monthly financial assistance provided to senior citizens aged 60 and above who are frail, sickly, or without regular income or family support, implemented under the Social Welfare and Development programs.',
                ],

                [
                    'program_name' =>
                        'Assistance to Persons with Disabilities (PWD Assistance Program)',

                    'description' =>
                        'Support program providing financial aid, medical assistance, and priority access services to registered persons with disabilities to improve mobility, livelihood, and healthcare access.',
                ],

                [
                    'program_name' =>
                        'Barangay Health and Medical Assistance Program',

                    'description' =>
                        'Local health initiative offering free basic consultations, maternal care services, immunization, and financial assistance for hospital referrals and emergency medical cases.',
                ],

                [
                    'program_name' =>
                        'Educational Assistance and Scholarship Program',

                    'description' =>
                        'Financial support for elementary, high school, and college students from low-income families, including tuition assistance, school supplies, and allowance subsidies based on academic performance and household income.',
                ],

                [
                    'program_name' =>
                        'Livelihood Assistance and Skills Training Program',

                    'description' =>
                        'Capability-building program providing TESDA-accredited skills training, startup capital assistance, and livelihood kits for unemployed and underemployed residents to promote self-sufficiency.',
                ],

                [
                    'program_name' =>
                        'Emergency Shelter Assistance Program',

                    'description' =>
                        'Disaster-response housing support for families affected by fires, typhoons, and other emergencies, including temporary shelter aid, construction materials, and relocation assistance.',
                ],

                [
                    'program_name' =>
                        'Solo Parent Welfare Assistance Program',

                    'description' =>
                        'Support program for registered solo parents providing monthly financial aid, counseling services, and priority access to livelihood and educational assistance programs.',
                ],

                [
                    'program_name' =>
                        'Walang Gutom Program',

                    'description' =>
                        'A local government initiative aimed at addressing hunger and food insecurity by providing free meals, food packs, and nutritional support to indigent families and individuals in the community.',
                ],
            ]
        );

        $this->programIds =
            range(1, 9);
    }

    // =========================================================
    // PROGRAM BENEFICIARIES
    // =========================================================

    private function seedBeneficiariesSmart(): void
    {
        $rows = [];

        foreach (
            $this->householdMembers
            as $householdId => $members
        ) {

            $householdIncome = 0;

            $hasChild = false;

            foreach ($members as $rid) {

                $profile =
                    self::table(
                        'socio_economic_profiles'
                    )
                        ->where(
                            'resident_id',
                            $rid
                        )
                        ->first();

                $householdIncome +=
                    $profile['monthly_income'] ?? 0;

                $resident =
                    self::table('residents')
                        ->where('id', $rid)
                        ->first();

                if (
                    $resident &&
                    $this->calculateAge(
                        $resident['birthdate']
                    ) < 18
                ) {

                    $hasChild = true;
                }
            }

            $isLowIncome =
                $householdIncome < 20000;

            foreach ($members as $rid) {

                $resident =
                    self::table('residents')
                        ->where('id', $rid)
                        ->first();

                if (!$resident) {
                    continue;
                }

                if (
                    in_array(
                        $resident['status'],
                        [
                            'Deceased',
                            'Transferred'
                        ]
                    )
                ) {
                    continue;
                }

                $age =
                    $this->calculateAge(
                        $resident['birthdate']
                    );

                $health =
                    self::table('health_records')
                        ->where(
                            'resident_id',
                            $rid
                        )
                        ->first();

                // 4Ps
                if (
                    $isLowIncome &&
                    $hasChild
                ) {

                    $rows[] =
                        $this->beneficiaryRow(
                            $rid,
                            1
                        );
                }

                // Senior Pension
                if ($age >= 60) {

                    $rows[] =
                        $this->beneficiaryRow(
                            $rid,
                            2
                        );
                }

                // PWD
                if (
                    !empty(
                    $health['is_pwd']
                )
                ) {

                    $rows[] =
                        $this->beneficiaryRow(
                            $rid,
                            3
                        );
                }

                // Scholarship
                if (
                    $age >= 6 &&
                    $age <= 24 &&
                    $isLowIncome
                ) {

                    $rows[] =
                        $this->beneficiaryRow(
                            $rid,
                            5
                        );
                }

                // Livelihood
                if (
                    $age >= 18 &&
                    $age <= 59 &&
                    $isLowIncome &&
                    rand(1, 100) <= 60
                ) {

                    $rows[] =
                        $this->beneficiaryRow(
                            $rid,
                            6
                        );
                }

                // Health
                if (
                    rand(1, 100) <= 80
                ) {

                    $rows[] =
                        $this->beneficiaryRow(
                            $rid,
                            4
                        );
                }
            }
        }

        $this->batchInsert(
            'program_beneficiaries',
            $rows
        );
    }

    // =========================================================
    // BENEFICIARY ROW
    // =========================================================

    private function beneficiaryRow(
        $rid,
        $pid
    ): array {

        $resident =
            self::table('residents')
                ->where('id', $rid)
                ->first();

        $minimumDate =
            $resident['birthdate'];

        if ($pid === 2) {

            $minimumDate =
                date(
                    'Y-m-d',
                    strtotime(
                        $resident['birthdate'] .
                        ' +60 years'
                    )
                );

        } elseif ($pid === 5) {

            $minimumDate =
                date(
                    'Y-m-d',
                    strtotime(
                        $resident['birthdate'] .
                        ' +6 years'
                    )
                );

        } elseif ($pid === 6) {

            $minimumDate =
                date(
                    'Y-m-d',
                    strtotime(
                        $resident['birthdate'] .
                        ' +18 years'
                    )
                );
        }

        return [

            'resident_id' =>
                $rid,

            'program_id' =>
                $pid,

            'date_enrolled' =>
                $this->randomHistoricalDate(
                    $minimumDate
                ),

            'status' =>
                'Active',
        ];
    }

    // =========================================================
    // POPULATION HISTORY
    // =========================================================

    /**
     * Get population history for the requested
     * number of years.
     *
     * Example:
     *
     * getPopulationHistory(10)
     *
     * Current year 2026 produces:
     *
     * 2016
     * 2017
     * ...
     * 2025
     * 2026
     */
    public function getPopulationHistory(
        int $years = 10
    ): array {

        $years = max(
            1,
            $years
        );

        $currentYear =
            (int) date('Y');

        $startYear =
            $currentYear - $years;

        $history = [];

        for (
            $year = $startYear;
            $year <= $currentYear;
            $year++
        ) {

            $asOfDate =
                $year . '-12-31';

            $population =
                $this->calculatePopulationAsOfDate(
                    $asOfDate
                );

            $history[] = [

                'year' =>
                    $year,

                'population' =>
                    $population,
            ];
        }

        return $history;
    }

    // =========================================================
    // CALCULATE HISTORICAL POPULATION
    // =========================================================

    /**
     * Reconstruct population at a particular date.
     *
     * Rules:
     *
     * 1. Resident must already be born.
     * 2. If resident migrated IN, they count only
     *    after their migration date.
     * 3. If resident migrated OUT, they stop counting
     *    after their migration date.
     * 4. If resident died, they stop counting after
     *    their death date.
     */
    private function calculatePopulationAsOfDate(
        string $asOfDate
    ): int {

        $residents =
            self::table('residents')
                ->get();

        $population = 0;

        foreach ($residents as $resident) {

            // -------------------------------------------------
            // PERSON MUST HAVE BEEN BORN
            // -------------------------------------------------

            if (
                $resident['birthdate'] >
                $asOfDate
            ) {
                continue;
            }

            // -------------------------------------------------
            // MIGRATION HISTORY
            // -------------------------------------------------

            $migrations =
                self::table(
                    'migration_records'
                )
                    ->where(
                        'resident_id',
                        $resident['id']
                    )
                    ->get();

            /*
             * By default, original residents are
             * considered present.
             *
             * Residents created specifically as
             * migration-IN residents have an IN record,
             * so they will not count before that date.
             */
            $isPresent = true;

            /*
             * Sort migration events chronologically.
             */
            usort(
                $migrations,
                function ($a, $b) {
                    return strcmp(
                        $a['date_of_migration'],
                        $b['date_of_migration']
                    );
                }
            );

            foreach ($migrations as $migration) {

                if (
                    $migration['date_of_migration'] >
                    $asOfDate
                ) {
                    continue;
                }

                if (
                    $migration['migration_type'] ===
                    'IN'
                ) {

                    $isPresent = true;

                } elseif (
                    $migration['migration_type'] ===
                    'OUT'
                ) {

                    $isPresent = false;
                }
            }

            if (!$isPresent) {
                continue;
            }

            // -------------------------------------------------
            // DEATH
            // -------------------------------------------------

            $death =
                self::table('death_records')
                    ->where(
                        'resident_id',
                        $resident['id']
                    )
                    ->first();

            if (
                $death &&
                $death['date_of_death'] <=
                $asOfDate
            ) {

                continue;
            }

            $population++;
        }

        return $population;
    }

    // =========================================================
    // POPULATION HISTORY REPORT
    // =========================================================

    /**
     * Returns:
     *
     * Year
     * Population
     * Annual Change
     * Growth Rate
     */
    public function getPopulationHistoryReport(
        int $years = 10
    ): array {

        $history =
            $this->getPopulationHistory(
                $years
            );

        $report = [];

        $previousPopulation = null;

        foreach ($history as $record) {

            $population =
                $record['population'];

            $change = null;

            $growthRate = null;

            if (
                $previousPopulation !== null
            ) {

                $change =
                    $population -
                    $previousPopulation;

                if (
                    $previousPopulation > 0
                ) {

                    $growthRate = round(
                        (
                            (
                                $population -
                                $previousPopulation
                            )
                            /
                            $previousPopulation
                        ) * 100,
                        2
                    );
                }
            }

            $report[] = [

                'year' =>
                    $record['year'],

                'population' =>
                    $population,

                'change' =>
                    $change,

                'growth_rate' =>
                    $growthRate,
            ];

            $previousPopulation =
                $population;
        }

        return $report;
    }

    // =========================================================
    // GENERAL HELPERS
    // =========================================================

    private function calculateAge(
        $birthdate,
        ?string $asOfDate = null
    ): int {

        $asOfDate =
            $asOfDate ??
            date('Y-m-d');

        return (int) date_diff(
            date_create($birthdate),
            date_create($asOfDate)
        )->y;
    }

    // =========================================================
    // LITERACY
    // =========================================================

    private function generateLiteracy(
        string $education
    ): int {

        if (
            $education ===
            'Elementary'
        ) {

            return rand(1, 100) <= 80
                ? 1
                : 0;
        }

        if (
            $education === 'High School' ||
            $education === 'Senior High'
        ) {

            return rand(1, 100) <= 95
                ? 1
                : 0;
        }

        if (
            $education === 'College'
        ) {

            return 1;
        }

        if (
            $education ===
            'Out of School Youth'
        ) {

            return rand(1, 100) <= 90
                ? 1
                : 0;
        }

        return 1;
    }

    // =========================================================
    // LAST NAMES
    // =========================================================

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

        return $lastNames[
            array_rand($lastNames)
        ];
    }

    // =========================================================
    // NAMES
    // =========================================================

    private function generateName(
        string $sex
    ): array {

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

        $firstName =
            $sex === 'Male'
            ? $male[array_rand($male)]
            : $female[array_rand($female)];

        $middleName =
            $middle[array_rand($middle)];

        return [
            $firstName,
            $middleName
        ];
    }
}