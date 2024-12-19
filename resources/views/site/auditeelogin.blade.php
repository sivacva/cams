<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="../site/image/tn__logo.png" />

    <!-- Core Css -->
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="../common/custom.css" />


    <title>CAMS - Login</title>
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <img src="../site/image/tn__logo.png" alt="loader" class="lds-ripple img-fluid" />
    </div>

    @include('layouts.site_header')

    <div id="main-wrapper" class="auth-customizer-none">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3 auth-card">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a class="text-nowrap logo-img text-center d-block mb-5 w-100">
                                    <!-- <img src="../assets/images/logos/dark-logo.svg" class="dark-logo" alt="Logo-Dark" />
                    <img src="../assets/images/logos/light-logo.svg" class="light-logo" alt="Logo-light" /> -->
                                    <h2>Auditee Login </h2>
                                </a>
                                <!-- <div class="row">
                    <div class="col-6 mb-2 mb-sm-0">
                        <a class="btn text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="javascript:void(0)" role="button">
                        <img src="../assets/images/svgs/google-icon.svg" alt="modernize-img" class="img-fluid me-2" width="18" height="18">
                        <span class="flex-shrink-0">with Google</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a class="btn text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="javascript:void(0)" role="button">
                        <img src="../assets/images/svgs/facebook-icon.svg" alt="modernize-img" class="img-fluid me-2" width="18" height="18">
                        <span class="flex-shrink-0">with FB</span>
                        </a>
                    </div>
                    </div> -->
                                <!-- <div class="position-relative text-center my-4">
                    <p class="mb-0 fs-4 px-3 d-inline-block bg-body text-dark z-index-5 position-relative">or sign in with
                    </p>
                    <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                    </div> -->
                                <form id="login-form" name="login-form" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Username</label>
                                        <input type="email" class="form-control" id="username" name="username"
                                            aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <!-- <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label text-dark" for="flexCheckChecked">
                            Remeber this Device
                        </label> -->
                                        </div>
                                        <a class="text-primary fw-medium">Forgot
                                            Password ?</a>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign
                                        In</button>
                                    <!-- <div class="d-flex align-items-center justify-content-center">
                        <p class="fs-4 mb-0 fw-medium">New to Modernize?</p>
                        <a class="text-primary fw-medium ms-2" href="../main/authentication-register.html">Create an
                        account</a>
                    </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>
        function handleColorTheme(e) {
            document.documentElement.setAttribute("data-color-theme", e);
        }
    </script>


    <!-- Import Js Files -->
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/theme/theme.js"></script>
    <script src="../assets/js/jquery_3.7.1.js"></script>
    <script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>



    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#login-form").validate({
                rules: {
                    username: {
                        required: true,
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    username: {
                        required: "Enter username",
                    },
                    password: {
                        required: "Enter password",
                    }
                },
                submitHandler: function(form) {
                    // You can handle the form submission here (e.g., Ajax submission)
                    // form.submit();

                    $.ajax({
                        url: "{{ route('auditee_validatelogin') }}",
                        type: "POST",
                        data: {
                            username: $('#username').val(),
                            password: $('#password').val()
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.href = response.redirect_url;
                            } else {
                                alert(response.message);
                                window.location.href = "/";
                            }
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = 'Login failed:<br>';
                            $.each(errors, function(key, value) {
                                errorMessage += value + '<br>';
                            });
                            console.log(errorMessage);
                        }
                    });
                }
            });

        });
    </script>
</body>

</html>
