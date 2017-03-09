<?php
/**session_start();
$pdo = new PDO('mysql:host=localhost;dbname=php-einfach', 'root', '');
*/

@$mysqli = new mysqli('localhost', 'root', 'Piroot', 'Sicherheitssystem');
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen 
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}


if(isset($_GET['login'])) {
    $username = $_POST['username'];
    $passwort = $_POST['passwort'];

    $statement = $mysqli->prepare("SELECT * FROM Login WHERE Benutzername = ?");
    $result = $statement->execute($username);
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['Passwort'])) {
        $_SESSION['userid'] = $user['id'];
        die('Login erfolgreich. Weiter zu <a href="../Uebersicht.php">internen Bereich</a>');
    } else {
        $errorMessage = "Benutzername oder Passwort war ungültig";
    }

}
?>