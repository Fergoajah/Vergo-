<?php
// routing
$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'login.php';
        break;

    case '/views/dash_admin':
        require __DIR__ . $viewDir . 'dash_admin.php';  
        break;

    case '/views/dash_user':
        require __DIR__ . $viewDir . 'dash_user.php';
        break;

    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}

?>