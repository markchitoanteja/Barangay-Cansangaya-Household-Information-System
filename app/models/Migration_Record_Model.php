<?php

class Migration_Record_Model extends Query
{
    public function MOD_GET_RESIDENTS(): array
    {
        return $this->table('residents')->orderBy('last_name', 'ASC')->get();
    }

    public function MOD_GET_MIGRATION_RECORDS(): array
    {
        return $this->table('migration_records')
            ->select([
                'migration_records.*',
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
                'migration_records.resident_id',
                '=',
                'residents.id'
            )
            ->orderBy('migration_records.id', 'DESC')
            ->get();
    }

    public function MOD_CHECK_IF_MIGRATION_RECORD_EXISTS($resident_id, $migration_type, $date_of_migration): bool
    {
        return $this->table('migration_records')->where('resident_id', $resident_id)->where('migration_type', $migration_type)->where('date_of_migration', $date_of_migration)->exists();
    }

    public function MOD_CHECK_IF_MIGRATION_RECORD_EXISTS_EXCEPT_CURRENT($id, $resident_id, $migration_type, $date_of_migration): bool
    {
        return $this->table('migration_records')->where('id', '!=', $id)->where('resident_id', $resident_id)->where('migration_type', $migration_type)->where('date_of_migration', $date_of_migration)->exists();
    }

    public function MOD_INSERT_MIGRATION_RECORD(array $data): string
    {
        return $this->table('migration_records')->insert($data);
    }
    
    public function MOD_UPDATE_MIGRATION_RECORD($id, array $data): string
    {
        return $this->table('migration_records')->where('id', $id)->update($data);
    }
}
