<?php

class Socio_Economic_Model extends Query
{
    public function MOD_GET_SOCIO_ECONOMIC_PROFILES(): array
    {
        return $this->table('socio_economic_profiles')
            ->select([
                'socio_economic_profiles.*',
                'residents.first_name',
                'residents.last_name',
                'residents.id AS resident_id',
                'households.household_code',
                'households.purok',
                "CONCAT(households.household_code, ' - ', households.purok) AS household_name"
            ])
            ->join('residents', 'socio_economic_profiles.resident_id', '=', 'residents.id')
            ->join('households', 'residents.household_id', '=', 'households.id')
            ->orderBy('socio_economic_profiles.id', 'DESC')
            ->get();
    }

    public function GET_BY_RESIDENT_ID($resident_id): ?array
    {
        return $this->table('socio_economic_profiles')->where('resident_id', $resident_id)->first();
    }

    public function MOD_INSERT_SOCIO_ECONOMIC_PROFILE(array $data): string
    {
        return $this->table('socio_economic_profiles')->insert($data);
    }

    public function MOD_UPDATE_SOCIO_ECONOMIC_PROFILE(string $id, array $data): string
    {
        return $this->table('socio_economic_profiles')->where('id', $id)->update($data);
    }
}
