<?php
// Ändert den Datenbankeintrag der Webcam 1 | 0
$sensorknoten = $_POST['sensorknoten'];
$kameramodus = $_POST['mode'];
@$mysqli = new mysqli('localhost', 'root', 'Piroot', 'Sicherheitssystem');
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
$query = "UPDATE Sensorknoten SET Webcam = '".$kameramodus."' WHERE Knotennamen = '".$sensorknoten."' ";
$result = $mysqli->query($query);
echo json_encode($result);
$mysqli->close();
?>