$(document).ready(function () {
    //var daten=[];

    $.post('scripts/kamera/kamera.php', function (data) {
        data = JSON.parse(data);
        $.each(data, function (index, value) {
            if (value != 0) {
                $('#kamera').append('<option>' + value + '</option>');
            }
        });
    });

    $.post('scripts/kamera/sensorknotenauswahl.php', function (data) {
        data = JSON.parse(data);
        $.each(data, function (index, value) {
            if (value != 0) {
                $('#Sensorknotenauswahl').append('<option>' + value + '</option>');
            }
        });
    });

    $('#kameraBtn').click(function () {
        var Sensorknoten = $('#kamera option:selected').text();
        var sendedata = {
            sensorknoten: Sensorknoten
        };

        $.post('scripts/kamera/kameraadresse.php', sendedata, function (data) {
            //Der Post liefert ein Array, an dem die erste stelle null ist, in der 2. ist der echte Wert
            data = JSON.parse(data);
            var IP_Adresse = JSON.stringify(data[1]);
            alert(data);
            $('#kameraanzeige').empty();
            $('#kameraanzeige').append('<iframe src="http://192.168.178.12:8081" class="embed-responsive-item">' +
                '</iframe>'
            );
        });
    });
    $('#speichernBtn').click(function(){
        var Sensorknoten = $('#Sensorknotenauswahl option:selected').text();
        var kameramodus = $('input[name=optradio]:checked','#auswahl').val();
        var sendedata = {
            sensorknoten: Sensorknoten,
            mode: kameramodus
        };
        $.post('scripts/kamera/kameraconfig.php', sendedata, function(data){
            location.reload();
        });

    });

    //
});
