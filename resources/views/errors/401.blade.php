<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 | {{ config('app.name') }}</title>
    @include('backend.layouts.include.style')

</head>

<body>
    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-12 d-flex justify-content-center">
                    <div>
                        <img src="{{ asset('assets/backend/images/errors/401 Error Unauthorized.svg') }}" alt=""
                            class="img-fluid" style="width: 500px">
                    </div>
                </div>
                <div class="col-12 text-center">
                    <h3>Unauthorized Access</h3>
                    <p class="sub-content">You do not have permission to view this page. Please log in with valid credentials.</p>
                </div>
            </div>
        </div>
    </div>
    @include('backend.layouts.include.script')
</body>

</html>
