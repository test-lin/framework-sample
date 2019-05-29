<?php

namespace App\Controller;

class Login extends Base
{
    public function index()
    {
        $username = $this->get('username');
        $password = $this->get('password');
    }

    protected function getPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    protected function checkPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}