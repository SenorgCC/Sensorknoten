<?php
session_start();
if(!isset($_SESSION['userid'])) {
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

echo "Hallo User: ".$userid;
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
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
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
<h2 class="sub-header"> Sensor 01 </h2>
<div class = "table-responsive">
    <table class = "table table-striped">
        <thead>
        <tr>
            <th>Temperatur</th>
            <th>Luftfeuchtigkeit</th>
            <th>Flammsensor</th>
            <th>Lichtschranke</th>
            <th>Mikrofon</th>
            <th>Lichtsensor</th>
            <th>Schocksensor</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>26 °</td>
            <td>5 %</td>
            <td>AUS</td>
            <td>AUS</td>
            <td>AUS</td>
            <td>AUS</td>
            <td>AN</td>
        </tr>
        </tbody>
    </table>
</div>
<?php
@$mysqli = new mysqli('10.35.249.48', 'k35630_test', 'test1234', 'k35630_testdata');
if ($mysqli->connect_errno) {
    echo 'Sorry, die Verbindung zu unserem superfetten endgeilen 
        Server ist hops gegangen. Wegen '.$mysqli -> connect_error;
}
$query = "SELECT KN_ID FROM Sensorknoten";
$result = $mysqli -> query ($query);
while ($row = $result->fetch_assoc()) {
    print_r("HALLO");
}
?>
</body>
</html>