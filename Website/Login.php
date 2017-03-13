<?php

include_once 'scripts/login/db-connect.php';
include_once 'scripts/login/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="sources/bootstrap/css/bootstrap.css">
    <script type="text/JavaScript" src="scripts/login/js/sha512.js"></script>
    <script type="text/JavaScript" src="scripts/login/js/forms.js"></script>
</head>
<body>

<div class="container">
    <form class="form-signin" action="scripts/login/process_login.php" method="post" name="login_form">
        <h2 class="form-signin-heading">Sensorüberwachung</h2>
        <br>
        <label for="inputname" class="sr-only">Name</label>
        <input type="name" name="email" id="inputname" class="form-control" placeholder="Name" autofocus>
        <br>
        <label for="inputPassword" class="sr-only">Passwort</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
        <br>
        <input type="submit" class="btn btn-lg btn-primary btn-block" value="Einloggen"
               onclick="formhash(this.form, this.form.password);"/>

        <a class="btn btn-lg btn-primary btn-block" href="Register.php">Registrieren</a>
    </form>



    <div id="loginerror">
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Der Login ist fehlgeschlagen</p>';
        }
        ?>
    </div>
</div>


</body>
</html>