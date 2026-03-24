<?php

class System_Information_Model extends Query
{
    public function MOD_GET_SYSTEM_INFORMATION(): ?array
    {
        return $this->table('system_information')->first();
    }

    public function MOD_UPDATE_SYSTEM_INFORMATION(int $id, array $data): bool
    {
        return $this->table('system_information')->where('id', $id)->update($data);
    }
}
