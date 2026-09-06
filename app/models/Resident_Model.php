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

    public function MOD_GET_RESIDENT_DATE_OF_BIRTH_AND_SEX(string $resident_id): array
    {
        return $this->table('residents')
            ->select(['birthdate AS date_of_birth', 'sex'])
            ->where('id', $resident_id)
            ->first() ?? ['date_of_birth' => '', 'sex' => ''];
    }

    public function MOD_GET_RESIDENTS_SORT_BY_LAST_NAME(): array
    {
        return $this->table('residents')
            ->select([
                'residents.*',
                'households.household_code',
                'households.purok',
                "CONCAT(households.household_code, ' - ', households.purok) AS household_name"
            ])
            ->join('households', 'residents.household_id', '=', 'households.id')
            ->orderBy('residents.last_name, residents.first_name', 'ASC')
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

    public function MOD_CHECK_IF_BIRTH_RECORD_EXISTS(string $id): bool
    {
        return $this->table('birth_records')->where('child_resident_id', $id)->exists();
    }

    public function MOD_UPDATE_BIRTH_RECORD_DATE_OF_BIRTH_AND_SEX(string $id, array $data): string
    {
        return $this->table('birth_records')->where('child_resident_id', $id)->update($data);
    }

    public function MOD_UPDATE_RESIDENT_STATUS(string $id, string $status): string
    {
        return $this->table('residents')->where('id', $id)->update(['status' => $status]);
    }

    public function MOD_GET_RESIDENT_BY_SEX(string $sex): array
    {
        return $this->table('residents')->where('sex', $sex)->get();
    }

    public function MOD_GET_RESIDENT_BY_STATUS(string $status): array
    {
        return $this->table('residents')->where('status', $status)->get();
    }

    public function MOD_GET_CHILDREN(): array
    {
        return $this->table('residents')
            ->raw("
            SELECT *
            FROM residents
            WHERE TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 0 AND 17
        ")
            ->get();
    }

    public function MOD_GET_WORKING_AGE(): array
    {
        return $this->table('residents')
            ->raw("
            SELECT *
            FROM residents
            WHERE TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 18 AND 64
        ")
            ->get();
    }

    public function MOD_GET_SENIORS(): array
    {
        return $this->table('residents')
            ->raw("
            SELECT *
            FROM residents
            WHERE TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) >= 65
        ")
            ->get();
    }
}
