<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 10.03.2017
 * Time: 15:06
 */
@$mysqli = new mysqli('localhost', 'root', 'Piroot', 'Sicherheitssystem');
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
$query = "SELECT Knotennamen FROM Sensorknoten WHERE Webcam = '1';";
$result = $mysqli->query($query);
$resultdata[] = array();
$i = 0;
while ($row = $result->fetch_assoc()) {
    array_push($resultdata, $row['Knotennamen']);
}

echo json_encode($resultdata);
$mysqli->close();
?>