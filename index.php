<?php
ob_start();
session_start();



$s = rtrim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/\\');
$s = str_replace('/index.php/', '/', $s); // nahrazení /index.php/ za /


$lom = explode('/', $s);
switch ($s) {
  case '':
  case '/home':
    require('./_pages/homepage.php');
    break;
  case '/login':
    require('./_pages/user/login.php');
    break;
  case '/logout':
    require('./_pages/user/logout.php');
    break;

  default:
    $chyba_404 = 'obecne';
    require('./_stranky/404.php');
    break;
}
