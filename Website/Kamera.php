<!--Anzeige der Webcams mit Konfigurationmöglichkeit -->
<?php
include_once 'scripts/login/db-connect.php';
include_once 'scripts/login/functions.php';
//Start der Session
sec_session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Webcam</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="sources/bootstrap/css/bootstrap.css">
    <script src="sources/jquery-3.1.1.min.js"></script>
    <script src="sources/bootstrap/js/bootstrap.js"></script>
    <script src="scripts/kamera/kamera.js"></script>
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
                    <li class="active"><a href="Kamera.php">Webcam <span class="sr-only">(current)</span></a></li>
                </ul>
                <!-- Rechte Seite der Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="Impressum.php">Impressum </a></li>
                    <li><a href="scripts/login/logout.php">Logout</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="container">
        <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#demo"
                title='Hier können Sie die Webcams aktivieren/deaktivieren'>
            <span class="glyphicon glyphicon-cog"></span>
        </button>
        <br>
        <div id="demo" class="collapse img-rounded table-bordered" style="background-color:#f9f2f4">
            <div class="btn-group btn-group-justified" role="group" aria-label="..." style="margin: 5px">
                <div class="btn-group" role="group">
                    <p>Sensorknoten:</p>
                    <select class="form-control" id="Sensorknotenauswahl">
                        <option>Bitte Sensorknoten auswählen</option>
                    </select>
                </div>
                <div class="btn-group" role="group">
                    <p>Auswahl:</p>
                    <div class="btn-group btn-group-justified" role="group" aria-label="..." style="margin: 5px"
                         id="auswahl">
                        <div class="btn-group" role="group">
                            <label><input type="radio" name="optradio" value="1"><span
                                        class="glyphicon glyphicon-ok"></span></label>
                        </div>
                        <div class="btn-group" role="group">
                            <label><input type="radio" name="optradio" value="0"><span
                                        class="glyphicon glyphicon-remove"></span></label>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <button type="button" class="btn btn-default" id="speichernBtn" style="margin: 5px">Speichern</button>
            <br>
        </div>
    </div>
    <div class="container">
        <div class="btn-group" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <p>Sensorknoten:</p>
                <select class="form-control" id="kamera">
                    <option>Bitte Sensorknoten auswählen</option>
                </select>
            </div>
        </div>
        <br>
        <br>
        <button type="button" class="btn btn-default" id="kameraBtn">Auswahl</button>
        <br>
        <br>
        <div id="kameraanzeige" class="embed-responsive embed-responsive-16by9">
        </div>
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
