<?php
class Controller
{
    public function __construct()
    {
        $this->session = new session();
        $this->load = new class {
            public function view($viewName, $data = [])
            {
                if (!empty($data)) extract($data);
                $base = dirname(__DIR__);
                $file = $base . '/view/' . $viewName . '.php';
                
                if (!file_exists($file)) {
                    die("VIEW GAK KETEMU. Saya cari di: $file <br> Cek apakah file mobilview.php ada di folder view/v_master/");
                }
                include $file;
            }
            public function model($modelName)
            {
                $base = dirname(__DIR__);
                require_once $base . '/model/' . $modelName . '.php';
                $modelName = basename($modelName);
                return new $modelName();
            }
            public function post($key = null)
            {
              if ($key === null) return $_POST;
              return $_POST[$key] ?? null;
            }
            public function get($key = null)
            {
              if ($key === null) return $_GET;
              return $_GET[$key] ?? null;
            }
        };
    }
}