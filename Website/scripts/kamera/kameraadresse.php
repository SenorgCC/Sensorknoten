<?php
// Selektiert die IP-Adresse der Kamera
include_once "../../scripts/login/psl-config.php";
$sensorknoten = $_POST['sensorknoten'];
@$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
$query = "SELECT IPv4_Adresse AS IP FROM Sensorknoten WHERE Knotennamen = '".$sensorknoten."';";
$result = $mysqli->query($query);
$resultdata[] = array();
while ($row = $result->fetch_assoc()) {
    array_push($resultdata, $row['IP']);
}

echo json_encode($resultdata);
$mysqli->close();
?>