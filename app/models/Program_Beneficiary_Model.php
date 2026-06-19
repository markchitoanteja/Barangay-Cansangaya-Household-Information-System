<?php

class Program_Beneficiary_Model extends Query
{
    public function MOD_GET_RESIDENTS(): array
    {
        return $this->table('residents')->orderBy('last_name', 'ASC')->get();
    }

    public function MOD_GET_BENEFICIARIES(): array
    {
        return $this->table('program_beneficiaries')
            ->select([
                'program_beneficiaries.*',
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
            ) AS beneficiary_name",
                'programs.program_name'
            ])
            ->join(
                'residents',
                'program_beneficiaries.resident_id',
                '=',
                'residents.id'
            )
            ->join(
                'programs',
                'program_beneficiaries.program_id',
                '=',
                'programs.id'
            )
            ->orderBy('program_beneficiaries.id', 'DESC')
            ->get();
    }

    public function MOD_INSERT_BENEFICIARY(array $data): string
    {
        return $this->table('program_beneficiaries')->insert($data);
    }

    public function MOD_UPDATE_BENEFICIARY(int $id, array $data): int
    {
        return $this->table('program_beneficiaries')->where('id', $id)->update($data);
    }
}
