<?php

class Resident_Model extends Query
{
    public function MOD_GET_RESIDENTS(): array
    {
        return $this->table('residents')
            ->select([
                'residents.*',
                'households.household_code',
                'households.purok',
                "CONCAT(households.household_code, ' - ', households.purok) AS household_name"
            ])
            ->join('households', 'residents.household_id', '=', 'households.id')
            ->orderBy('residents.id', 'DESC')
            ->get();
    }

    public function MOD_INSERT_RESIDENT(array $data): string
    {
        return $this->table('residents')->insert($data);
    }
    
    public function MOD_UPDATE_RESIDENT(string $id, array $data): string
    {
        return $this->table('residents')->where('id', $id)->update($data);
    }
}
