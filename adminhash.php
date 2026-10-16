<?php
// GANTI password admin di sini
$plain_password = "suharjojaya"; 

$hash = password_hash($plain_password, PASSWORD_DEFAULT);

echo "Password asli: " . $plain_password . "<br>";
echo "HASH: <br>" . $hash;
?>
