<?php
require("secret.php");


// Připojení k MySQL serveru
$conn = new mysqli($servername, $username, $password, $dbname);
$conn -> set_charset("utf8");
if ($conn->error) {
  die('Chyba připojení! Kontaktujte nás prosím.' . $conn->connect_error);
}
?>