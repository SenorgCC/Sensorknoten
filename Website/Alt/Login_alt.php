<?php
include("scripts/login/loginscript.php");
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../sources/bootstrap/css/bootstrap.css">
    <script src="../sources/jquery-3.1.1.min.js"></script>
</head>
<body>

<div class="container">
    <form class="form-signin" method="post" action="?login=1">
        <h2 class="form-signin-heading">Sensorüberwachung</h2>

        <label for="inputname" class="sr-only">Name</label>
        <input type="name" name="username" id="inputname" class="form-control" placeholder="Name" autofocus>

        <label for="inputPassword" class="sr-only">Passwort</label>
        <input type="password" name="passwort" id="inputPassword" class="form-control" placeholder="Password">

        <button id="submitbtn" class="btn btn-lg btn-primary btn-block" type="submit">
            Einloggen
        </button>
        <a class="btn btn-lg btn-primary btn-block" href="Register_alt.php">Registrieren</a>
    </form>

    <div id="loginerror">
        <?php
        if (isset($errorMessage)) {
            echo "<label>", $errorMessage, "</label>";
        }
        ?>
    </div>
</div>


</body>
</html>