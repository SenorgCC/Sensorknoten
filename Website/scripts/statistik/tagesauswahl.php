<?php
// Selektiert alle verfügbaren Tage
include_once "../../scripts/login/psl-config.php";
$sensorknoten = $_POST['name'];
@$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
//$query = "SELECT DATE(Timestamp) AS Datum FROM Messwerte GROUP BY DATE(Timestamp)";
$query = " Select DATE(Timestamp) AS Datum FROM(
			    SELECT Timestamp from Sensorknoten SK
				    INNER JOIN Sensorknoten_Messwerte AS SM ON (SK.KN_ID = SM.KN_ID)
				    INNER JOIN Messwerte AS M ON (SM.MESS_ID = M.MESS_ID)
				WHERE Knotennamen = '" . $sensorknoten . "'
			)AS STUB GROUP BY Datum;";
$result = $mysqli->query($query);
$resultdata[] = array();
$i = 0;
while ($row = $result->fetch_assoc()) {
    array_push($resultdata, $row['Datum']);
}

echo json_encode($resultdata);
$mysqli->close();
?>
