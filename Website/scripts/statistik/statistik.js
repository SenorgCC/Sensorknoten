$(document).ready(function(){
    //var daten=[];

    $.post('scripts/sensorknotenauswahl.php', function(data){

        data= JSON.parse(data);
        $.each(data, function(index, value){
            if(value !=0){
                $('#Sensorknotenauswahl').append('<option>'+value+'</option>');
            }
        });
    });
    $('#Sensorknotenauswahl').change(function(){
        var Sensorknoten = $('#Sensorknotenauswahl option:selected').text();
        var sendedata = {name : Sensorknoten};
        $.post('scripts/sensorauswahl.php', sendedata, function(data){
            data= JSON.parse(data);
            $.each(data, function(index, value){
                if(value !=0){
                    $('#Sensorauswahl').append('<option>'+value+'</option>');
                }
            });
        });
    });

    $('#ShowGraphBtn').click(function(){
        var Sensorknoten = $('#Sensorknotenauswahl option:selected').text();
        var Sensor = $('#Sensorauswahl option:selected').text();
        var Zeit = $('#Zeitraum option:selected').text();
        var sendedata = {sensorknoten: Sensorknoten,
                         sensor: Sensor};
        $.post('scripts/new_statistik.php', sendedata, function(data){
            data= JSON.parse(data);
            for (var i=0; i<data.length; i++){
                data[i][0] = new Date(data[i][0]).getTime();
            }
            $.plot("#placeholder",[data], {
                xaxis: { mode: "time" ,
                    timeformat: "%y-%m-%d %H:%M:%S"},
                min: (new Date("2015-03-02 00:00:00")).getTime(),
                max: (new Date("2020-03-10 23:25:23")).getTime()
            })
        });

    });

    $.post('scripts/statistik.php', function(data){
        data= JSON.parse(data);
        for (var i=0; i<data.length; i++){
            data[i][0] = new Date(data[i][0]).getTime();
        }
        $.plot("#placeholder",[data], {
            xaxis: { mode: "time" ,
                timeformat: "%y-%m-%d %H:%M:%S"},
            min: (new Date("2015-03-02 00:00:00")).getTime(),
            max: (new Date("2020-03-10 23:25:23")).getTime()
        })
    });

});
