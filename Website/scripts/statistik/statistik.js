$(document).ready(function () {
    // Zeichnet den Graphen
    function zeichneGraph(data, mode, Beschriftung) {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: Beschriftung
            },
            data: [{
                type: mode,
                dataPoints: data
            }]
        });
        chart.render();
    }
    // Erstellt den Inhalt des Dropdowns für die Sensorknotenauswahl
    $.post('scripts/statistik/sensorknotenauswahl.php', function (data) {
        data = JSON.parse(data);
        $.each(data, function (index, value) {
            if (value != 0) {
                $('#Sensorknotenauswahl').append('<option>' + value + '</option>');
            }
        });
    });
    // Erstellt den Inhalt des Dropdowns für die Sensoren in Abhängigkeit des Sensorknotens
    $('#Sensorknotenauswahl').change(function () {
        var Sensorknoten = $('#Sensorknotenauswahl option:selected').text();
        var sendedata = {name: Sensorknoten};
        $('#Sensorauswahl').empty();
        $('#Zeitraum').empty();
        $.post('scripts/statistik/sensorauswahl.php', sendedata, function (data) {
            data = JSON.parse(data);
            $.each(data, function (index, value) {
                if (value != 0) {
                    $('#Sensorauswahl').append('<option>' + value + '</option>');
                }
            });
        });
        // Erstellt den Inhalt des Dropdowns für den Zeitraum in Abhängigkeit des Sensorknotens
        $.post('scripts/statistik/tagesauswahl.php', sendedata, function (data) {
            $('#Zeitraum').append('<option>Woche</option>');
            data = JSON.parse(data);
            $.each(data, function (index, value) {
                if (value != 0) {
                    $('#Zeitraum').append('<option>' + value + '</option>');
                }
            });
        });
    });
    // Logik für die Generierung der Daten des Graphens
    $('#ShowGraphBtn').click(function () {
        var Beschriftung = "";
        var Sensorknoten = $('#Sensorknotenauswahl option:selected').text();
        var Sensor = $('#Sensorauswahl option:selected').text();
        var Zeit = $('#Zeitraum option:selected').text();
        var sendedata = {
            sensorknoten: Sensorknoten,
            sensor: Sensor,
            zeit: Zeit
        };
        var plotData=[];
        switch (Sensor) {
            case "Temperatur":
                Beschriftung = "Temperatur in [°C]";
                break;
            case "Luftfeuchtigkeit":
                Beschriftung = "Luftfeuchtigkeit in [%]";
                break;
            case "Flammsensor":
                Beschriftung = "Binäre Darstellung 1 = True und 0 = False";
                break;
            case "Lichtschranke":
                Beschriftung = "Binäre Darstellung 1 = True und 0 = False";
                break;
            case "Mikrofon":
                Beschriftung = "Binäre Darstellung 1 = True und 0 = False";
                break;
            case "Lichtsensor":
                Beschriftung = "Binäre Darstellung 1 = True und 0 = False";
                break;
            case "Schocksensor":
                Beschriftung = "Binäre Darstellung 1 = True und 0 = False";
                break;
            default:
                alert("Nicht bekannter Sensor!");
                return;
        }
        $.post('scripts/statistik/statistik.php', sendedata, function (data) {
            var mode = 0;
            data = JSON.parse(data);
            // Stichprobentest, erste Position vom Array ist bisher 0, daher muss die 2. genommen werden
            if (data[1][1] == "TRUE" || data[1][1] == "FALSE") {
                mode = "column";
            }else{
                mode = "splineArea"
            }
            for (var i = 0; i < data.length; i++) {
                data[i][0] = new Date(data[i][0]);
                if (data[i][1] == "TRUE") {
                    data[i][1] = 1;
                } else if (data[i][1] == "FALSE") {
                    data[i][1] = 0;
                }else{
                    data[i][1] = parseFloat(data[i][1]);
                }
                plotData.push({x: data[i][0], y:data[i][1]})
            }
            zeichneGraph(plotData, mode, Beschriftung);
        });
    });
});