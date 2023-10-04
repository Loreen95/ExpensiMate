@extends('layout')

@section('content')
<div class="chart-container py-12 w-9/12">
    <h2></h2>
    <canvas id="myChart" class="bg-white"></canvas>
</div>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var datasets = @json($datasets);

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: datasets,
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stacked: true,
                },
                x: {
                    stacked: true,
                }
            },
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: 'black',
                    },
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            var euroSign = '€';
                            var value = context.parsed.y || 0;
                            return label + ': ' + euroSign + ' ' + value.toFixed(2);
                        },
                    },
                },
            },
        },
    });

    // Function to generate random colors with less opacity
    function getRandomColor() {
        var alpha = 1; // Adjust the alpha channel value (0.5 for 50% opacity)
        var r = Math.floor(Math.random() * 256);
        var g = Math.floor(Math.random() * 256);
        var b = Math.floor(Math.random() * 256);
        return 'rgba(' + r + ',' + g + ',' + b + ',' + alpha + ')';
    }

    // Apply the random colors with less opacity to dataset backgrounds
    datasets.forEach(function(dataset) {
        dataset.backgroundColor = getRandomColor();
    });
</script>


@endsection
