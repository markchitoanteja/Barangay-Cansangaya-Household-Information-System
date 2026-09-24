<?php

class Household_Model extends Query
{
    public function MOD_GET_HOUSEHOLDS(): array
    {
        $households = $this->table('households')
            ->orderBy('id', 'DESC')
            ->get();
        $residents = $this->table('residents')
            ->get();

        $membersByHousehold = [];
        $headsByHousehold = [];
        foreach ($residents as $resident) {
            $member = [
                'first_name' => $resident['first_name'],
                'middle_name' => !empty($resident['middle_name'])
                    ? strtoupper(substr(trim($resident['middle_name']), 0, 1)) . '.'
                    : '',
                'last_name' => $resident['last_name'],
                'relationship' => $resident['relationship'],
                'sex' => $resident['sex'],
                'birthdate' => $resident['birthdate'],
                'civil_status' => $resident['civil_status'],
            ];

            $membersByHousehold[$resident['household_id']][] = $member;

            if ($resident['relationship'] === 'Head') {
                $headsByHousehold[$resident['household_id']] = $resident;
            }
        }

        foreach ($households as &$household) {
            $household['members'] = $membersByHousehold[$household['id']] ?? [];

            if (isset($headsByHousehold[$household['id']])) {
                $household = array_merge($headsByHousehold[$household['id']], $household);
            } else {
                $household['relationship'] = 'No Household Head Assigned Yet';
            }
        }
        unset($household);

        return $households;
    }

    public function MOD_GET_HOUSEHOLDS_SORT_BY_HOUSEHOLD_CODE(): array
    {
        return $this->table('households')->orderBy('household_code', 'ASC')->get();
    }

    public function MOD_GET_LAST_PUROK(string $purok): ?array
    {
        return $this->table('households')->where('purok', $purok)->orderBy('id', 'DESC')->first();
    }

    public function MOD_INSERT_HOUSEHOLD(array $data): string
    {
        return $this->table('households')->insert($data);
    }

    public function MOD_UPDATE_HOUSEHOLD(string $id, array $data): string
    {
        return $this->table('households')->where('id', $id)->update($data);
    }
}
