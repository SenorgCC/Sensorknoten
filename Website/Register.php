<?php

include_once 'scripts/login/register_inc.php';
include_once 'scripts/login/functions.php';

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
    <script type="text/JavaScript" src="scripts/login/js/sha512.js"></script>
    <script type="text/JavaScript" src="scripts/login/js/forms.js"></script>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="sources/bootstrap/css/bootstrap.css">
</head>
<body>

<?php
if (!empty($error_msg)) {
    echo $error_msg;
}
?>



<form class="form-signin" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="registration_form">
    <h2 class="form-signin-heading">Registrierung</h2>

    <div id="passwortanforderungen">
        <ul>
            <li>Benutzernamen dürfen nur Ziffern, Groß- und Kleinbuchstaben und Unterstriche enthalten.</li>
            <li>E-Mail-Adressen müssen ein gültiges Format haben.</li>
            <li>Passwörter müssen mindest sechs Zeichen lang sein.</li>
            <li>Passwörter müssen enthalten
                <ul>
                    <li>mindestens einen Großbuchstaben (A..Z)</li>
                    <li>mindestens einen Kleinbuchstaben (a..z)</li>
                    <li>mindestens eine Ziffer (0..9)</li>
                </ul>
            </li>
            <li>Das Passwort und die Bestätigung müssen exakt übereinstimmen.</li>
        </ul>
    </div>

    <label for="username" class="sr-only">Name</label>
    <input id="username" type="name" name="username" class="form-control" placeholder="Name" autofocus>

    <label for="email" class="sr-only">Email-Adresse</label>
    <input id="email" name="email" class="form-control" placeholder="Email-Adresse">

    <label for="inputPassword" class="sr-only">Passwort</label>
    <input type="password" name="password" id="Password" class="form-control" placeholder="Passwort">

    <label for="inputPassword2" class="sr-only">Passwort wiederholen</label>
    <input type="password" name="confirmpwd" id="confirmpwd" class="form-control" placeholder="Passwort wiederholen">

    <label for="registrierenbutton" class="sr-only">Registrieren</label>
    <input id="registrierenbutton" class="btn btn-lg btn-primary btn-block" type="button" value="Registrieren"
           onclick="return regformhash(this.form, this.form.username, this.form.email, this.form.password, this.form.confirmpwd);">
</form>


</body>
</html>