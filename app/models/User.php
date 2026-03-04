<?php

require_once 'app/core/Query.php';

class User
{
    public function MOD_GET_USER_BY_USERNAME($username): ?array
    {
        $data = Query::table('users')->where('username', '=', $username)->first();

        return $data;
    }
}
