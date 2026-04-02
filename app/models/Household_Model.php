<?php

class Household_Model extends Query
{
    public function MOD_GET_HOUSEHOLDS(): array
    {
        return $this->table('households')->orderBy('id', 'DESC')->get();
    }

    public function MOD_GET_LAST_PUROK(string $purok): ?array
    {
        return $this->table('households')->where('purok', $purok)->orderBy('id', 'DESC')->first();
    }

    public function MOD_INSERT_HOUSEHOLD(array $data): string
    {
        return $this->table('households')->insert($data);
    }
}
