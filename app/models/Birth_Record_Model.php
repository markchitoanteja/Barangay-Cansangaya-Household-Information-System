<?php

class Birth_Record_Model extends Query
{
    public function MOD_GET_RESIDENTS(): array
    {
        return $this->table('residents')->orderBy('last_name', 'ASC')->get();
    }

    public function MOD_GET_BIRTH_RECORDS(): array
    {
        return $this->table('birth_records')
            ->select([
                'birth_records.*',

                // Child name
                "CONCAT(
                child.first_name,
                IF(
                    child.middle_name IS NOT NULL
                    AND child.middle_name != '',
                    CONCAT(' ', LEFT(child.middle_name, 1), '.'),
                    ''
                ),
                ' ',
                child.last_name
            ) AS child_name",

                // Mother name
                "CONCAT(
                mother.first_name,
                IF(
                    mother.middle_name IS NOT NULL
                    AND mother.middle_name != '',
                    CONCAT(' ', LEFT(mother.middle_name, 1), '.'),
                    ''
                ),
                ' ',
                mother.last_name
            ) AS mother_name"
            ])

            // Join for the child
            ->join(
                'residents AS child',
                'birth_records.child_resident_id',
                '=',
                'child.id'
            )

            // Join for the mother
            ->join(
                'residents AS mother',
                'birth_records.mother_resident_id',
                '=',
                'mother.id'
            )

            ->orderBy('birth_records.id', 'DESC')
            ->get();
    }

    public function MOD_CHECK_IF_CHILD_EXISTS($child_resident_id): bool
    {
        return $this->table('birth_records')->where('child_resident_id', $child_resident_id)->exists();
    }

    public function MOD_CHECK_IF_CHILD_EXISTS_EXCEPT_ID($child_resident_id, $id): bool
    {
        return $this->table('birth_records')->where('child_resident_id', $child_resident_id)->where('id', '!=', $id)->exists();
    }

    public function MOD_INSERT_BIRTH_RECORD(array $data): string
    {
        return $this->table('birth_records')->insert($data);
    }

    public function MOD_UPDATE_BIRTH_RECORD(int $id, array $data): int
    {
        return $this->table('birth_records')->where('id', $id)->update($data);
    }

    public function MOD_GET_BIRTH_RECORDS_BY_MONTH(int $month): array
    {
        return $this->table('birth_records')->where('MONTH(date_of_birth)', $month)->where('YEAR(date_of_birth)', date('Y'))->get();
    }
}
