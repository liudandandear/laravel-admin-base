<canvas id="line" style="width: 100%;height: 600px"></canvas>
<script type="text/javascript">
    var label = @json($labels);
    var data = @json($data);
    var title = '{{$title}}';
    $(function () {
        window.chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };

        var config = {
            type: 'line',
            data: {
                labels: label,
                datasets: [{
                    label: title,
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: data,
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: title
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                        }
                    }]
                }
            }
        };
        var ctx = document.getElementById('line').getContext('2d');
        new Chart(ctx, config);
    });

    function randomScalingFactor() {
        return Math.floor(Math.random() * 100)
    }
</script>