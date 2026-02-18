<?php

session_start();

require_once '../core/Miranda.php';

$app = new Miranda();

$router = $app->router();

// Rutas públicas
require_once '../routes/web.php';

// Rutas admin
require_once '../routes/admin.php';

$app->run();
