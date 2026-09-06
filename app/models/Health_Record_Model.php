<?php

class Health_Record_Model extends Query
{
    public function MOD_GET_RESIDENTS(): array
    {
        return $this->table('residents')->orderBy('last_name', 'ASC')->get();
    }

    public function MOD_GET_PROGRAMS(): array
    {
        return $this->table('programs')->orderBy('program_name', 'ASC')->get();
    }

    public function MOD_GET_HEALTH_RECORDS(): array
    {
        return $this->table('health_records')
            ->select([
                'health_records.*',
                "CONCAT(
                residents.first_name,
                IF(
                    residents.middle_name IS NOT NULL
                    AND residents.middle_name != '',
                    CONCAT(' ', LEFT(residents.middle_name, 1), '.'),
                    ''
                ),
                ' ',
                residents.last_name
            ) AS resident_name"
            ])
            ->join(
                'residents',
                'health_records.resident_id',
                '=',
                'residents.id'
            )
            ->orderBy('health_records.id', 'DESC')
            ->get();
    }

    public function MOD_CHECK_IF_RESIDENT_EXISTS($resident_id): bool
    {
        return $this->table('health_records')->where('resident_id', $resident_id)->exists();
    }

    public function MOD_CHECK_IF_RESIDENT_EXISTS_EXCEPT_ID($resident_id, $id): bool
    {
        return $this->table('health_records')->where('resident_id', $resident_id)->where('id', '!=', $id)->exists();
    }

    public function MOD_INSERT_HEALTH_RECORD(array $data): string
    {
        return $this->table('health_records')->insert($data);
    }

    public function MOD_UPDATE_HEALTH_RECORD(int $id, array $data): int
    {
        return $this->table('health_records')->where('id', $id)->update($data);
    }

    public function MOD_GET_PWD(): array
    {
        return $this->table('health_records')
            ->where('is_pwd', 1)
            ->get();
    }

    public function MOD_GET_CHRONIC_ILLNESS(): array
    {
        return $this->table('health_records')
            ->where('has_chronic_illness', 1)
            ->get();
    }
}
