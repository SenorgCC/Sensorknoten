$(document).ready(function () {
    //var daten=[];
    function zeichneGraph(data, mode, Beschriftung) {
        if (mode == "binär") {
            $.plot("#placeholder", [data], {
                axisLabels:{
                   show: true
                },
                yaxes:[{
                    axisLabel:Beschriftung
                    //axisLabelUseCanvas: true
                }],
                xaxis: {
                    mode: "time",
                    timeformat: "%y-%m-%d %H:%M:%S"
                },
                bars: {
                    show: true,
                    fill: true,
                    align: "center",
                    barWidth: 10000
                },
                lines: {show: false},

                min: (new Date("2015-03-02 00:00:00")).getTime(),
                max: (new Date("2020-03-10 23:25:23")).getTime()
            })
        } else {
            $.plot("#placeholder", [data], {
                axisLabels:{
                    show: true
                },
                yaxes:[{
                    axisLabel:Beschriftung
                    //axisLabelUseCanvas: true
                }],
                xaxis: {
                    mode: "time",
                    timeformat: "%y-%m-%d %H:%M:%S"
                },
                min: (new Date("2015-03-02 00:00:00")).getTime(),
                max: (new Date("2020-03-10 23:25:23")).getTime()
            })
        }
    }

    $.post('scripts/statistik/sensorknotenauswahl.php', function (data) {

        data = JSON.parse(data);
        $.each(data, function (index, value) {
            if (value != 0) {
                $('#Sensorknotenauswahl').append('<option>' + value + '</option>');
            }
        });
    });
    ///TODO: Actiontrigger anpassen
    $('#Sensorknotenauswahl').change(function () {
        var Sensorknoten = $('#Sensorknotenauswahl option:selected').text();
        var sendedata = {name: Sensorknoten};
        $('#Sensorauswahl').empty();
        $.post('scripts/statistik/sensorauswahl.php', sendedata, function (data) {
            data = JSON.parse(data);
            $.each(data, function (index, value) {
                if (value != 0) {
                    $('#Sensorauswahl').append('<option>' + value + '</option>');
                }
            });
        });
    });

    $('#ShowGraphBtn').click(function () {
        ///TODO: Messdatenselection auf Zeitraum anpassen!
        var Beschriftung="";
        var Sensorknoten = $('#Sensorknotenauswahl option:selected').text();
        var Sensor = $('#Sensorauswahl option:selected').text();
        var Zeit = $('#Zeitraum option:selected').text();
        var sendedata = {
            sensorknoten: Sensorknoten,
            sensor: Sensor
        };
        switch (Sensor){
            case "Temperatur":
                Beschriftung ="Temperatur in [°C]";
                break;
            case "Luftfeuchtigkeit":
                Beschriftung ="Luftfeuchtigkeit in [%]";
                break;
            case "Flammsensor":
                Beschriftung ="Binäre Darstellung 1 = True und 0 = False";
                break;
            case "Lichtschranke":
                Beschriftung ="Binäre Darstellung 1 = True und 0 = False";
                break;
            case "Mikrofon":
                Beschriftung ="Binäre Darstellung 1 = True und 0 = False";
                break;
            case "Lichtsensor":
                Beschriftung ="Binäre Darstellung 1 = True und 0 = False";
                break;
            case "Schocksensor":
                Beschriftung ="Binäre Darstellung 1 = True und 0 = False";
                break;
            default:
                alert("Nicht bekannter Sensor!");
                return;
        }
        alert (Beschriftung);
        $.post('scripts/statistik/new_statistik.php', sendedata, function (data) {
            ///TODO: Dictionary anschauen! Zuweisung Sensor und Beschreibung!
            var mode = 0;
            data = JSON.parse(data);
            // Stichprobentest, erste Position vom Array ist bisher 0, daher muss die 2. genommen werden
            if (data[1][1] == "TRUE" || data[1][1] == "FALSE") {
                mode = "binär";

            }
            for (var i = 0; i < data.length; i++) {
                data[i][0] = new Date(data[i][0]).getTime();
                if (data[i][1] == "TRUE") {
                    data[i][1] = 1;
                } else if (data[i][1] == "FALSE") {
                    data[i][1] = 0;
                }
            }
            zeichneGraph(data, mode, Beschriftung);

        });

    });

    // Testbeladung!
    $.post('scripts/statistik/statistik.php', function (data) {
        data = JSON.parse(data);
        for (var i = 0; i < data.length; i++) {
            data[i][0] = new Date(data[i][0]).getTime();
        }
        $.plot("#placeholder", [data], {
            xaxis: {
                mode: "time",
                timeformat: "%y-%m-%d %H:%M:%S"
            },
            min: (new Date("2015-03-02 00:00:00")).getTime(),
            max: (new Date("2020-03-10 23:25:23")).getTime()
        })
    });

});
