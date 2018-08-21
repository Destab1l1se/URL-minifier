<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>URL minifier</title>

    {{--bootstrap--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style>
        .jumbotron {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="text-center pt-3">
        <h1>URL minifier</h1>
    </div>

    <form action="{{ route('minify') }}" method="POST">
        <div class="form-group">
            <label for="redirects_to">Your URL</label>
            <input required type="url" class="form-control" id="redirects_to" name="redirects_to"
                   placeholder="Enter url">
        </div>
        <label for="custom-url">Custom path (optional)</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">{{ route('main').'/' }}</span>
            </div>
            <input type="text" class="form-control" id="custom-url" name="custom-url">
        </div>
        <div class="form-group">
            <label for="expires_at">Url expiration time (optional)</label>
            <input type="date" class="form-control" id="expires_at" name="expires_at">
        </div>
        <button type="submit" class="btn btn-primary" id="minify">Minify</button>
    </form>
</div>

{{--jquery--}}
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('form').submit(function (e) {

            e.preventDefault();
            $.ajax({

                url: '{{ route('minify') }}',
                type: 'POST',
                data: {
                    'redirects_to': $('#redirects_to').val(),
                    'custom-url': $('#custom-url').val(),
                    'expires_at': $('#expires_at').val()
                },
                success: function(data) {
                    showLinks(data);
                },
                error: function (request, error) {
                    console.log(error);
                }
            });
        });
    });

    function showLinks(data) {
        // deleting old ones
        $('.jumbotron').remove();

        //todo: add errors, preloader and request validation
        $('form').after(function() {
            let info =
            '<div class="jumbotron">' +
                '<span>Your url: </span>' +
                '<div class="alert alert-primary">' + data.url + '</div>' +
                '<span>Url for statistics: </span>' +
                '<div class="alert alert-success">' + data.info + '</div>' +
            '</div>';

            return info;
        });
    }
</script>
</body>
</html>
