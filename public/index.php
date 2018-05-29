<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// link db
require '../src/config/db.php';

// routing
require '../src/routing/login.php';
require '../src/routing/cuaca.php';
require '../src/routing/iklim.php';
require '../src/routing/guru.php';
require '../src/routing/siswa.php';
require '../src/routing/tanaman.php';
require '../src/routing/kelompok.php';
require '../src/routing/kelompokGuru.php';
require '../src/routing/kelompokSiswa.php';

// entitas
require '../src/entitas/klimatologi.php';
require '../src/entitas/periode.php';
require '../src/entitas/klasifikasi.php';
require '../src/entitas/login.php';
require '../src/entitas/guru.php';
require '../src/entitas/siswa.php';
require '../src/entitas/tanaman.php';
require '../src/entitas/kelompok.php';

// Run app
$app->run();
