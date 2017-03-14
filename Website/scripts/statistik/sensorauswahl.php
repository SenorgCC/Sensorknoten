<?php
// Selektiert alle verfügbaren Sensoren
$sensorknoten = $_POST['name'];
@$mysqli = new mysqli('localhost', 'root', 'Piroot', 'Sicherheitssystem');
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
$query = " Select * FROM(
			    SELECT Sensorname from Sensorknoten SK
				    INNER JOIN Sensorknoten_Messwerte AS SM ON (SK.KN_ID = SM.KN_ID)
				    INNER JOIN Messwerte AS M ON (SM.MESS_ID = M.MESS_ID)
				    INNER JOIN Sensoren S ON (M.SEN_ID = M.MESS_ID)
				WHERE Knotennamen = '" . $sensorknoten . "'
			)AS Stub ORDER BY Sensorname;";
$result = $mysqli->query($query);
$resultdata[] = array();
while ($row = $result->fetch_assoc()) {
    array_push($resultdata, $row['Sensorname']);
}
echo json_encode($resultdata);
$mysqli->close();
?>