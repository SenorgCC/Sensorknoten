<?php
$sensorknoten = $_POST['sensorknoten'];
$sensorname = $_POST['sensor'];
$zeit = $_POST['zeit'];
@$mysqli = new mysqli('localhost', 'root', 'Piroot', 'Sicherheitssystem');
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
if($zeit == "Woche"){
    $query = "Select Timestamp, Messwert from Sensorknoten SK
                                inner join Sensorknoten_Messwerte as SM on (SK.KN_ID = SM.KN_ID)
                                inner join Messwerte as M on (SM.MESS_ID = M.MESS_ID)
                                inner join Sensoren as S on (M.SEN_ID = S.SEN_ID)
                           WHERE Knotennamen = '".$sensorknoten."'
                           AND Sensorname = '".$sensorname.'";";
}else{
    $query = "Select Timestamp, Messwert from Sensorknoten SK
                                inner join Sensorknoten_Messwerte as SM on (SK.KN_ID = SM.KN_ID)
                                inner join Messwerte as M on (SM.MESS_ID = M.MESS_ID)
                                inner join Sensoren as S on (M.SEN_ID = S.SEN_ID)
                            WHERE Knotennamen = '".$sensorknoten."'
                            AND Sensorname = '".$sensorname."'
                            AND DATE(Timestamp) = DATE('".$zeit."');";
}
$result = $mysqli->query($query);
$resultdata[] = array();
while ($row = $result->fetch_assoc()) {
    $tempresult = array();
    $tempresult[0] = $row['Timestamp'];
    $tempresult[1] = $row['Messwert'];
    array_push($resultdata, $tempresult);
}
echo json_encode($resultdata);
$mysqli->close();
?>
