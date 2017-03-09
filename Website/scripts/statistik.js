$(document).ready(function(){
    //var daten=[];
    $.post('scripts/Statistik.php', function(data){
        data= JSON.parse(data);
        for (var i=0; i<data.length; i++){
            data[i][0] = new Date(data[i][0]).getTime();
        }
        $.plot("#placeholder",[data], {
            xaxis: { mode: "time" ,
                     timeformat: "%y-%m-%d %H:%M:%S"},
                     min: (new Date("2015-03-02 00:00:00")).getTime(),
                     max: (new Date("2020-03-10 23:25:23")).getTime()
        });
    });
});
