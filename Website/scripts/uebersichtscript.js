
function start() {
    node = document.getElementById("tabelle1");
    node.parentNode.insertBefore(createTable(3, 7), node );
}

function createTable(row, col, id) {

    var myTable     = document.createElement("table");
    var mytablebody = document.createElement("tbody");

    for(var j = 0; j < row; j++) {
        mycurrent_row = document.createElement("tr");
        for(var i = 0; i < col; i++) {
            mycurrent_cell = document.createElement("td");
            currenttext = document.createTextNode("row"+j+", column"+i+", ");
            mycurrent_cell.appendChild(currenttext);
            mycurrent_row.appendChild(mycurrent_cell);
        }

        mytablebody.appendChild(mycurrent_row);
    }

    myTable.appendChild(mytablebody);
    myTable.setAttribute("ID", id);
    return myTable;
}

$(document).ready(function(){
    // Neuladen alle 1000ms -> 1s
    $("#datentabelle").load("scripts/Sensordaten.php");
    var refreshId = setInterval(function() {
        $("#datentabelle").load('scripts/Sensordaten.php')
    }, 1000);
    var daten=[];
    $.post('scripts/flammendaten.php', function(data){
        data= JSON.parse(data);
        /*$.plot($("#placeholder"), [["2016-03-07 13:23:11",2],["2016-03-07 14:23:11", 4]],{
            xaxis:{
                mode: "time",
                timeformat:"%y-%m-%d %H:%M:%S"
            }
        });*/
        for (var i=0; i<data.length; i++){
            data[i][0] = new Date(data[i][0]).getTime();
        }
        //$.plot("#placeholder",[[[new Date(data[2][0]).getTime(),2],[new Date(data[3][0]).getTime(),4],[new Date(data[4][0]).getTime(),5]]], {
        $.plot("#placeholder",[data], {
            xaxis: { mode: "time" ,
                     timeformat: "%y-%m-%d %H:%M:%S"},
                     min: (new Date("2015-03-02 00:00:00")).getTime(),
                     max: (new Date("2020-03-10 23:25:23")).getTime()
        });
    });

});