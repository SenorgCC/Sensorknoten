<?php
echo "Hier sehen sie irgendwann ein Livebild der Kamera";
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
            <a class="navbar-brand" href="Uebersicht.php">Sensorübersicht</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <!-- Linke Seite der Navbar -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="Uebersicht.php">Übersicht</a></li>
                <li><a href="Statistikenuebersicht.php">Statistik</a></li>
                <li class="active"><a href="Kamera.php">Webcam <span class="sr-only">(current)</span></a> </li>
            </ul>
            <!-- Rechte Seite der Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="Impressum.php">Impressum </a></li>
                <li><a href="Logout.php">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>



</body>
</html>
