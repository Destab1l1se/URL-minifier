<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>URL minifier</title>

    {{--bootstrap--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>URL minifier</h1>
        </div>

        <form action="{{ route('minify') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="url">Your URL</label>
                <input required type="url" class="form-control" id="url" name="url" placeholder="Enter url">
            </div>
            <div class="form-group">
                <label for="custom_url">Custom url</label>
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
                </div>
                <input type="url" class="form-control" id="custom_url" name="custom_url" value="{{ route('main') }}">
            </div>
            <div class="form-group">
                <label for="expires_at">Url expiration time (optional)</label>
                <input type="date" class="form-control" id="url" name="expires_at">
            </div>
            <button type="submit" class="btn btn-primary">Minify</button>
        </form>
    </div>
</body>
</html>
