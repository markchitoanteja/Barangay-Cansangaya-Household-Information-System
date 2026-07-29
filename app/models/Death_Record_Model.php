<?php

class Death_Record_Model extends Query
{
    public function MOD_GET_RESIDENTS(): array
    {
        return $this->table('residents')->orderBy('last_name', 'ASC')->get();
    }

    public function MOD_GET_DEATH_RECORDS(): array
    {
        return $this->table('death_records')
            ->select([
                'death_records.*',
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
                'death_records.resident_id',
                '=',
                'residents.id'
            )
            ->orderBy('death_records.id', 'DESC')
            ->get();
    }

    public function MOD_CHECK_IF_DEATH_RECORD_EXISTS($resident_id): bool
    {
        return $this->table('death_records')->where('resident_id', $resident_id)->exists();
    }

    public function MOD_CHECK_IF_DEATH_RECORD_EXISTS_EXCEPT_CURRENT($id, $resident_id): bool
    {
        return $this->table('death_records')->where('id', '!=', $id)->where('resident_id', $resident_id)->exists();
    }

    public function MOD_INSERT_DEATH_RECORD(array $data): string
    {
        return $this->table('death_records')->insert($data);
    }

    public function MOD_UPDATE_DEATH_RECORD($id, array $data): string
    {
        return $this->table('death_records')->where('id', $id)->update($data);
    }

    public function MOD_GET_DEATH_RECORDS_BY_MONTH(int $month): array
    {
        return $this->table('death_records')->where('MONTH(date_of_death)', $month)->where('YEAR(date_of_death)', date('Y'))->get();
    }
}
