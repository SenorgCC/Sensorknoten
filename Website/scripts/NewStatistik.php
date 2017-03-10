<?php
$sensorknoten = $_POST['sensorknoten'];
$sensorname = $_POST['sensor'];
@$mysqli = new mysqli('localhost', 'root', 'Piroot', 'Sicherheitssystem');
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
$query = " Select * FROM(
                        SELECT Timestamp, Messwert from Sensorknoten SK
                            INNER JOIN Sensorknoten_Messwerte AS SM ON (SK.KN_ID = SM.KN_ID)
                            INNER JOIN Messwerte AS M ON (SM.MESS_ID = M.MESS_ID)
                            INNER JOIN Sensoren S ON (M.SEN_ID = M.MESS_ID)
                        WHERE Knotennamen = '$sensorknoten'
                        AND Sensorname ='$sensorname'
                       )AS Stub ORDER BY Sensorname;";
$result = $mysqli->query($query);
$resultdata[] = array();
$i = 0;
while ($row = $result->fetch_assoc()){
    $tempresult=array();
    $tempresult[0]=$row['Timestamp'];
    $tempresult[1]=$row['Messwert'];
    array_push($resultdata,$tempresult);
}

echo json_encode($resultdata);
$mysqli->close();

?>

