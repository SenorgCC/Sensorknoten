<?php
include_once 'scripts/login/db-connect.php';
include_once 'scripts/login/functions.php';

sec_session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Statistik</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="sources/bootstrap/css/bootstrap.css">
    <link href="sources/jquery-ui-1.12.1/jquery-ui.min.css" type="text/css">
    <script src="sources/jquery-3.1.1.min.js"></script>
    <script src="sources/flot/jquery.flot.js"></script>
    <script src="sources/flot/jquery.flot.time.js"></script>
    <script src="sources/flot/jquery.flot.axislabels.js"></script>
    <script src="sources/flot/jquery.flot.resize.js"></script>
    <script src="sources/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="sources/bootstrap/js/bootstrap.js"></script>
    <script src="scripts/statistik/statistik.js"></script>
    <script src="sources/canvasJS/canvasjs.min.js"></script>
    <script src="sources/canvasJS/jquery.canvasjs.min.js"></script>

</head>
<body>
<?php if (login_check($mysqli) == true) : ?>
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
            <a class="navbar-brand" href="Uebersicht.php">Sensorübersicht</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <!-- Linke Seite der Navbar -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="Uebersicht.php">Übersicht </a></li>
                <li class="active"><a href="Statistik.php">Statistik <span class="sr-only">(current)</span></a>
                </li>
                <li><a href="Kamera.php">Webcam</a></li>
            </ul>
            <!-- Rechte Seite der Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="Impressum.php">Impressum</a></li>
                <li><a href="Alt/Logout_alt.php">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<!-- Ende Navbar-->

<div class="container" >
    <div class="btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <p>Sensorknoten:</p>
            <select class="form-control" id="Sensorknotenauswahl">
                <option>Bitte Sensorknoten auswählen</option>
            </select>
        </div>
        <div class="btn-group" role="group">
            <p>Sensoren:</p>
            <select class="form-control" id="Sensorauswahl">

            </select>
        </div>
        <div class="btn-group" role="group">
            <p>Zeitraum:</p>
            <select class="form-control" id="Zeitraum">
                <!--PHP FUNKTION FÜR OPTIONEN-->
                <option>Woche</option>
            </select>
        </div>
    </div>
    <br>
    <button id="ShowGraphBtn" type="button" class="btn btn-default">Auswahl</button>
    <br>
    </br>
    <div>
        <div id='chartContainer'>
        </div>
    </div>
</div>

<?php else : ?>
    <div id="loginerror">
        <h2>Bitte loggen Sie sich zuerst ein</h2> <br>
        <a class="btn btn-lg btn-primary btn-block" href="Login.php">Zur Loginseite</a>.
    </div>
<?php endif; ?>

</body>
</html>