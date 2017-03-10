<?php
@$mysqli = new mysqli('localhost', 'root', 'Piroot', 'Sicherheitssystem');
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
$query = "SELECT Timestamp, Messwert From Messwerte WHERE SEN_ID = '1'";
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
