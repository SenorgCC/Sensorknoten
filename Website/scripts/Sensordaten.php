<?php
@$mysqli = new mysqli('10.35.249.48', 'k35630_test', 'test1234', 'k35630_testdata');
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen 
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
$query = "SELECT Knotennamen FROM Sensorknoten";
$check= "";
$result = $mysqli->query($query);
while ($row = $result->fetch_assoc()) {
    $check = $row['Knotennamen'];
    $Temperatur = "Nicht Angeschlossen";
    $Luftfeuchtigkeit="Nicht Angeschlossen";
    $Flammsensor = "Nicht Angeschlossen";
    $Lichtschranke = "Nicht Angeschlossen";
    $Mikrofon ="Nicht Angeschlossen";
    $Lichtsensor = "Nicht Angeschlossen";
    $Schocksensor = "Nicht Angeschlossen";
    echo "<h2 class=\"sub-header\"> " . $row['Knotennamen'] . "</h2>";
    echo "<div class=\"table-responsive\">";
    echo "    <table class=\"table table-striped\">";
    echo "        <thead>";
    echo "        <tr>";
    echo "            <th>Temperatur</th>";
    echo "            <th>Luftfeuchtigkeit</th>";
    echo "            <th>Flammsensor</th>";
    echo "            <th>Lichtschranke</th>";
    echo "            <th>Mikrofon</th>";
    echo "            <th>Lichtsensor</th>";
    echo "            <th>Schocksensor</th>";
    echo "        </tr>";
    echo "        </thead>";
    echo "        <tbody>";
    echo "        <tr>";
    echo "            <td>".$Temperatur."°C</td>";
    echo "            <td>".$Luftfeuchtigkeit."%</td>";
    echo "            <td>".$Flammsensor."</td>";
    echo "            <td>".$Lichtschranke."</td>";
    echo "            <td>".$Mikrofon."</td>";
    echo "            <td>".$Lichtsensor."</td>";
    echo "            <td>".$Schocksensor."</td>";
    echo "        </tr>";
    echo "        </tbody>";
    echo "    </table>";
    echo "</div>";
}
$select = "SELECT *
FROM(
    SELECT Messwert, Timestamp, M . SEN_ID, Sensorname FROM Sensorknoten SK
        INNER JOIN Sensorknoten_Messwerte AS SM ON(SK . KN_ID = SM . KN_ID)
         INNER JOIN Messwerte AS M ON(SM . MESS_ID = M . MESS_ID)
    INNER JOIN Sensoren S ON(M . SEN_ID = S . SEN_ID) 
    WHERE Knotennamen = '$check'
    ORDER BY Timestamp desc
) AS sub
GROUP BY Sensorname
ORDER BY SEN_ID";
$result2 = $mysqli->query($select);
//print_r($result2);
while ($row2 = $result2->fetch_object()) {
    print_r($row2);
    print_r($row2->Messwert);
}
?>