<?php
session_start();
session_destroy();

echo "Logout erfolgreich";
echo "<a class=\"btn btn-lg btn-primary btn-block\" href=\"Login.php\">Zurück zum Login</a>"
?>