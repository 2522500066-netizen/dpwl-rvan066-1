
<?php

// ==========================================
// MEMANGGIL FILE CONFIGURATION
// ==========================================

require_once 'config/autoload.php';
require_once 'config/routes.php';
require_once 'config/config.php';
require_once 'helper/url_helper.php';
require_once 'config/session.php';


// ==========================================
// MENGAMBIL URL
// ==========================================

// Jika URL kosong, jangan otomatis masuk ke index
$url = $_GET['url'] ?? '';

$url = trim($url, '/');


// ==========================================
// CEK URL KOSONG
// ==========================================

if ($url === '') {
    echo "
        <div style='
            margin: 50px auto;
            max-width: 600px;
            padding: 25px;
            text-align: center;
            font-family: Arial;
            border: 1px solid #ddd;
            border-radius: 8px;
        '>
            <h2>Selamat Datang</h2>
            <p>Silakan pilih halaman yang ingin dibuka.</p>
        </div>
    ";
    exit;
}


// ==========================================
// MEMECAH URL MENJADI SEGMENT
// ==========================================

$segment = explode('/', $url);


// ==========================================
// INISIALISASI VARIABLE
// ==========================================

$folder = '';
$controller = '';
$method = '';
$parameter = null;

$controllerFile = '';
$controllerName = '';


// ==========================================
// CEK CONTROLLER MENGGUNAKAN FOLDER
// CONTOH: c_master/Mobil_C/index
// ==========================================

if (
    count($segment) >= 2 &&
    (
        is_dir('controller/' . $segment[0]) ||
        is_dir('controller/' . ucfirst($segment[0])) ||
        is_dir('controller/' . strtolower($segment[0]))
    )
) {

    $folder = $segment[0];

    $controller = $segment[1] ?? '';

    $method = $segment[2] ?? 'index';

    $parameter = $segment[3] ?? null;


    // MENCARI FOLDER CONTROLLER

    if (is_dir('controller/' . $folder)) {

        $folder_path = 'controller/' . $folder;

    } elseif (is_dir('controller/' . ucfirst($folder))) {

        $folder_path = 'controller/' . ucfirst($folder);

    } elseif (is_dir('controller/' . strtolower($folder))) {

        $folder_path = 'controller/' . strtolower($folder);

    } else {

        $folder_path = 'controller/' . $folder;

    }


    // MENENTUKAN FILE CONTROLLER

    $controllerName = $controller;

    $controllerFile = $folder_path . '/' . $controllerName . '.php';

}


// ==========================================
// CONTROLLER TANPA FOLDER
// CONTOH: Login_C/index
// ==========================================

else {

    $controller = $segment[0] ?? '';

    $method = $segment[1] ?? 'index';

    $parameter = $segment[2] ?? null;


    $controllerName = $controller;


    // KHUSUS LOGIN_C

    if (strtolower($controller) === 'login_c') {

        $controllerName = 'Login_C';

        $controllerFile = 'controller/Login_C.php';

    }

    // MENCARI CONTROLLER DI BEBERAPA LOKASI

    elseif (file_exists('controller/' . $controllerName . '.php')) {

        $controllerFile = 'controller/' . $controllerName . '.php';

    } elseif (file_exists('controller/C_master/' . $controllerName . '.php')) {

        $controllerFile = 'controller/C_master/' . $controllerName . '.php';

    } elseif (file_exists('controller/c_master/' . $controllerName . '.php')) {

        $controllerFile = 'controller/c_master/' . $controllerName . '.php';

    } else {

        $controllerFile = 'controller/' . $controllerName . '.php';

    }

}


// ==========================================
// MEMERIKSA FILE CONTROLLER
// ==========================================

if (file_exists($controllerFile)) {

    require_once $controllerFile;


    // ======================================
    // MEMERIKSA CLASS CONTROLLER
    // ======================================

    if (!class_exists($controllerName)) {

        die("Class controller $controllerName tidak ditemukan.");

    }


    // MEMBUAT OBJECT CONTROLLER

    $objController = new $controllerName();


    // ======================================
    // MEMERIKSA METHOD
    // ======================================

    if (method_exists($objController, $method)) {

        // JIKA ADA PARAMETER

        if ($parameter !== null) {

            $objController->$method($parameter);

        } else {

            $objController->$method();

        }

    } else {

        echo "
            <div style='
                margin: 30px;
                padding: 20px;
                background: #f8d7da;
                color: #721c24;
                border-radius: 5px;
                font-family: Arial;
            '>
                <h3>Method Tidak Ditemukan</h3>
                Method <b>$method</b> tidak ditemukan
                di controller <b>$controllerName</b>.
            </div>
        ";

    }

}


// ==========================================
// JIKA FILE CONTROLLER TIDAK DITEMUKAN
// ==========================================

else {

    echo "
        <div style='
            margin: 30px;
            padding: 20px;
            background: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            font-family: Arial;
        '>
            <h3>Controller Tidak Ditemukan</h3>
            File: <b>$controllerFile</b><br>
            URL: <b>" . htmlspecialchars($url) . "</b>
        </div>
    ";

}

?>
