<?php

class Meals
{
    private $database;
    private $auth;

    public function __construct($database,$auth)
    {
        if ($database instanceof Database) {
            $this->database = $database;
        } else {
            return false;
        }
        if ($auth instanceof Auth) {
            $this->auth = $auth;
        } else {
            return false;
        }
        return true;
    }

    public function get_username()
    {
        return $this->auth->get_displayname();
    }
}