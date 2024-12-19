<style>
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

    .header_content {
        background-color: #fff;
        /* Background color for header */
    }
</style>

<div class="header_content fixed-top">
    <div id="topbar" class="hdFixerWrap d-lg-block "
        style="z-index: 1000; background-color: rgba(0, 63, 165, 0.8); position: fixed; width: 100%; top: 0;">
        <div class="container py-2">
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
                        <button class="px-2 decrease btn btn-sm btn-outline-secondary text-white mr-5 ml-5"
                            style="border: 1px solid white;">A-</button>
                        <button class="px-2 resetMe btn btn-sm btn-outline-secondary text-white mr-5"
                            style="border: 1px solid white;">A</button>
                        <button class="px-2 increase btn btn-sm btn-outline-secondary text-white mr-5"
                            style="border: 1px solid white;">A+</button>
                    </div>
                    <select class="custom-select custom-select-sm" style="width: auto;" id="translate">
                        <option value="en">English</option>
                        <option value="ta">தமிழ்</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <section class="govt_head bg-white mt-5 ">
        <div class="container">
            <div class="row g_row_main mt-5 mb-2 align-items-center">
                <!-- Left side: Logo and Titles -->
                <div class="col-md-6 col-md-8">
                    <a href="#">
                        <div class="row g_row1 align-items-center">
                            <div class="col-2 col-md-1 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('site/image/tn__logo.png') }}" class="img-fluid">
                            </div>
                            <div class="col-10 col-md-11 text-black">
                                <h5 class="nameline3 lang mb-0" key="title1" style="line-height: 1;padding-bottom: 7px;color:black;">
                                    Comprehensive Audit Management System</h5>
                                <h5 class="nameline2 lang mb-0" key="title2" style="line-height: 1;color:black;">
                                    Government of Tamil Nadu</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Right side: Login link -->
                <div class="col-md-2 col-md-3 d-flex align-items-center justify-content-end mt-3 mt-md-0">
                    <div class="dropdown">
                        <button class="btn btn-link nav-link text-dark dropdown-toggle" type="button"
                            id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-sign-in"></i>
                            <span class="lang" key="login">Login</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                            <li><a class="dropdown-item" href="{{ url('/login') }}">Department Login</a></li>
                            <li><a class="dropdown-item" href="{{ url('/auditeelogin') }}">Auditee Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        var jqxhr = $.getJSON("{{ asset('json/layout.json') }}", function(data) {
                // Once the JSON data is loaded, assign it to the arrLang variable
                arrLang = data;
                console.log(arrLang); // Logging the data to ensure it's loaded correctly
            })
            .done(function() {
                // This code block will execute when the JSON data is successfully loaded
                translate(); // Call the translate function after the JSON data is loaded
                //changeBackgroundColor(storedColor);
            })
            .fail(function(jqxhr, textStatus, error) {
                // This code block will execute if there is an error in loading the JSON data
                var err = textStatus + ", " + error;
                console.log("Request failed: " + err); // Log the error for debugging
            });


    });

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
        // var bannerImageExists = document.getElementById('banner_image') !== null;

        // if (bannerImageExists) { // If the element exists, do something

        //     // Change the source (`src`) attribute of an image with the id 'banner_image' based on the selected language
        //     // if (lang == "ta") {
        //     //     document.getElementById('banner_image').src =
        //     //         "https://10.163.19.176/ctax_3009/public/site/images/image_banner.png";
        //     // } else {
        //     //     document.getElementById('banner_image').src =
        //     //         "https://10.163.19.176/ctax_3009/public/site/images/Brown_Banner.jpg";
        //     // }
        // } else {
        //     // If the element doesn't exist, do something else
        //     //console.log("Element with id 'banner_image' does not exist on the page.");
        // }
        // var idproofdropdown_exists = document.getElementById('idproofcode') !== null;
        // if (idproofdropdown_exists) {
        //     get_idproof();
        //     get_district()
        // }
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
