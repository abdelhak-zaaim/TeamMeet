<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Infy VCards">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="">
    <title>404 Not Found | {{ getSettingData()['application_name'] }}</title>
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container con-404 vh-100 d-flex justify-content-center">
    <div class="row justify-content-md-center d-block">
        <div class="col-md-12 mt-5">
            <img src="{{ asset('front/images/404_image.svg') }}"
                 class="img-fluid img-404 mx-auto d-block">
        </div>
        <div class="col-md-12 text-center error-page-404">
            <h2>Opps! Something's missing...</h2>
            <p class="not-found-subtitle">The page you are looking for doesn't exists / isn't available / was loading
                incorrectly.</p>
            <a class="btn btn-primary back-btn mt-3" href="{{ route('frontHome') }}">Back to Previous Page</a>
        </div>
    </div>
</div>

</body>
</html>
