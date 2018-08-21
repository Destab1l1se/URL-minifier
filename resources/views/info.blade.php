<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>URL info</title>

    {{--bootstrap--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<div class="text-center pt-3">
    <h1>URL statistics</h1>
</div>
<div class="container">
    <div id="total_amount" class="alert" role="alert"></div>
    <div class="row">
        <div id="country_chart" class="col-md-6"></div>
        <div id="language_chart" class="col-md-6"></div>
    </div>
    <div class="row">
        <div id="browser_chart" class="offset-md-3 col-md-6"></div>
    </div>
</div>

{{--jquery--}}
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
{{--google charts--}}
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    var stats = null;

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({

            url: '{!! url('/info/json/') . '/' . request()->segment(count(request()->segments())) !!}',
            type: 'GET',
            success: function (data) {
                stats = data;
                drawCharts();
            },
            error: function (request, error) {
                console.log(error);
            }
        });
    });

    function drawCharts() {

        let totalAmount = $('#total_amount');
        totalAmount.html('Total amount of redirects: ' + stats.total);

        // if no data was sent
        if (+stats.total === 0) {
            totalAmount.addClass('alert-danger');
            return;
        }
        else
            totalAmount.addClass('alert-success');

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(function () {
            drawChart('Countries', 'countries', 'country', 'Country stats', 'country_chart');
            drawChart('Languages', 'languages', 'language', 'Language stats', 'language_chart');
            drawChart('Browsers', 'browsers', 'browser', 'Browser stats', 'browser_chart');
        });

        function drawChart(columnName, statName, propertyKey, title, divId) {

            // Create the data table.
            let dataTable = new google.visualization.DataTable();
            dataTable.addColumn('string', columnName);
            dataTable.addColumn('number', 'Visitors');

            let data = [];
            for (let property in stats[statName]) {
                if (stats[statName].hasOwnProperty(property)) {
                    data.push([stats[statName][property][propertyKey], +stats[statName][property]['amount']]);
                }
            }
            dataTable.addRows(data);

            let options = {
                title: title,
                titleTextStyle: {
                    fontSize: 20
                },
                height: 400
            };

            // Instantiate and draw our chart, passing in some options.
            let chart = new google.visualization.PieChart(document.getElementById(divId));
            chart.draw(dataTable, options);
        }
    }
</script>
</body>
</html>