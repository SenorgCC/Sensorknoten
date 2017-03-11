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
    $('#kameraBtn').click(function () {
        var Sensorknoten = $('#kamera option:selected').text();
        var sendedata = {
            sensorknoten: Sensorknoten
        };
        $.post('scripts/kamera/kameraadresse.php', sendedata, function (data) {
            //Der Post liefert ein Array, an dem die erste stelle null ist, in der 2. ist der echte Wert
            data = JSON.parse(data);
            var IP_Adresse = JSON.stringify(data[1]);
            alert(IP_Adresse);
            $('#kameraanzeige').empty();
            $('#kameraanzeige').append(
                '<iframe src="192.168.178.12:8081" ' +
                'width="100%" height="100%" frameborder="0" ' +
                'allowTransparency="true">' +
                '</iframe>'
            );
        });
    });
});
