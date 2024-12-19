$(document).ready(function () {
    var originalSize = $(".font_div").css("font-size");
    // reset
    $(".resetMe").click(function () {
        $(".font_div").css("font-size", originalSize);
    });

    // Increase Font Size
    $(".increase").click(function () {
        var currentFontSize = $(".font_div").css("font-size");
        var currentSize = parseFloat(currentFontSize);

        // Set a maximum font size limit (adjust this value as needed)
        var maxSize = 24;

        if (currentSize < maxSize) {
            var newSize = currentSize * 1.2;
            $(".font_div").css("font-size", newSize + "px");
        }

        return false;
    });

    // Decrease Font Size
    $(".decrease").click(function () {
        var currentFontSize = $(".font_div").css("font-size");
        var currentSize = parseFloat(currentFontSize);

        // Set a minimum font size limit (adjust this value as needed)
        var minSize = 12;

        if (currentSize > minSize) {
            var newSize = currentSize * 0.8;
            $(".font_div").css("font-size", newSize + "px");
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
    storedColor = "#3782ce";
    window.localStorage.setItem("selectedColor", storedColor);
    // Set a cookie named 'language' with the selected language
    document.cookie = "selectedColor=" + storedColor;
} else changeBackgroundColor(storedColor);

document.addEventListener("DOMContentLoaded", function () {
    var jqxhr = $.getJSON("/json/layout.json", function (data) {
        // Once the JSON data is loaded, assign it to the arrLang variable
        arrLang = data;
        console.log(arrLang); // Logging the data to ensure it's loaded correctly
    })
        .done(function () {
            // This code block will execute when the JSON data is successfully loaded
            translate(); // Call the translate function after the JSON data is loaded
            //changeBackgroundColor(storedColor);
        })
        .fail(function (jqxhr, textStatus, error) {
            // This code block will execute if there is an error in loading the JSON data
            var err = textStatus + ", " + error;
            console.log("Request failed: " + err); // Log the error for debugging
        });
});

function translate() {
    // Retrieve the selected language from local storage or set it to English if not present
    var lang = window.localStorage.getItem("lang");
    if (lang == null) lang = "en";

    // Set a cookie named 'language' with the selected language
    document.cookie = "language=" + lang;

    // Update the value of an element with the id 'translate' to reflect the selected language
    $("#translate").val(lang);

    var major_objection_exists =
        document.getElementById("majorobjectioncode") !== null;

    if (major_objection_exists) {
        // get_objectiondetail();
        // get_severity();
    }

    $(".lang").each(function (index, item) {
        $(this).text(arrLang[lang][$(this).attr("key")]);
    });
    $("button.lang").each(function (index, item) {
        var key = $(this).attr("key"); // Get the key attribute
        if (key && arrLang[lang][key]) {
            $(this).text(arrLang[lang][key]); // Update the button text
        }
    });
}

$(function () {
    $("#translate").change(function () {
        lang = $(this).val();
        window.localStorage.setItem("lang", $(this).val());

        $("#translate").val(window.localStorage.getItem("lang"));

        window.localStorage.setItem("active_menu", "");
        translate();
    });
});
function setCookie(cookieName, cookieValue, expirationDays) {
    var d = new Date();
    d.setTime(d.getTime() + expirationDays * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie =
        cookieName + "=" + cookieValue + ";" + expires + ";path=/";
}

// Function to get the value of a cookie
function getCookie(cookieName) {
    var name = cookieName + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookieArray = decodedCookie.split(";");
    for (var i = 0; i < cookieArray.length; i++) {
        var cookie = cookieArray[i];
        while (cookie.charAt(0) == " ") {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) == 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return "";
}
