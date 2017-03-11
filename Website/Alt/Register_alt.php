<?php
session_start();
@$mysqli = new mysqli('localhost', 'root', 'Piroot', 'Sicherheitssystem');
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen 
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
    <link rel="stylesheet" href="../sources/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../sources/jquery-3.1.1.min.js"></script>
</head>
<body>

<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

if (isset($_GET['register'])) {
    $error = false;
    $username = $_POST['username'];
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if (strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if ($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }

    if (!$error) {
        //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
        $statement = $mysqli->prepare("SELECT * FROM Login WHERE Email = ?");
        $statement->bind_param("s", $email);
        $result=$statement->execute();
        $user = $statement->fetch();
        echo "<br>";
        var_dump($result);
        var_dump($user);

        if ($user !== NULL) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
        //Überprüfe,dass der Benutzername noch nicht registriert wurde
        $statement = $mysqli->prepare("SELECT * FROM Login WHERE Benutzername = ?");
        $statement->bind_param("s", $username);
        $result = $statement->execute();
        $user = $statement->fetch();

        if ($user !== TRUE) {
            echo 'Diesr Benutzername ist bereits vergeben<br>';
            $error = true;
        }
    }

    //Keine Fehler, wir können den Nutzer registrieren
    if (!$error) {
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

        $statement = $mysqli->prepare("INSERT INTO Login (Benutzername, Passwort, Email) VALUES (? , ?, ? )");
        $statement->bind_param("sss", $username, $passwort_hash, $email);
        $result = $statement->execute();

        if ($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="Login_alt.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

if ($showFormular) {
    ?>

    <form class="form-signin" action="?register=1" method="post">
        <h2 class="form-signin-heading">Registrierung</h2>

        <label for="username" class="sr-only">Name</label>
        <input id="username" type="name" name="username" class="form-control" placeholder="Name" autofocus>

        <label for="email" class="sr-only">Email-Adresse</label>
        <input id="email" name="email" class="form-control" placeholder="Email-Adresse">

        <label for="inputPassword" class="sr-only">Passwort</label>
        <input type="password" name="passwort" id="inputPassword" class="form-control" placeholder="Passwort">

        <label for="inputPassword2" class="sr-only">Passwort wiederholen</label>
        <input type="password" name="passwort2" id="inputPassword2" class="form-control"
               placeholder="Passwort wiederholen">

        <label for="registrierenbutton" class="sr-only">Registrieren</label>
        <input id="registrierenbutton" class="btn btn-lg btn-primary btn-block" type="submit" value="Registrieren">
    </form>

    <?php
} //Ende von if($showFormular)
$mysqli->close();
?>

</body>
</html>