<?php
// Dynamische Generierung der Sensorübersicht
include_once "../../scripts/login/psl-config.php";
@$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen 
        Server ist hops gegangen. Wegen ' . $mysqli->connect_error;
}
$query = "SELECT Knotennamen FROM Sensorknoten";
$result = $mysqli->query($query);
while ($row = $result->fetch_assoc()) {
    $Knotennamen = $row['Knotennamen'];
    // Alle Sensoren werden mit "Nicht Angeschlossen" initialsiert
    $Temperatur = "Nicht Angeschlossen";
    $Luftfeuchtigkeit = "Nicht Angeschlossen";
    $Flammsensor = "Nicht Angeschlossen";
    $Lichtsensor = "Nicht Angeschlossen";
    $Mikrofon = "Nicht Angeschlossen";
    $Lichtschranke = "Nicht Angeschlossen";
    $Schocksensor = "Nicht Angeschlossen";
    // Query liefert die aktuellsten Messwerte der Sensoren eines Sensorknotens zurück
    $query2 = "SELECT *
FROM(
    SELECT Messwert, Timestamp, M . SEN_ID, Sensorname FROM Sensorknoten SK
        INNER JOIN Sensorknoten_Messwerte AS SM ON(SK . KN_ID = SM . KN_ID)
         INNER JOIN Messwerte AS M ON(SM . MESS_ID = M . MESS_ID)
    INNER JOIN Sensoren S ON(M . SEN_ID = S . SEN_ID) 
    WHERE Knotennamen = '" . $Knotennamen . "'
    ORDER BY Timestamp desc
) AS sub
GROUP BY Sensorname
ORDER BY SEN_ID";
    $result2 = $mysqli->query($query2);
    $timestamp = array();
    // Auswertung und Zuteilung der Sensordaten
    while ($row2 = $result2->fetch_object()) {
        if ($row2->SEN_ID == '1') {
            if ($row2->Messwert !== '0') {
                $Temperatur = $row2->Messwert . "°C";
                $timestamp[1] = $row2->Timestamp;
            }
        } else if ($row2->SEN_ID == '2') {
            if ($row2->Messwert !== '0') {
                $Luftfeuchtigkeit = $row2->Messwert . "%";
                $timestamp[2] = $row2->Timestamp;
            }
        } else if ($row2->SEN_ID == '3') {
            if ($row2->Messwert !== '0') {
                $Flammsensor = $row2->Messwert;
                $timestamp[3] = $row2->Timestamp;
            }
        } else if ($row2->SEN_ID == '4') {
            $Lichtschranke = $row2->Messwert;
            $timestamp[4] = $row2->Timestamp;
        } else if ($row2->SEN_ID == '5') {
            if ($row2->Messwert !== '0') {
                $Mikrofon = $row2->Messwert;
                $timestamp[5] = $row2->Timestamp;
            }
        } else if ($row2->SEN_ID == '6') {
            if ($row2->Messwert !== '0') {
                $Lichtsensor = $row2->Messwert;
                $timestamp[6] = $row2->Timestamp;
            }
        } else if ($row2->SEN_ID == '7') {
            $Schocksensor = $row2->Messwert;
            $timestamp[7] = $row2->Timestamp;
        }
    }
    // Dynamisches erstellen der HTML-Tabelle
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
    echo "            <td><span data-toggle=\"tooltip\" data-placement=\"auto bottom\" title='$timestamp[1]'>" . $Temperatur . "</span></td>";
    echo "            <td><span data-toggle=\"tooltip\" data-placement=\"auto bottom\" title='$timestamp[2]'>" . $Luftfeuchtigkeit . "</span></td>";
    echo "            <td><span data-toggle=\"tooltip\" data-placement=\"auto bottom\" title='$timestamp[3]'>" . $Flammsensor . "</span></td>";
    echo "            <td><span data-toggle=\"tooltip\" data-placement=\"auto bottom\" title='$timestamp[4]'>" . $Lichtschranke . "</span></td>";
    echo "            <td><span data-toggle=\"tooltip\" data-placement=\"auto bottom\" title='$timestamp[5]'>" . $Mikrofon . "</span></td>";
    echo "            <td><span data-toggle=\"tooltip\" data-placement=\"auto bottom\" title='$timestamp[6]'>" . $Lichtsensor . "</span></td>";
    echo "            <td><span data-toggle=\"tooltip\" data-placement=\"auto bottom\" title='$timestamp[7]'>" . $Schocksensor . "</span></td>";
    echo "        </tr>";
    echo "        </tbody>";
    echo "    </table>";
    echo "</div>";
    echo "<p>Livekamera: <a href='../Kamera.php' target=\"_blank\"><span class =\"glyphicon glyphicon-facetime-video\"</span></a></p>";
    echo "<p>Statistiken: <a href='../Statistik.php' target=\"_blank\" ><span class =\"glyphicon glyphicon-stats\"</span></a></p>";
}
$mysqli->close();
?>