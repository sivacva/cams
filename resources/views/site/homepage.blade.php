<!DOCTYPE html>
<html lang="en">

<head>
    <!-- set the encoding of your site -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

    <!-- set the page title -->
    <title>Audit</title>
    <!-- include google nunito sans font cdn link -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link rel="shortcut icon" type="image/png" href="../site/image/tn__logo.png" />

    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&amp;display=swap"
        rel="stylesheet">
    <!-- include google cabin font cdn link -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">
    <!-- include the site bootstrap stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ asset('site/css/style.css') }}">
    <!-- include theme color setting stylesheet -->
    <link rel="stylesheet" href="{{ asset('site/css/colors.css') }}">
    <!-- include the site responsive stylesheet -->
    <link rel="stylesheet" href="{{ asset('site/css/responsive.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .control-buttons {
            display: flex;
            align-items: center;
        }

        .control-buttons span {
            margin-right: 10px;
            color: white;
            border: 1px solid white;
            border-radius: 5px;
            font-size: 8px;
            cursor: pointer;
            padding: 2px 5px;
        }

        .bgimage {
            background: url("{{ asset('site/image/bg1.png') }}") no-repeat center center fixed, linear-gradient(45deg, #39588e, #2196f3) #2086c9;
            background: url("{{ asset('site/image/bg1.png') }}") no-repeat center center fixed, linear-gradient(270deg, #ff852b, #003fa5) #08152e;
            background: url("{{ asset('site/image/bg1.png') }}") no-repeat center center fixed, linear-gradient(225deg, #ff852b 10%, #003fa5 40%, #08152e 45%);
            background: url("{{ asset('site/image/bg1.png') }}") no-repeat center center fixed, linear-gradient(225deg, #2bd8ff 10%, #003fa5 30%, #253246 45%);
            background-color: #335e8f;
        }

        #topbar {
            background-color: #1c2435;
            font-size: 14px;
            padding: 0;
            color: rgba(255, 255, 255, 1);
            /*  background:   url(../images/bg2.png), linear-gradient(225deg, #ff852b 10%, #003fa5 40% ,#08152e 45%);*/
            /* background: url("{{ asset('site/image/bg2.png') }}"), linear-gradient(225deg, #2bd8ff 10%, #003fa5 30%, #253246 45%); */
            background-size: cover;
            background-position: top;
        }

        .govt_head .g_row1 {
            align-items: center;
        }


        @media(max-width:600px) {
            .govt_head .g_row1 {
                padding: 2%;
            }

            .g_row1 [class*="col"]:nth-child(odd) {
                width: 28%;
            }

            .g_row1 [class*="col"]:nth-child(even) {
                width: 70%;
            }

            .g_row1 h4,
            .g_row1 h5,
            .g_row1 h6 {
                font-size: 11px;
            }
        }

        .fixed-top {
            z-index: 1030;
            /* Ensure header is above other content */
            background-color: #fff;
            /* Background color for header */
        }

        .text_header {
            color: #326a9a;
            font-size: 35px;
            text-shadow: 1px 1px #bbbbb7;
        }

        #homeCarousel {
            max-height: 400px;
            /* Adjust as needed */
            overflow: hidden;
        }

        #homeCarousel img {
            object-fit: cover;
            /* Ensures images fill the container without distortion */
            height: 100%;
            /* Sets the height to 100% of the container */
            width: 100%;
            /* Sets the width to 100% of the container */
        }

        .empty-content {
            height: 100px;
            background-color: #f7f7f7;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .marquee {
            position: absolute;
            bottom: 0;
            animation: marquee 5s linear infinite;
            text-align: center;
        }

        @keyframes marquee {
            0% {
                transform: translateY(100%);
            }

            100% {
                transform: translateY(-100%);
            }
        }

        .marquee p {
            margin: 0;
            padding: 10px 0;
            text-align: center;
            width: 100%;
        }

        #accordion {
            .card-header {
                margin-bottom: 8px;
            }

            .accordion-title {
                position: relative;
                display: block;
                background: #213744;
                border-radius: 8px;
                overflow: hidden;
                text-decoration: none;
                color: #fff;
                font-size: 16px;
                font-weight: 700;
                width: 100%;
                text-align: left;
                transition: all .4s ease-in-out;
            }

            .accordion-title i {
                position: absolute;
                width: 40px;
                height: 100%;
                right: 0;
                transform: translateY(-50%);
                top: 50%;
                color: #fff;
                background: radial-gradient(rgba(#213744, .8), #213744);
                text-align: center;
                border-left: 1px solid transparent;
            }

            .accordion-title:hover {
                padding-right: 80px;
                background: #213744;
                color: #fff;

                i {
                    border-left: 1px solid #fff;
                }
            }

            [aria-expanded="true"] {
                background: #24b365;
                color: #000;

                i {
                    color: #000;
                    background: #24b365;

                    &:before {
                        content: "\f068";
                    }
                }
            }

            .accordion-body {
                padding: 40px 55px;
            }
        }

        .faq-title h2 {
            position: relative;
            margin-bottom: 45px;
            display: inline-block;
            font-weight: 600;
            line-height: 1;
        }

        .faq-title h2::before {
            content: "";
            position: absolute;
            left: 50%;
            width: 60px;
            height: 2px;
            background: #E91E63;
            bottom: -25px;
            margin-left: -30px;
        }

        .faq-title p {
            padding: 0 190px;
            margin-bottom: 10px;
        }

        .faq {
            background: #FFFFFF;
            box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.06);
            border-radius: 25px;
        }

        .faq .card {
            border: none;
            background: none;
            border-bottom: 1px dashed #CEE1F8;
        }

        .faq .card .card-header {
            padding: 0px;
            border: none;
            background: none;
            -webkit-transition: all 0.3s ease 0s;
            -moz-transition: all 0.3s ease 0s;
            -o-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
        }

        .faq .card .card-header:hover {
            background: rgba(233, 30, 99, 0.1);
            padding-left: 10px;
        }

        .faq .card .card-header .faq-title {
            width: 100%;
            text-align: left;
            padding: 0px;
            padding-left: 30px;
            padding-right: 30px;
            font-weight: 400;
            font-size: 15px;
            letter-spacing: 1px;
            color: #3B566E;
            text-decoration: none !important;
            -webkit-transition: all 0.3s ease 0s;
            -moz-transition: all 0.3s ease 0s;
            -o-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
            cursor: pointer;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .faq .card .card-header .faq-title .badge {
            display: inline-block;
            width: 20px;
            height: 20px;
            line-height: 14px;
            float: left;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
            text-align: center;
            background: #E91E63;
            color: #fff;
            font-size: 12px;
            margin-right: 20px;
        }

        .faq .card .card-body {
            padding: 30px;
            padding-left: 35px;
            padding-bottom: 16px;
            font-weight: 400;
            font-size: 16px;
            color: #6F8BA4;
            line-height: 28px;
            letter-spacing: 1px;
            border-top: 1px solid #F3F8FF;
        }

        .faq .card .card-body p {
            margin-bottom: 14px;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #cdcfd1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #06152e;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #2c2f30;
        }

        @media (max-width: 991px) {
            .faq {
                margin-bottom: 30px;
            }

            .faq .card .card-header .faq-title {
                line-height: 26px;
                margin-top: 10px;
            }

        }

        .scrollclass {

            height: 313px;
            overflow-y: scroll;
            border-radius: 25px;
        }

        .font-gradient {
            /*  background: -webkit-linear-gradient(110deg,#318d38,#ffffff, #ff6c00);*/
            background: -webkit-linear-gradient(90deg, #ffffff, #ffffff, #87e3ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            color: #fff;
        }

        #read-more {
            max-height: 100px;
            overflow: hidden;
        }

        #configuration {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(268deg, #e1eaf9, #e6effe) #e6effe;
        }

        .work-process-list ul li {
            list-style: none;
            display: inline-block;
            margin: 0px 0px 0px;
            position: relative;
            padding: 0px 15px;
        }

        .work-process-list ul li span {
            display: inline-block;
            width: 100%;
            /*    height: 150px;*/
            /* border: 2px solid #fe5f16; */
            position: relative;
            margin: 0px 0px 23px;
            /* border-radius: 50%; */
            line-height: inherit;
            -webkit-box-shadow: 0 0 30px 0 rgb(0 0 0 / 10%);
            -moz-box-shadow: 0 0 30px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 0 30px 0 rgb(0 0 0 / 10%);
            background-color: white;
            padding: 10px;
            color: #fff;
        }

        .work-process-list ul li span a {
            position: absolute;
            right: -23px;
            margin: -22px 0px 0px 0px;
            bottom: 20px;
            font-weight: bold;
            width: 45px;
            height: 45px;
            border: 6px solid #3699da;
            background-color: #348ac3;
            border-radius: 100%;
            color: #ffffff;
            padding: 9px 0px 0px;
            z-index: 1;
        }

        .work-process-list ul li h6 {
            margin: 0px;
            font-size: 16px;
            letter-spacing: 0.4px;
            color: #031724;
            font-weight: 500;

        }

        @media(min-width: 992px) {
            .work-process-list ul li span {
                height: 150px;
                border-right: 1px dashed #e9ebef;
            }

        }

        @media(min-width: 769px) and (max-width: 992px) {
            .work-process-list ul li span {
                height: 200px;
                border-right: 1px dashed #e9ebef;
            }
        }

        @media (max-width768px) {
            .work-process-list ul li span {
                height: auto !important;
            }

            /*.work-process-list ul li span a {
                left: -23px;
            }*/
        }

        .bg-dark-voilet {
            background-color: #1c2435;
        }

        .read-more-button {
            animation: blink 1s infinite alternate;
            color: yellow;
        }

        .read-more-button:hover {
            color: yellow;
        }

        .font-green {
            color: #79cc78;
            text-decoration: none;
        }

        a.font-green:hover,
        a.font-green:focus {
            color: #86e585;
            text-decoration: none;
        }

        a:hover .fa-long-arrow-right {
            transform: translateX(10px);
            transition: 0.2s ease-in;
        }
    </style>
</head>

<body class="bgimage">
    <div id="pageWrapper">
        <div class="phStickyWrap font_div">
            <div class="header_content fixed-top">
                <div id="topbar" class="hdFixerWrap d-lg-block"
                    style="z-index: 1000; background-color: rgba(0, 63, 165, 0.8); position: fixed; width: 100%; top: 0;">
                    <div class="container-fluid py-2">
                        <div class="row align-items-center">
                            <!-- Left side: Government label and Navbar toggle -->
                            <div class="col-6 col-md-6 d-flex align-items-center">
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <a href="#" class="font_div text-white ml-3"
                                    style="font-size: 16px; font-family: 'Helvetica', 'Arial', sans-serif;">
                                    <span class="lang" key="">Screen Reader Access</span>
                                </a>
                            </div>
                            <!-- Right side: Font size buttons and language dropdown -->
                            <div class="col-6 col-md-6 d-flex align-items-center justify-content-end">
                                <div class="control-buttons mr-3">
                                    <button class="px-2 decrease btn btn-sm btn-outline-secondary text-white mr-2"
                                        style="border: 1px solid white;">A-</button>
                                    <button class="px-2 resetMe btn btn-sm btn-outline-secondary text-white mr-2"
                                        style="border: 1px solid white;">A</button>
                                    <button class="px-2 increase btn btn-sm btn-outline-secondary text-white mr-2"
                                        style="border: 1px solid white;">A+</button>
                                </div>
                                <select class="custom-select custom-select-sm" id="translate"
                                    style="width: auto; border-color: #0262af;">
                                    <option value="en">English</option>
                                    <option value="ta">தமிழ்</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="govt_head bg-white mt-5 pt-2">
                    <div class="container-fluid">
                        <div class="row g_row_main mt-3 mb-3 align-items-center">
                            <!-- Left side: Logo and Titles -->
                            <div class="col-md-6 col-md-8">
                                <a href="#">
                                    <div class="row g_row1 align-items-center">
                                        <div class="col-2 col-md-1 d-flex align-items-center justify-content-center">
                                            <img src="{{ asset('site/image/tn__logo.png') }}" class="img-fluid">
                                        </div>
                                        <div class="col-10 col-md-11 text-black">
                                            <h5 class="nameline3 text-black lang mb-0" key="title1" style="line-height: 1;padding-bottom: 7px;color:black;">
                                                Comprehensive Audit Management System</h5>
                                            <h5 class="nameline2 lang mb-0" key="title2" style="line-height: 1;color:black;">
                                                Government of Tamil Nadu</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Right side: Login link -->
                            {{-- <div class="col-md-2 col-md-4 d-flex align-items-center justify-content-end mt-3 mt-md-0">
                                <a class="nav-link text-dark" href="{{ url('/login') }}">
                                    <i class="fa fa-sign-in"></i>
                                    <span class="lang" key="login"> &nbsp; Login </span>
                                </a>
                            </div> --}}

                            <div class="col-md-2 col-md-3 d-flex align-items-center justify-content-end mt-3 mt-md-0">
                                <div class="dropdown">
                                    <button class="btn btn-link nav-link text-dark dropdown-toggle" type="button"
                                        id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-sign-in"></i>
                                        <span class="lang" key="login">Login</span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                                        <li><a class="dropdown-item" href="{{ url('/login') }}">Department Login</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ url('/auditeelogin') }}">Auditee
                                                Login</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <main class="mt-5 pt-4">
        <div class="container p-3">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="aboutAudit mt-5 mb-2">
                        <h1 class="font-weight-bold font-gradient font-gugi animate__animated animate__pulse">
                            Facilitating Digital Audit in Government Departments
                        </h1>
                        <p class="text-justify text-white pt-4 font-weight-bold letter-spacing-1" id="read-more">
                            <strong>CAMS</strong> is a configurable platform enabling government departments like HRIA,
                            SGA, LFA, Cooperative, and Milk Audit to facilitate their audits and to comply with the
                            Directorate of General Audit (DGA).
                        </p>
                        <a href="#" title="Read More" data-toggle="modal" data-target="#aboutAudit"
                            class="font-green">Read more <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div id="homeCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#homeCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#homeCarousel" data-slide-to="1"></li>
                            {{-- <li data-target="#homeCarousel" data-slide-to="2"></li> --}}
                            <li data-target="#homeCarousel" data-slide-to="3"></li>
                        </ol>
                        <!-- Slides -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('site/image/carsoul1.jpg') }}" class="d-block w-100 img-fluid"
                                    id="banner_image" />
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('site/image/carsoul2.jpg') }}" class="d-block w-100 img-fluid"
                                    id="banner_image" />
                            </div>
                            {{-- <div class="carousel-item">
                                <img src="{{ asset('site/mage/carsoul3.jpg') }}" class="d-block w-100 img-fluid"
                                    id="banner_image" />
                            </div> --}}
                            <div class="carousel-item">
                                <img src="{{ asset('site/image/carsoul4.jpg') }}" class="d-block w-100 img-fluid"
                                    id="banner_image" />
                            </div>
                        </div>
                        <!-- Controls -->
                        <a class="carousel-control-prev" href="#homeCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#homeCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section id="configuration" class="py-1 pt-2">
            <div class="container">
            </div>
            <br>
            <div class="container">
                <div class="work-process-list animate__animated animate__slideInLeft">
                    <div class="row p-md-0">
                        <div class="col-12 p-md-0">
                            <h4
                                class="py-2 mb-0 font-weight-bold font-blue font-gugi d-flex align-items-center heading-color-blue animate__animated animate__slideInLeft">
                                Easy Steps of Field Audit
                            </h4>
                        </div>
                    </div>
                    <ul class="row px-md-0 pb-0 mb-0 p-0 pr-5 pr-md-0">
                        <li class="col-12 col-md-2 p-1"><span class="font-weight-500"
                                style="background-color: #7ab435;"><br> Entry Meeting <a
                                    class="fa fa-long-arrow-right" style="border: 6px solid #8fda36;">1</a></span>
                        </li>
                        <li class="col-12 col-md-2 p-1"><span class="font-weight-500"
                                style="background-color: #b48735;"><br> Work Allocation <a
                                    class="fa fa-long-arrow-right" style="border: 6px solid #daa436;">2</a></span>
                        </li>
                        <li class="col-12 col-md-2 p-1"><span class="font-weight-500"
                                style="background-color: #bd5876;"> <br> Audit Slip Issue <a
                                    class="fa fa-long-arrow-right" style="border: 6px solid #ffa2be;">3</a></span>
                        </li>
                        <li class="col-12 col-md-2 p-1"><span class="font-weight-500"
                                style="background-color: #1e9da7;"><br> Reply Audit Slip
                             <a class="fa fa-long-arrow-right"
                                    style="border: 6px solid #36ceda;">4</a></span></li>
                        <li class="col-12 col-md-2 p-1"><span class="font-weight-500"
                                style="background-color: #cdb628;"> <br>Prepare Draft Audit Report <a
                                    class="fa fa-long-arrow-right" style="border: 6px solid #ffdd0f;">5</a></span>
                        </li>
                        <li class="col-12 col-md-2 p-1"><span class="font-weight-500"
                                style="background-color: #428657;"><br> Exit Meeting </span>
                        </li>
                        {{-- <li class="col-12 col-md-2 p-3 mt-md-1 text-center">
                            <p class="heading-color-blue font-weight-bold" style="font-size: 18px">Ready to Use</p>
                            <img src="{{ asset('image/check.png') }}" class="img-fluid title-img"
                                style="max-width: 50%; margin: 0 auto;">
                        </li> --}}
                    </ul>
                </div>
            </div>
        </section>

        <section class="upcomeventsBlock position-relative pt-7 pb-3 mt-3">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch">
                    <!-- Left Card with Three Columns and Headers -->
                    <div class="col-md-12 col-lg-6">
                        <div class="card shadow p-4 mb-6 h-100" style="border-radius: 25px;">
                            <div class="row">
                                <div class="col-6 text-center">
                                    <h5 class="fwSemiBold lang" key="column1">Notification</h5>
                                    <div class="empty-content">
                                        <div class="marquee">
                                            <p class="lang" key="test1">Test 1</p>
                                            <p class="lang" key="test2">test 2</p>
                                            <p class="lang" key="test3">test 3</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <h5 class="fwSemiBold lang" key="column2">Column 2</h5>
                                    <div class="empty-content"
                                        style="height: 100px; background-color: #f7f7f7; border-radius: 10px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Card with Header and Dropdown Content -->
                    <div class="col-md-12 col-lg-6">
                        <div class="card shadow p-4 mb-6 h-100" style="border-radius: 25px;">
                            <header class="headingHead mb-4 d-flex justify-content-between align-items-center">
                                <h4 class="fwSemiBold font_div lang" key="fa">Frequently Asked Questions</h4>
                            </header>
                            <div id="accordion" class="py-1" style="max-height: 400px; overflow-y: auto;">
                                <div class="card border-0 wow fadeInUp">
                                    <div class="card-header p-0 border-0" id="heading-239">
                                        <button
                                            class="btn btn-link accordion-title border-0 collapsed d-flex justify-content-between align-items-center"
                                            data-toggle="collapse" data-target="#collapse-239" aria-expanded="false"
                                            aria-controls="collapse-239">
                                            <i
                                                class="fa fa-plus text-center d-flex align-items-center justify-content-center h-100"></i>
                                            <span class="lang" key="cgi1">What is the CAMS?</span>
                                        </button>
                                    </div>
                                    <div id="collapse-239" class="collapse" aria-labelledby="heading-239"
                                        data-parent="#accordion">
                                        <div class="card-body accordion-body">
                                            <p class="lang" key="cgi1_1">Comprehensive Audit Management System
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-0 wow fadeInUp">
                                    <div class="card-header p-0 border-0" id="heading-240">
                                        <button
                                            class="btn btn-link accordion-title border-0 collapsed d-flex justify-content-between align-items-center"
                                            data-toggle="collapse" data-target="#collapse-240" aria-expanded="false"
                                            aria-controls="collapse-240">
                                            <i
                                                class="fa fa-plus text-center d-flex align-items-center justify-content-center h-100"></i>
                                            <span class="lang" key="cgi2">What are the Department Involved in CAMS?</span>
                                        </button>
                                    </div>
                                    <div id="collapse-240" class="collapse" aria-labelledby="heading-240"
                                        data-parent="#accordion">
                                        <div class="card-body accordion-body">
                                            <p class="lang" key="cgi2_1">HRIA,LFA,SGA,DCA,Milk Audit</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="ftAreaWrap position-relative fontAlter bg-dark-voilet">
        {{-- <aside class="ftConnectAside py-3 text-center">
            <div class="bg-dark-voilet">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="ad_images text-center">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item mx-2">
                                    <a href="#" target="_blank"
                                        title="Panchayat Raj (External Site that opens in a new window)">
                                        <img src="{{ asset('image/deity-logo.png') }}" class="img-fluid"
                                            alt="Panchayat Raj">
                                    </a>
                                </li>
                                <li class="list-inline-item mx-2">
                                    <a href="#" target="_blank"
                                        title="Digital India (External Site that opens in a new window)">
                                        <img src="{{ asset('image/digital-india-logo.png') }}" class="img-fluid"
                                            alt="Digital India">
                                    </a>
                                </li>
                                <li class="list-inline-item mx-2">
                                    <a href="#" target="_blank"
                                        title="Data Portal (External Site that opens in a new window)">
                                        <img src="{{ asset('image/india-gov-logo.png') }}" class="img-fluid"
                                            alt="Data Portal">
                                    </a>
                                </li>
                                <li class="list-inline-item mx-2">
                                    <a href="#" target="_blank"
                                        title="NPI (External Site that opens in a new window)">
                                        <img src="{{ asset('image/niclogo8.png') }}" class="img-fluid"
                                            alt="NPI">
                                    </a>
                                </li>
                                <li class="list-inline-item mx-2">
                                    <a href="#" target="_blank"
                                        title="DeitY (External Site that opens in a new window)">
                                        <img src="{{ asset('image/panchayati-raj.png') }}" class="img-fluid"
                                            alt="DeitY">
                                    </a>
                                </li>
                                <li class="list-inline-item mx-2">
                                    <a href="#" target="_blank"
                                        title="PM India (External Site that opens in a new window)">
                                        <img src="{{ asset('image/pm-india-logo.png') }}" class="img-fluid"
                                            alt="PM India">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </aside> --}}

        <!-- pageFooter -->
        <footer id="pageFooter" class="text-center pt-3 pb-3">
            <img src="{{ asset('site/image/niclogo.png') }}" alt="nic_logo" width="100" height="100">
            <div class="container font_div">
                <p><a href="javascript:void(0);" class="lang" key="foot">Designed By</a> - <a
                        href="javascript:void(0);">NIC</a> &copy; 2024.
                    <br class="d-md-none">
                    <span class="lang" key="rights"></span>
                </p>
            </div>
        </footer>
    </div>

    <div class="modal fade" id="aboutAudit" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AboutAuditOnline">
                        About CAMS
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-justify">
                        <strong>CAMS</strong>
                        is a configurable platform enabling government departments like HRIA, SGA, LFA, Cooperative, and Milk Audit to facilitate their audits and to comply with the Directorate of General Audit (DGA). 
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        var originalSize = $('.font_div').css('font-size');
        // reset
        $(".resetMe").click(function() {
            $('.font_div').css('font-size', originalSize);
        });

        // Increase Font Size
        $(".increase").click(function() {
            var currentFontSize = $('.font_div').css('font-size');
            var currentSize = parseFloat(currentFontSize);

            // Set a maximum font size limit (adjust this value as needed)
            var maxSize = 24;

            if (currentSize < maxSize) {
                var newSize = currentSize * 1.2;
                $('.font_div').css('font-size', newSize + 'px');
            }

            return false;
        });

        // Decrease Font Size
        $(".decrease").click(function() {
            var currentFontSize = $('.font_div').css('font-size');
            var currentSize = parseFloat(currentFontSize);

            // Set a minimum font size limit (adjust this value as needed)
            var minSize = 12;

            if (currentSize > minSize) {
                var newSize = currentSize * 0.8;
                $('.font_div').css('font-size', newSize + 'px');
            }

            return false;
        });
    });



    // Function to change the background color dynamically
    function changeBackgroundColor(color) {
        var elements = document.getElementsByClassName("bg_color");

        // Iterate through all elements with the class "bg_color"
        for (var i = 0; i < elements.length; i++) {
            // Set the background color for each element
            elements[i].style.backgroundColor = color;
        }

        // Store the selected color in local storage
        localStorage.setItem("selectedColor", color);
        document.cookie = "selectedColor=" + color;
    }

    // Example of how to retrieve the selected color from local storage
    var storedColor = localStorage.getItem("selectedColor");
    if (storedColor == null) {
        storedColor = '#007bff';
        window.localStorage.setItem('selectedColor', storedColor);
        // Set a cookie named 'language' with the selected language
        document.cookie = "selectedColor=" + storedColor;
    } else

        changeBackgroundColor(storedColor);



    $(window).on('load', function() {

        var jqxhr = $.getJSON("{{ asset('json/layout.json') }}", function(data) {
                // Once the JSON data is loaded, assign it to the arrLang variable
                arrLang = data;
                //console.log(arrLang); // Logging the data to ensure it's loaded correctly
            })
            .done(function() {
                // This code block will execute when the JSON data is successfully loaded
                translate(); // Call the translate function after the JSON data is loaded
                //changeBackgroundColor(storedColor);
            })
            .fail(function(jqxhr, textStatus, error) {
                // This code block will execute if there is an error in loading the JSON data
                var err = textStatus + ", " + error;
                console.error("Request failed: " + err); // Log the error for debugging
            });



    })


    // Define the translate function
    function translate() {
        // Retrieve the selected language from local storage or set it to English if not present
        var lang = window.localStorage.getItem('lang');
        if (lang == null)
            lang = 'en';

        // Set a cookie named 'language' with the selected language
        document.cookie = "language=" + lang;

        // Update the value of an element with the id 'translate' to reflect the selected language
        $('#translate').val(lang);


        // Check if an element with the id 'banner_image' exists on the page
        var bannerImageExists = document.getElementById('banner_image') !== null;

        if (bannerImageExists) { // If the element exists, do something

            // Change the source (`src`) attribute of an image with the id 'banner_image' based on the selected language
            // if (lang == "ta") {
            //     document.getElementById('banner_image').src =
            //         "https://10.163.19.176/ctax_3009/public/site/images/image_banner.png";
            // } else {
            //     document.getElementById('banner_image').src =
            //         "https://10.163.19.176/ctax_3009/public/site/images/Brown_Banner.jpg";
            // }
        } else {
            // If the element doesn't exist, do something else
            //console.log("Element with id 'banner_image' does not exist on the page.");
        }

        // Update the text content of elements with the class 'lang' based on the translations stored in the arrLang variable for the selected language
        $('.lang').each(function(index, item) {
            $(this).text(arrLang[lang][$(this).attr('key')]);
        });
    }


    // Process translation
    $(function() {
        $('#translate').change(function() {

            lang = ($(this).val());
            window.localStorage.setItem('lang', ($(this).val()));

            $('#translate').val(window.localStorage.getItem('lang'));

            window.localStorage.setItem('active_menu', '');
            translate();
        });
    });
</script>

</html>
<script>
    $(document).ready(function() {
        var originalSize = $('.font_div').css('font-size');
        // reset
        $(".resetMe").click(function() {
            $('.font_div').css('font-size', originalSize);
        });

        // Increase Font Size
        $(".increase").click(function() {
            var currentFontSize = $('.font_div').css('font-size');
            var currentSize = parseFloat(currentFontSize);

            // Set a maximum font size limit (adjust this value as needed)
            var maxSize = 24;

            if (currentSize < maxSize) {
                var newSize = currentSize * 1.2;
                $('.font_div').css('font-size', newSize + 'px');
            }

            return false;
        });

        // Decrease Font Size
        $(".decrease").click(function() {
            var currentFontSize = $('.font_div').css('font-size');
            var currentSize = parseFloat(currentFontSize);

            // Set a minimum font size limit (adjust this value as needed)
            var minSize = 12;

            if (currentSize > minSize) {
                var newSize = currentSize * 0.8;
                $('.font_div').css('font-size', newSize + 'px');
            }

            return false;
        });
    });



    // Function to change the background color dynamically
    function changeBackgroundColor(color) {
        var elements = document.getElementsByClassName("bg_color");

        // Iterate through all elements with the class "bg_color"
        for (var i = 0; i < elements.length; i++) {
            // Set the background color for each element
            elements[i].style.backgroundColor = color;
        }

        // Store the selected color in local storage
        localStorage.setItem("selectedColor", color);
        setCookie("selectedColor", "color", 30);

    }

    // Example of how to retrieve the selected color from local storage
    var storedColor = localStorage.getItem("selectedColor");
    if (storedColor == null) {

        storedColor = '#3365b7';
        window.localStorage.setItem('selectedColor', storedColor);
        // Set a cookie named 'language' with the selected language
        changeBackgroundColor(storedColor);
    } else

        changeBackgroundColor(storedColor);
    $(window).on('load', function() {
        var url = "{{ asset('json/layout.json') }}";
        console.log(url); // Check if the URL is correct

        var jqxhr = $.getJSON(url, function(data) {
                // Once the JSON data is loaded, assign it to the arrLang variable
                arrLang = data;
                //console.log(arrLang); // Logging the data to ensure it's loaded correctly
            })
            .done(function() {
                // This code block will execute when the JSON data is successfully loaded
                translate(); // Call the translate function after the JSON data is loaded
                //changeBackgroundColor(storedColor);
            })
            .fail(function(jqxhr, textStatus, error) {
                // alert('Error in loading JSON: ' + textStatus + ', ' + error); // More descriptive error message
                console.error("Request failed: " + textStatus + ", " +
                    error); // Log the error for debugging
            });




    })


    // Define the translate function
    function translate() {
        // Retrieve the selected language from local storage or set it to English if not present
        var lang = window.localStorage.getItem('lang');
        if (lang == null)
            lang = 'en';

        // Set a cookie named 'language' with the selected language
        document.cookie = "language=" + lang;


        // Update the value of an element with the id 'translate' to reflect the selected language
        $('#translate').val(lang);


        // Check if an element with the id 'banner_image' exists on the page
        var bannerImageExists = document.getElementById('banner_image') !== null;

        if (bannerImageExists) { // If the element exists, do something

            // Change the source (`src`) attribute of an image with the id 'banner_image' based on the selected language
            // if (lang == "ta") {
            //     document.getElementById('banner_image').src =
            //         "https://10.163.19.176/ctax_3009/public/site/images/image_banner.png";
            // } else {
            //     document.getElementById('banner_image').src =
            //         "https://10.163.19.176/ctax_3009/public/site/images/Brown_Banner.jpg";
            // }
        } else {
            // If the element doesn't exist, do something else
            //console.log("Element with id 'banner_image' does not exist on the page.");
        }
        var idproofdropdown_exists = document.getElementById('idproofcode') !== null;
        if (idproofdropdown_exists) {
            get_idproof();
            get_district()
        }
        // Update the text content of elements with the class 'lang' based on the translations stored in the arrLang variable for the selected language
        $('.lang').each(function(index, item) {
            $(this).text(arrLang[lang][$(this).attr('key')]);
        });
    }
    $(function() {
        $('#translate').change(function() {

            lang = ($(this).val());
            window.localStorage.setItem('lang', ($(this).val()));

            $('#translate').val(window.localStorage.getItem('lang'));

            window.localStorage.setItem('active_menu', '');
            translate();
        });
    });

    function setCookie(cookieName, cookieValue, expirationDays) {
        var d = new Date();
        d.setTime(d.getTime() + (expirationDays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
    }


    // Function to get the value of a cookie
    function getCookie(cookieName) {
        var name = cookieName + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var cookieArray = decodedCookie.split(';');
        for (var i = 0; i < cookieArray.length; i++) {
            var cookie = cookieArray[i];
            while (cookie.charAt(0) == ' ') {
                cookie = cookie.substring(1);
            }
            if (cookie.indexOf(name) == 0) {
                return cookie.substring(name.length, cookie.length);
            }
        }
        return "";
    }
</script>
<style>

</style>

<!-- include jQuery library -->
<script src="{{ asset('site/js/jquery-3.4.1.min.js') }}"></script>
<!-- include custom JavaScript -->
<script src="{{ asset('site/js/jqueryCustom.js') }}"></script>
<!-- include plugins JavaScript -->
<script src="{{ asset('site/js/plugins.js') }}"></script>
<!-- include fontAwesome -->
<script>
    var storedColor = localStorage.getItem("selectedColor");
    if (storedColor == null) {
        storedColor = '#007bff';
        window.localStorage.setItem('selectedColor', storedColor);
        // Set a cookie named 'language' with the selected language
        // document.cookie = "selectedColor=" + storedColor;

        changeBackgroundColor(storedColor);
    } else
        changeBackgroundColor(storedColor);

    $('.read-more').click(function() {
        $(this).toggleClass('expanded');
    });
</script>
