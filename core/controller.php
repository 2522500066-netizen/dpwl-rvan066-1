<?php

class Controller
{
    public $session;
    public $load;

    public function __construct()
    {
        if (class_exists('Session')) {
            $this->session = new Session();
        }

        $this->load = new class {
            public function view($viewName, $data = [])
            {
                if (!empty($data)) {
                    extract($data);
                }

                $base = dirname(__DIR__);
                $file = $base . '/view/' . $viewName . '.php';

                if (!file_exists($file)) {
                    die("VIEW GAK KETEMU. Saya cari di: $file");
                }

                include $file;
            }

            public function model($modelName)
            {
                $base = dirname(__DIR__);
                $file = $base . '/model/' . $modelName . '.php';

                if (!file_exists($file)) {
                    die("MODEL GAK KETEMU. Saya cari di: $file");
                }

                require_once $file;
                $className = basename($modelName);
                return new $className();
            }

            public function post($key = null)
            {
                if ($key === null) {
                    return $_POST;
                }
                return $_POST[$key] ?? null;
            }

            public function get($key = null)
            {
                if ($key === null) {
                    return $_GET;
                }
                return $_GET[$key] ?? null;
            }
        };
    }
}