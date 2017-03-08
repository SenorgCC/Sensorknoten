<?php
/**session_start();
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');*/
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
    <link rel="stylesheet" href="sources/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="sources/jquery-3.1.1.min.js"></script>
</head>
<body>

<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();

        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }

    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

        $statement = $pdo->prepare("INSERT INTO users (email, passwort) VALUES (:email, :passwort)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash));

        if($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="Login.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

if($showFormular) {
    ?>

    <form class="form-signin" action="?register=1" method="post">
        <h2 class="form-signin-heading">Registrierung</h2>

        <label for="username" class="sr-only">Name</label>
        <input id="username" type="name" name="username" class="form-control" placeholder="Name" autofocus>

        <label for="inputPassword" class="sr-only">Passwort</label>
        <input type="password" name="passwort" id="inputPassword" class="form-control" placeholder="Passwort">

        <label for="inputPassword2" class="sr-only">Passwort wiederholen</label>
        <input type="password" name="passwort2" id="inputPassword2" class="form-control" placeholder="Passwort wiederholen">

        <label for="registrierenbutton" class="sr-only">Registrieren</label>
        <input id="registrierenbutton" class="btn btn-lg btn-primary btn-block" type="submit" value="Registrieren">
    </form>

    <?php
} //Ende von if($showFormular)
?>

</body>
</html>