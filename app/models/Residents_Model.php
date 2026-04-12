<?php

class Residents_Model extends Query
{
    public function MOD_GET_RESIDENTS(): array
    {
        return $this->table('residents')->orderBy('id', 'DESC')->get();
    }
}
