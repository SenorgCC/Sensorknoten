<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=php-einfach', 'root', '');

if(isset($_GET['login'])) {
    $username = $_POST['username'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['id'];
        die('Login erfolgreich. Weiter zu <a href="Uebersicht.php">internen Bereich</a>');
    } else {
        $errorMessage = "Benutzername oder Passwort war ungültig<br>";
    }

}
?>