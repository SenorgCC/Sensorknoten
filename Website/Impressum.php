/*
    Anzeige des Impressums mit integriertem Download der Dokumentation
*/
<?php
include_once 'scripts/login/db-connect.php';
include_once 'scripts/login/functions.php';
// Start der Session
sec_session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Impressum</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="sources/bootstrap/css/bootstrap.css">
    <script src="sources/jquery-3.1.1.min.js"></script>
    <script src="sources/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<?php
    // Überprüfung Userlogin
    if (login_check($mysqli) == true) :
?>
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
                    <li><a href="Uebersicht.php">Übersicht</a></li>
                    <li><a href="Statistik.php">Statistik</a></li>
                    <li><a href="Kamera.php">Webcam</a></li>
                </ul>
                <!-- Rechte Seite der Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="Impressum.php">Impressum <span class="sr-only">(current)</span></a></li>
                    <li><a href="scripts/login/logout.php">Logout</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="container">
        <div id="impressuminhalt">
            <img src="Bilder/dhbw-logo.png" alt="Logo DHBW" class="img-responsive" style="margin: auto"> <br>
            <p>Dieses Projekt wurde im Rahmen der Studienarbeit "Entwicklung eines Sensorknotens für IoT" an der Dualen
                Hochschule Baden-Württemberg erstellt.<br>
                Es wurden keine anderen als in der Dokumentation genannten Quellen verwendet.<br>
                Jan Mannherz, Alexander Sinicyn und Harm-Christian Schweizer</p>
        </div>
        <a id="impressuminhalt" class="btn btn-lg btn-primary btn-block" href="Dokumentation.pdf">Download der
            Dokumentation</a>
    </div>
<?php
    // Meldung bei nicht eingeloggtem User
    else :
?>
    <div id="loginerror">
        <h2>Bitte loggen Sie sich zuerst ein</h2> <br>
        <a class="btn btn-lg btn-primary btn-block" href="Login.php">Zur Loginseite</a>.
    </div>
<?php
    endif;
?>
</body>
</html>