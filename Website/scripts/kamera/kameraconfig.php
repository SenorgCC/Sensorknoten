<?php
// Ändert den Datenbankeintrag der Webcam 1 | 0
include_once "../../scripts/login/psl-config.php";
$sensorknoten = $_POST['sensorknoten'];
$kameramodus = $_POST['mode'];
@$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
$query = "UPDATE Sensorknoten SET Webcam = '".$kameramodus."' WHERE Knotennamen = '".$sensorknoten."' ";
$result = $mysqli->query($query);
echo json_encode($result);
$mysqli->close();
?>