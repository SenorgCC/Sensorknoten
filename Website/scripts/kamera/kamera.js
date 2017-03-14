$(document).ready(function () {
    // Erstellt den Inhalt des Dropdownmenüs
    $.post('scripts/kamera/kamera.php', function (data) {
        data = JSON.parse(data);
        $.each(data, function (index, value) {
            if (value != 0) {
                $('#kamera').append('<option>' + value + '</option>');
            }
        });
    });
    // Erstellt den Inhalt des Dropdownmenüs für die Webcamkonfiguration
    $.post('scripts/kamera/sensorknotenauswahl.php', function (data) {
        data = JSON.parse(data);
        $.each(data, function (index, value) {
            if (value != 0) {
                $('#Sensorknotenauswahl').append('<option>' + value + '</option>');
            }
        });
    });
    // Baut die Verbindung zur Webcam auf
    $('#kameraBtn').click(function () {
        var Sensorknoten = $('#kamera option:selected').text();
        var sendedata = {
            sensorknoten: Sensorknoten
        };
        $.post('scripts/kamera/kameraadresse.php', sendedata, function (data) {
            //Der Post liefert ein Array, an dem die erste Stelle null ist, in der 2. ist der echte Wert
            data = JSON.parse(data);
            var IP_Adresse = data[1];
            $('#kameraanzeige').empty();
            $('#kameraanzeige').append('<iframe src="http://'+IP_Adresse+':8081" class="embed-responsive-item">' +
                '</iframe>'
            );
        });
    });
    // Speichert die eingestellte Konfiguration der Webcam
    $('#speichernBtn').click(function(){
        var Sensorknoten = $('#Sensorknotenauswahl option:selected').text();
        var kameramodus = $('input[name=optradio]:checked','#auswahl').val();
        var sendedata = {
            sensorknoten: Sensorknoten,
            mode: kameramodus
        };
        // Nach erfolgreichem Senden der Daten wird die Seite neu geladen
        $.post('scripts/kamera/kameraconfig.php', sendedata, function(data){
            location.reload();
        });
    });
});
