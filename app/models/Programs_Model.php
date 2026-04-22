<?php

class Programs_Model extends Query
{
    public function MOD_GET_PROGRAMS(): array
    {
        return $this->table('programs')->orderBy('id', 'DESC')->get();
    }
}
