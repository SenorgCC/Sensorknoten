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
            sensorknoten: Sensorknoten,
        };
        $.post('scripts/statistik/new_statistik.php', sendedata, function (data) {
        });
    });
});
