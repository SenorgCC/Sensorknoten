<!DOCTYPE HTML>
<html>

<head>
    <script type="text/javascript">
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Spline Area Chart"
                },
                data: [
                    {
                        type: "splineArea",
                        dataPoints: [
                            { x: new Date('2016/1/1 13:13:13'), y: 2506000 },
                            { x: new Date('2016/2/1 13:13:14'), y: 2798000 },
                            { x: new Date('2016/3/1 13:13:13'), y: 3386000 },
                            { x: new Date('2016/4/1 13:13:13'), y: 6944000 },
                            { x: new Date('2016/5/1 13:13:13'), y: 6026000 },
                            { x: new Date('2016/6/1 13:13:13'), y: 2394000 },
                            { x: new Date('2016/7/1 13:13:13'), y: 1872000 },
                            { x: new Date('2016/8/1 13:13:13'), y: 2140000 },
                            { x: new Date('2016/9/1 13:13:13'), y: 7289000 },
                            { x: new Date('2016/10/1 13:13:13'), y: 4830000 },
                            { x: new Date('2016/11/1 13:13:13'), y: 2009000 },
                            { x: new Date('2016/12/1 13:13:13'), y: 2840000 }
                        ]
                    }
                ]
            });

            chart.render();
        }
    </script>
    <script src="../../canvasjs.min.js"></script>
    <title>CanvasJS Example</title>
</head>
<body>
<div id="chartContainer" style="height: 400px; width: 100%;">
</div>
</body>
</html>