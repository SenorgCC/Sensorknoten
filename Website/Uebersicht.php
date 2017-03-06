<?php
//session_start();
//if(!isset($_SESSION['userid'])) {
//    die('Bitte zuerst <a href="login.php">einloggen</a>');
//}

//Abfrage der Nutzer ID vom Login
//$userid = $_SESSION['userid'];

//echo "Hallo User: ".$userid;

?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Übersicht</title>
    <link rel="stylesheet" href="sources/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/uebersicht.css">
    <script src="sources/jquery-3.1.1.min.js"></script>
    <script src="sources/bootstrap/js/bootstrap.js"></script>
    <script src="scripts/uebersichtscript.js"></script>

</head>
<body>

<!-- Beginn Navbar-->
<nav class="navbar navbar-default" id="navbar">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Sensorübersicht</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <!-- Linke Seite der Navbar -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Link</a></li>
            </ul>
            <!-- Rechte Seite der Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<!-- Ende Navbar-->
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
    echo "            <td>26 °</td>";
    echo "            <td>5 %</td>";
    echo "            <td>AUS</td>";
    echo "            <td>AUS</td>";
    echo "            <td>AUS</td>";
    echo "            <td>AUS</td>";
    echo "            <td>AN</td>";
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
    WHERE Sensorname = $check
    ORDER BY Timestamp desc
) AS sub
GROUP BY Sensorname
ORDER BY SEN_ID";
$result2 = $mysqli->query($select);
    //print_r($result2);
while ($row2 = $result2->fetch_assoc()) {
    print_r($row2);
}
?>
</body>
</html>