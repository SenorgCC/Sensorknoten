<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="sources/bootstrap/css/bootstrap.css">
</head>
<body>

<div class="form-signin">
    <?php
        echo "<h2 class=form-signin-heading>Logout erfolgreich</h2>"
    ?>
<a class="btn btn-lg btn-primary btn-block" href="Login.php">Zurück zum Login</a>
</div>

</body>
</html>
