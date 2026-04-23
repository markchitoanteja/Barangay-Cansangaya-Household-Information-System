<?php

class Program_Model extends Query
{
    public function MOD_GET_PROGRAMS(): array
    {
        return $this->table('programs')->orderBy('id', 'DESC')->get();
    }

    public function MOD_INSERT_PROGRAM(array $data): string
    {
        return $this->table('programs')->insert($data);
    }
    
    public function MOD_UPDATE_PROGRAM(int $id, array $data): int
    {
        return $this->table('programs')->where('id', $id)->update($data);
    }
}
