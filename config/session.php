<?php

class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set_userdata($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function userdata($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function get_userdata($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function unset_userdata($key)
    {
        unset($_SESSION[$key]);
    }

    public function sess_destroy()
    {
        session_destroy();
    }
}