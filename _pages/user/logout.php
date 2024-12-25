<?php
ob_start();
session_start();

// Zrušení session
$_SESSION = [];
session_destroy();

// Zrušení cookie pro automatické přihlášení
if (isset($_COOKIE['rememberme'])) {
    unset($_COOKIE['rememberme']);
    setcookie('rememberme', '', time() - 3600, '/'); // Nastavení cookie na vypršení v minulosti
}
session_start();
$_SESSION['toast_big'][] = ['icon' => 'success', 'title' => 'Odhlášeno', 'text' => 'Úspěšně jste se odhlásili'];

// Přesměrování na přihlašovací stránku nebo hlavní stránku
header('Location: /login'); // Změňte URL podle potřeby
exit;
?>


