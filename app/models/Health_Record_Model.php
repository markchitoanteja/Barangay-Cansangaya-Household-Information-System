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

    public function MOD_CHECK_IF_BENEFICIARY_EXISTS($program_id, $resident_id): bool
    {
        return $this->table('program_beneficiaries')->where('program_id', $program_id)->where('resident_id', $resident_id)->exists();
    }

    public function MOD_CHECK_IF_BENEFICIARY_EXISTS_EXCEPT_CURRENT($id, $program_id, $resident_id): bool
    {
        return $this->table('program_beneficiaries')->where('id', '!=', $id)->where('program_id', $program_id)->where('resident_id', $resident_id)->exists();
    }

    public function MOD_INSERT_PROGRAM_BENEFICIARY(array $data): string
    {
        return $this->table('program_beneficiaries')->insert($data);
    }

    public function MOD_UPDATE_BENEFICIARY(int $id, array $data): int
    {
        return $this->table('program_beneficiaries')->where('id', $id)->update($data);
    }
}
