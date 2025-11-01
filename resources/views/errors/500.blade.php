<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 | {{ config('app.name') }}</title>
    @include('backend.layouts.include.style')

</head>

<body>
    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-12 d-flex justify-content-center">
                    <div>
                        <img src="{{ asset('assets/backend/images/errors/500 Internal Server Error.svg') }}" alt=""
                            class="img-fluid" style="width: 500px">
                    </div>
                </div>
                <div class="col-12 text-center">
                    <h3>Internal Server Error</h3>
                    <p class="sub-content">Something went wrong on our end. Please try again later or contact support if the issue persists.</p>
                </div>
            </div>
        </div>
    </div>
    @include('backend.layouts.include.script')
</body>

</html>
