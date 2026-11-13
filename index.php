
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

$url = $_GET['url'] ?? '';

$url = trim($url, '/');


// ==========================================
// JIKA URL KOSONG
// ARAHKAN KE LOGIN
// ==========================================

if ($url === '') {

    $url = 'Login_C/index';

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
$method = 'index';
$parameter = [];

$controllerFile = '';
$controllerName = '';


// ==========================================
// MENENTUKAN ROUTING CONTROLLER
// ==========================================

// FORMAT:
// c_master/Mobil_C/index

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

    $parameter = array_slice($segment, 3);


    // MENENTUKAN FOLDER

    $folderPath = 'controller/' . $folder;

    if (!is_dir($folderPath)) {
        $folderPath = 'controller/' . ucfirst($folder);
    }

    if (!is_dir($folderPath)) {
        $folderPath = 'controller/' . strtolower($folder);
    }


    $controllerName = $controller;

    $controllerFile = $folderPath . '/' . $controllerName . '.php';

}


// ==========================================
// CONTROLLER TANPA FOLDER
// FORMAT:
// Login_C/index
// ==========================================

else {

    $controller = $segment[0] ?? '';

    $method = $segment[1] ?? 'index';

    $parameter = array_slice($segment, 2);

    $controllerName = $controller;


    // KHUSUS LOGIN

    if (strtolower($controller) === 'login_c') {

        $controllerName = 'Login_C';

    }


    // MENCARI FILE CONTROLLER

    $lokasiController = [

        'controller/' . $controllerName . '.php',

        'controller/c_master/' . $controllerName . '.php',

        'controller/C_master/' . $controllerName . '.php'

    ];


    foreach ($lokasiController as $lokasi) {

        if (file_exists($lokasi)) {

            $controllerFile = $lokasi;

            break;

        }

    }

}


// ==========================================
// MEMERIKSA FILE CONTROLLER
// ==========================================

if ($controllerFile !== '' && file_exists($controllerFile)) {

    require_once $controllerFile;


    // ======================================
    // MEMERIKSA CLASS CONTROLLER
    // ======================================

    if (!class_exists($controllerName)) {

        die("Class controller <b>$controllerName</b> tidak ditemukan.");

    }


    // ======================================
    // MEMBUAT OBJECT CONTROLLER
    // ======================================

    $objController = new $controllerName();


    // ======================================
    // MEMERIKSA METHOD
    // ======================================

    if (method_exists($objController, $method)) {

        // MENJALANKAN METHOD

        call_user_func_array(
            [$objController, $method],
            $parameter
        );

    } else {

        echo "
        <div style='
            margin:30px;
            padding:20px;
            background:#f8d7da;
            color:#721c24;
            border-radius:5px;
            font-family:Arial;
        '>

            <h3>Method Tidak Ditemukan</h3>

            Method <b>$method</b> tidak ditemukan
            di controller <b>$controllerName</b>.

        </div>";

    }

}


// ==========================================
// JIKA CONTROLLER TIDAK DITEMUKAN
// ==========================================

else {

    echo "
    <div style='
        margin:30px;
        padding:20px;
        background:#f8d7da;
        color:#721c24;
        border-radius:5px;
        font-family:Arial;
    '>

        <h3>Controller Tidak Ditemukan</h3>

        File:
        <b>" . htmlspecialchars($controllerFile) . "</b>

        <br><br>

        URL:
        <b>" . htmlspecialchars($url) . "</b>

    </div>";

}

?>
