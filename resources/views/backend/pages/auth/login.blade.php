<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{ $setting->site_name ?? config('app.name') }}</title>
    @include('backend.layouts.include.style')
    <style>
        body {
            background-color: #D4DBF9;
        }

        .card {
            position: relative;
            z-index: 2;
        }

        .img-fluid {
            max-width: 100px;
        }
    </style>
</head>

<body>
    <div class="overlay"></div>

    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="card-body ">
                            <div class="d-flex justify-content-center my-3">
                                <img src="{{ asset('uploads/settings') }}/{{ $setting->site_logo }}" alt="Logo"
                                    class="img-fluid" style="max-width: 180px; margin-top: 20px;">
                            </div>

                            <div class="p-2">
                                <form action="{{ route('admin.login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email<span
                                                class="text-danger">*</span></label>
                                        <input type="email"
                                            class="form-control @error('email')
                                        is-invalid
                                    @enderror"
                                            id="email" placeholder="Enter email" name="email"
                                            value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="Enter password"
                                                aria-label="Password" aria-describedby="password-addon"
                                                name="login[password]">
                                            <button class="btn btn-light" type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember-check"
                                            name="remember">
                                        <label class="form-check-label" for="remember-check">
                                            Remember me
                                        </label>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.layouts.include.script')
</body>

</html>
