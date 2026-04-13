<?php
setcookie('login_admin', '', time() - 3600, "/");
header("Location: login.php");
exit;
?>