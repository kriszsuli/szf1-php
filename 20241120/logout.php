<?php
session_start();
session_unset();
session_destroy();
setcookie('username', '', -1, '/');

echo "Kijelentkezés...";

header("Location: login.php");
exit();
?>