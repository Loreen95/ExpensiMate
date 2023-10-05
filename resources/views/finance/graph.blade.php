@extends('layout')

@section('content')
<div class="chart-container py-12 w-9/12">
    <h2></h2>
    <canvas id="myChart" class="bg-white"></canvas>
</div>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var datasets = @json($datasets);
    // Define an array of predefined background colors
    var backgroundColors = [
    'red',   // Red
    'orange',  // Blue
    'yellow',  // Yellow
    'green', // Green
    'cyan',  // Cyan
    'blue', // Blue 
    'pink', // Pink 
    'violet', // Violet
    'purple', // Purple
    'Gold', // Gold
    'Silver', // Silver
    ];

    // Initialize an index to cycle through the colors
    var colorIndex = 0;

    // Loop through datasets and assign background colors and black borders
    datasets.forEach(function(dataset) {
    dataset.backgroundColor = backgroundColors[colorIndex];
    dataset.borderColor = 'rgba(0, 0, 0, 1)'; // Solid black border color
    colorIndex = (colorIndex + 1) % backgroundColors.length; // Cycle through colors
    });


    // Rest of your Chart.js code remains the same

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
</script>


@endsection
