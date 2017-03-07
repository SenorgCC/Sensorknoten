<?php include("scripts/loginscript.php"); ?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="sources/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="sources/jquery-3.1.1.min.js"></script>
</head>
<body>

<div class="container">
    <form class="form-signin" method="post" action="?login=1">
        <h2 class="form-signin-heading">Sensorüberwachung</h2>
        <label class="sr-only">Name</label>
        <input type="name" name="username" id="inputname" class="form-control" placeholder="Name" autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="passwort" id="inputPassword" class="form-control" placeholder="Password">
        <button id="submitbtn" class="btn btn-lg btn-primary btn-block" type="submit">
            Einloggen
        </button>
        <button class="btn btn-lg btn-primary btn-block" formaction="Register.php">
            Registrieren
        </button>
    </form>
    <?php
    if(isset($errorMessage)) {
        echo "<label>",$errorMessage,"</label>";
    }
    ?>
</div>


</body>
</html>