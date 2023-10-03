@extends('layout')

@section('content')
<div class="chart-container py-12 w-9/12">
    <h2></h2>
    <canvas id="myChart"></canvas>
</div>
<script>
    var label = @json(trans('dashboard.finance.total'));
    var ctx = document.getElementById('myChart').getContext('2d');
    var data = @json($data);
    var euroSign = @json(trans('dashboard.finance.euro_sign'));

    var totalCombined = data.map(function (item) {
        return item.fixed + item.variable;
    });
    var totalFixed = data.map(function (item) {
        return item.fixed;
    });
    var totalVariable = data.map(function (item) {
        return item.variable;
    });

    var myChart = new Chart(ctx, {
        type: 'bar', // Choose chart type (bar)
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: @json(trans('dashboard.finance.fixed_expenses')),
                    data: totalFixed,
                    backgroundColor: 'blue', // Blue for total fixed costs
                    borderColor: 'black', // Change border color to blue
                    borderWidth: 1,
                    stack: 'expenses',
                },
                {
                    label: @json(trans('dashboard.finance.variable_expenses')),
                    data: totalVariable,
                    backgroundColor: 'red', // Red for total variable costs
                    borderColor: 'black', // Change border color to red
                    borderWidth: 1,
                    stack: 'expenses',
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stacked: true, // Enable stacking on the y-axis
                },
                x: {
                    stacked: true, // Enable stacking on the x-axis
                }
            },
            plugins: {
                legend: {
                    display: false // Hide legend
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: 'black' // Set font color of x-axis labels
                    }
                },
                y: {
                    ticks: {
                        color: 'black' // Set font color of y-axis labels
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'black' // Set legend label text color to black
                    }
                }
            }
        }
    });

</script>

@endsection
