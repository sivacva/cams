$(".only_numbers").on("keypress", function (event) {
    if (event.charCode >= 48 && event.charCode <= 57)
        return true; // let it happen, don't do anything
    else return false;
});

document.addEventListener("DOMContentLoaded", function () {
    // Select all the select elements
    const selects = document.querySelectorAll(".form-select");

    // Function to handle color updates for the selected option
    function updateSelectColor() {
        const selectedOption = this.options[this.selectedIndex];

        // If the selected option is empty (default), set the text color to gray
        if (selectedOption.value === "") {
            this.style.color = "gray"; // Text color of the select itself
        } else {
            this.style.color = "black"; // Text color of the select itself
        }
    }

    // Iterate over each select element
    selects.forEach((select) => {
        // Initially update the color on page load
        updateSelectColor.call(select);

        // Add event listener for focus (when clicked)
        select.addEventListener("focus", function () {
            this.style.backgroundColor = "white"; // Set background color to white when focused

            // Update color for options when select box is focused
            const options = this.querySelectorAll("option");
            options.forEach((option) => {
                if (option.value === "") {
                    option.style.color = "gray"; // Set empty option color to gray
                } else {
                    option.style.color = "black"; // Set other options to black
                }
            });
        });

        // Add event listener for blur (when focus is lost)
        select.addEventListener("blur", function () {
            this.style.backgroundColor = ""; // Remove background color when focus is lost
            // Reset the color of the selected option based on its value
            updateSelectColor.call(this);
        });

        // Add event listener for change (when user selects an option)
        select.addEventListener("change", updateSelectColor);
    });
});

function updateSelectColorByValue(selectElements) {
    selectElements.forEach((selectElement) => {
        // Update the color of the select element based on the selected value
        const selectedOption =
            selectElement.options[selectElement.selectedIndex];

        // Apply color to the select element's text
        selectElement.style.color =
            selectedOption.value === "" ? "gray" : "black";

        // Apply color to all options inside the select element
        Array.from(selectElement.options).forEach((option) => {
            option.style.color = option.value === "" ? "gray" : "black";
        });
    });
}

function init_datepicker(inputId, startDate, endDate, setdate = null) {
    // Initialize the datepicker with the provided options
    $("#" + inputId).datepicker({
        format: "dd/mm/yyyy", // Set the date format
        startDate: startDate, // Set the start date
        endDate: endDate, // Set the end date
        autoclose: true, // Close the datepicker when a date is selected
    });

    // If a setdate is provided, set the initial date
    if (setdate) {
        $("#" + inputId).datepicker("setDate", setdate); // Set the date to the provided date
    } else {
        $("#" + inputId).datepicker("show");
    }

    // Optionally show the datepicker (you can comment this if you don't want it to show immediately)
    //
}

function fn_captilise_each_word(txtbox_name) {
    var value = $("#" + txtbox_name).val();
    text = value
        .toLowerCase()
        .split(" ")
        .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
        .join(" ");
    document.getElementById(txtbox_name).value = text;
    return true;
}

function capitalizeFirstLetter(txtbox_name) {
    const inputField = document.getElementById(txtbox_name);
    const value = inputField.value;

    // Capitalize first letter and keep the rest as it is
    inputField.value = value.charAt(0).toUpperCase() + value.slice(1);
    document.getElementById(txtbox_name).value = inputField.value;
    return true;
}

$(".name").on("keypress", function (event) {
    if (
        (event.charCode > 64 && event.charCode < 91) ||
        (event.charCode > 96 && event.charCode < 123) ||
        event.charCode == 32
    )
        return true;
    else return false;
});

// Allow Alphabets and Numbers
$(".alpha_numeric").on("keypress", function (event) {
    if (
        (event.charCode > 64 && event.charCode < 91) ||
        (event.charCode > 96 && event.charCode < 123) ||
        (event.charCode >= 48 && event.charCode <= 57) ||
        event.charCode == 32
    )
        return true; // let it happen, don't do anything
    else return false;
});

function ValidateEmail() {
    var email = document.getElementById("email").value;
    var lblError = document.getElementById("lblError");
    lblError.innerHTML = "";
    var expr =
        /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (!expr.test(email)) {
        lblError.innerHTML = "Invalid email address.";
    }
}

$("#email").on("keypress", function (event) {
    var regex = new RegExp("^[a-zA-Z0-9!#$%&'*+-/=?^_`{|}~@]+$");
    var key = String.fromCharCode(
        !event.charCode ? event.which : event.charCode
    );
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});

function change_button_as_update(
    form_name,
    action_name,
    button_action,
    error,
    card_name,
    closebtn
) {
    if (error) $("#" + error).hide();

    if (card_name) $("#" + card_name).show();
    if (closebtn) $("#" + closebtn).html("Close");

    $("#" + form_name).show();
    $("#" + form_name)[0].reset();
    $("#" + action_name).val("update");
    // $("#" + button_action).html(get_jsonvalue("update"));
    $("#" + button_action).val("Update");
    $("#" + button_action).html("Update");

    document.getElementById(button_action).style.backgroundColor = "#0262af";
    document.getElementById(button_action).style.color = "#FFFFFF";
    window.scrollTo(0, 0);
}

function change_button_as_insert(
    form_name,
    action_name,
    button_action,
    error,
    closebtn
) {
    if (error) $("#" + error).hide();
    $("#" + form_name)[0].reset();
    $("#" + action_name).val("insert");
    // $("#" + button_action).html(get_jsonvalue("insert"));
    $("#" + button_action).val("Save");
    $("#" + button_action).html("Save Draft");

    document.getElementById(button_action).style.backgroundColor = "#b71362";
    document.getElementById(button_action).style.color = "#FFFFFF";
    if (closebtn) $("#" + closebtn).html("Clear");
}

// Helper function to format a date to dd/mm/yyyy
function formatDate(date) {
    var day = date.getDate().toString().padStart(2, "0"); // Ensure 2 digits for day
    var month = (date.getMonth() + 1).toString().padStart(2, "0"); // Ensure 2 digits for month
    var year = date.getFullYear(); // Get the full year
    return day + "/" + month + "/" + year; // Return formatted date
}

// Helper function to convert dd/mm/yyyy to yyyy-mm-dd format (required for <input type="date>")
function convertToInputDateFormat(date) {
    var parts = date.split("/");
    return parts[2] + "-" + parts[1] + "-" + parts[0]; // Convert to yyyy-mm-dd
}

function convertDateFormatYmd_ddmmyy(dateString) {
    // Assuming the input date format is "yyyy-mm-dd"
    const [year, month, day] = dateString.split("-");

    // Convert to dd/mm/yyyy format
    return `${day}/${month}/${year}`;
}

function passing_large_alert(
    alert_header,
    alert_body,
    alert_name,
    alert_header_id,
    alert_body_id,
    alert_type
) {
    const element = document.getElementById("process_button");
    element.classList.remove("btn-danger");

    $("#ok_button").hide();
    $("#cancel_button").hide();
    $("#process_button").show();
    $("#process_button").html("Ok");
    $("#cancel_button").show();
    element.classList.add("btn-success");

    var selectedcolor = localStorage.getItem("selectedColor");
    if (!selectedcolor) selectedcolor = "#3365b7";

    $(".modal-header").css({
        "background-color": selectedcolor,
    });
    $("#" + alert_header_id).html(alert_header);
    $("#" + alert_body_id).html(alert_body);

    $("#" + alert_name).modal("show");

    // #593320
}

function passing_alert_value(
    alert_header,
    alert_body,
    alert_name,
    alert_header_id,
    alert_body_id,
    alert_type
) {
    if (alert_type == "confirmation_alert") {
        $("#process_button").hide();
        $("#ok_button").show();
        $("#cancel_button").hide();
        $("#button_close").hide();
    }
    if (alert_type == "delete_alert") {
        const element = document.getElementById("process_button");
        element.classList.remove("btn-success");
        $("#ok_button").hide();
        $("#cancel_button").hide();
        $("#process_button").show();
        $("#process_button").html("Delete");
        $("#cancel_button").show();
        // Add a class (quote) to the element
        element.classList.add("btn-danger");
    }
    if (alert_type == "forward_alert") {
        const element = document.getElementById("process_button");
        element.classList.remove("btn-danger");

        $("#ok_button").hide();
        $("#cancel_button").hide();
        $("#process_button").show();
        $("#process_button").html("Ok");
        $("#cancel_button").show();
        element.classList.add("btn-success");
    }
    if (alert_type == "confirmation_alert_with_function") {
        const element = document.getElementById("process_button");
        element.classList.remove("btn-danger");
        $("#close_button").hide();
        $("#ok_button").hide();
        $("#cancel_button").hide();
        $("#process_button").show();
        $("#process_button").html("Ok");
        $("#cancel_button").hide();
        // $('#button_close').hide();
        element.classList.add("btn-success");
    }

    var selectedcolor = localStorage.getItem("selectedColor");
    if (!selectedcolor) selectedcolor = "#3365b7";

    $(".modal-header").css({ "background-color": selectedcolor });
    $("#" + alert_header_id).html(alert_header);
    $("#" + alert_body_id).html(alert_body);

    $("#" + alert_name).modal("show");

    // #593320
}






 function change_dateformat(inputDate)
 {
    // Create a Date object
    let dateObj = new Date(inputDate);

    // Format the date as "dd-mm-yyyy"
    let day = String(dateObj.getDate()).padStart(2, '0'); // Ensure two digits for day
    let month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Ensure two digits for month
    let year = dateObj.getFullYear(); // Get the full year

    // Get the time in 12-hour format with AM/PM
    let hours = dateObj.getHours();
    let minutes = String(dateObj.getMinutes()).padStart(2, '0');
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12; // Convert to 12-hour format
    hours = hours ? hours : 12; // Handle 0 hour as 12 (midnight)

    // Combine the date and time in the desired format
    let formattedDate = day + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ' ' + ampm;

   return formattedDate; // Output: 14-12-2024 10:14 PM

 }
