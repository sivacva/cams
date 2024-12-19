@section('content')
    @extends('index2')
    @include('common.alert')
    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_color">Department User Creation</div>
                <div class="card-body">
                    <form id="createuser" name="createuser">
                        <div class="alert alert-danger alert-dismissible fade show hide_this" role="alert"
                            id="display_error">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @csrf
                        <input type="hidden" name="userid" id="userid" value="" />
                        <div class="row">
                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefault01">Department </label>
                                <select class="form-select mySelect" id="deptcode" name="deptcode">
                                    <option value=''>Select Department</option>
                                    @foreach ($dept as $department)
                                        <option value="{{ $department->deptcode }}">
                                            {{ $department->deptelname }} <!-- Display any field you need -->
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefault01">Designation </label>
                                <select class="form-select mySelect" id="desigid" name="desigid">
                                    <option value=''>Select Designation</option>
                                    @foreach ($designation as $department)
                                        <option value="{{ $department->desigcode }}">
                                            {{ $department->desigelname }} <!-- Display any field you need -->
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefault02">IFHRMS ID</label>
                                <input type="text" class="form-control alpha_numeric" id="ifhrmsno" name="ifhrmsno"
                                    placeholder="03548975" />
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefault01">Name </label>
                                <input type="text" class="form-control name" id="username" name="username"
                                    placeholder="First name" oninput ="capitalizeFirstLetter('username')" />
                            </div>

                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefault02">Date Of birth</label>
                                <!-- <input type="date" class="form-control"   id="dob" name="dob"/> -->
                                <div class="input-group" onclick="datepicker('dob','')">
                                    <input type="text" class="form-control datepicker" id="dob" name="dob"
                                        placeholder="dd/mm/yyyy" />
                                    <span class="input-group-text">
                                        <i class="ti ti-calendar fs-5"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefaultUsername">Gender</label>
                                <select class="form-select " id="gendercode" name="gendercode">
                                    <option value=''>Select Gender</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    <option value="T">Transgender</option>
                                </select>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefaultUsername">Mobile Number</label>
                                <input type="text" class="form-control only_numbers" id="mobilenumber"
                                    name="mobilenumber" placeholder="9024598988" maxlength = "10" required />
                            </div>
                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefault01">Email </label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="xxx2@gmail.com" required />
                            </div>
                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefault02">Date Of Joining</label>
                                <!-- <input type="date" class="form-control" id ="doj" name="doj" /> -->
                                <div class="input-group" onclick="datepicker('doj','')">
                                    <input type="text" class="form-control datepicker" id="doj" name="doj"
                                        placeholder="dd/mm/yyyy" />
                                    <span class="input-group-text">
                                        <i class="ti ti-calendar fs-5"></i>
                                    </span>
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefaultUsername">Date Of
                                    Revealing</label>
                                <!-- <input type="date" class="form-control" id="dor" name="dor" /> -->
                                <div class="input-group" onclick="datepicker('dor','')">
                                    <input type="text" class="form-control datepicker" id="dor" name="dor"
                                        placeholder="dd/mm/yyyy" />
                                    <span class="input-group-text">
                                        <i class="ti ti-calendar fs-5"></i>
                                    </span>
                                </div>


                            </div>
                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefault01">Auditor </label>
                                <select class="form-select " id="auditorflag" name="auditorflag">
                                    <option value=''>Select Auditor</option>
                                    <option value="Y">Yes</option>
                                    <option value="N">No</option>

                                </select>
                            </div>

                        </div>

                        <input type="hidden" name="action" id="action" value="insert" />


                        <div class="row mt-3">
                            <div class="col-md-2  mx-auto">
                                <input type="submit" name="buttonaction" id="buttonaction" class="btn button_save"
                                    value="Save" />
                                <button type="button" class="btn btn-danger" id="reset_button">clear</button>

                            </div>

                        </div>

                    </form>
                </div>
            </div>


            <div class="card ">
                <div class="card-header card_header_color">Department User Details</div>
                <div class="card-body"><br>
                    <div class="datatables">
                        <div class="table-responsive hide_this" id="tableshow">
                            <table id="usertable"
                                class="table w-100 table-striped table-bordered display text-nowrap datatables-basic">
                                <thead>
                                    <tr>
                                        <th class="lang" key="s_no">S.No</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>User Details</th>
                                        <th>Email</th>
                                        <th>Mobile Number</th>
                                        <th class="all">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div id='no_data' class='hide_this'>
                        <center>No Data Available</center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
<!-- <script src="../assets/js/vendor.min.js"></script>  -->

<script src="../assets/js/jquery_3.7.1.js"></script>
<script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>

<script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>

<script src="../assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>



<script>
    //calling datepicker with mindate and maxdate
    function datepicker(value, setdate) {
        var today = new Date();
        if (value == 'dob') {
            // Calculate the minimum date (18 years ago)
            var maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

            // Calculate the maximum date (60 years ago)
            var minDate = new Date(today.getFullYear() - 60, today.getMonth(), today.getDate());
        }
        if (value == 'doj') {
            var minDate = new Date(today.getFullYear() - 60, today.getMonth(), today
                .getDate()); // Calculate the maximum date (60 years ago)
            var maxDate = today;
        }
        if (value == 'dor') {
            // Calculate the maximum date (60 years ago)
            var maxDate = new Date(today.getFullYear() + 40, today.getMonth(), today.getDate());
            var minDate = today;
        }
        // Format the dates to dd/mm/yyyy format
        var minDateString = formatDate(minDate); // Format date to dd/mm/yyyy
        var maxDateString = formatDate(maxDate); // Format date to dd/mm/yyyy

        init_datepicker(value, minDateString, maxDateString, setdate)
    }

    $(document).ready(function() {
        $('#createuser')[0].reset();
        updateSelectColorByValue(document.querySelectorAll(".form-select"));

        // reset_form();
        // Initialize DataTable
        var table = $('#usertable').DataTable({
            "processing": true,
            "serverSide": false,
            "lengthChange": false,
            "ajax": {
                "url": "/user/fetchAllData", // Your API route for fetching data
                "type": "POST",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Pass CSRF token in headers
                },
                "dataSrc": function(json) {

                    if (json.data && json.data.length > 0) {
                        $('#tableshow').show();
                        $('#usertable_wrapper').show();
                        $('#no_data').hide(); // Hide custom "No Data" message
                        return json.data;
                    } else {
                        $('#tableshow').hide();
                        $('#usertable_wrapper').hide();
                        $('#no_data').show(); // Show custom "No Data" message
                        return [];
                    }
                }
            },
            "columns": [{
                    "data": null, // Serial number column
                    "render": function(data, type, row, meta) {
                        return meta.row + 1; // Serial number starts from 1
                    }
                },
                {
                    "data": "deptesname"
                },
                {
                    "data": "desigesname"
                },
                {
                    "data": "username",
                    "render": function(data, type, row) {
                        // Convert DOB to dd-mm-yyyy format
                        let dob = row.dob ? new Date(row.dob).toLocaleDateString('en-GB') :
                            "N/A";

                        return `<b>Name :</b> ${data} <br> <small><b>IFHRMS No : </b>${row.ifhrmsno}</small> <br> <small><b>DOB :</b> ${dob}</small>`;
                    }

                },
                {
                    "data": "email"
                },
                {
                    "data": "mobilenumber"
                },
                {
                    "data": "encrypted_deptuserid", // Use the encrypted deptuserid
                    "render": function(data, type, row) {
                        return `<center>
                                <a class="btn editicon edit_user" id="${data}">
                                    <i class="ti ti-edit fs-4"></i>
                                </a>
                            </center>
                            `;
                    }
                }
            ]
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var validator = $("#createuser").validate({
            rules: {
                deptcode: {
                    required: true,
                },
                desigid: {
                    required: true,
                },
                ifhrmsno: {
                    required: true,
                },
                username: {
                    required: true,
                },
                dob: {
                    required: true,
                },
                gendercode: {
                    required: true,
                },
                doj: {
                    required: true,
                },
                dor: {
                    required: true,
                },
                auditorflag: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                mobilenumber: {
                    required: true,
                    digits: true,
                    minlength: 10
                }
            },
            messages: {
                deptcode: {
                    required: "Select department name",
                },
                ifhrmsno: {
                    required: "Enter ifhrms number",
                },
                username: {
                    required: "Enter username",
                },
                desigid: {
                    required: "Select designation",
                },
                dob: {
                    required: "Select date of birth",
                },
                gendercode: {
                    required: "Select gender",
                },
                dor: {
                    required: "Select date of relieving",
                },
                doj: {
                    required: "Select date of joining",
                },
                auditorflag: {
                    required: "Select auditorflag",
                },
                email: {
                    required: "Enter an email address.",
                    email: "Enter a valid email address."
                },
                mobilenumber: {
                    required: "Enter your phone number.",
                    digits: "Enter a valid phone number.",
                    minlength: "Your phone number must be at least 10 digits long."
                }
            },
            errorPlacement: function(error, element) {
                // For datepicker fields inside input-group, place error below the input group
                if (element.hasClass('datepicker')) {
                    error.insertAfter(element.closest('.input-group'));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                // You can handle the form submission here (e.g., Ajax submission)
                var formData = $('#createuser').serialize();
                $.ajax({
                    url: '/user/insert', // For creating a new user or updating an existing one
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            reset_form();
                            passing_alert_value('Confirmation', response.success,
                                'confirmation_alert', 'alert_header', 'alert_body',
                                'confirmation_alert');

                            table.ajax.reload(); // Reload the table
                        } else if (response.error) {}
                    },
                    error: function(xhr, status, error) {

                        var response = JSON.parse(xhr.responseText);

                        var errorMessage = response.error ||
                            'An unknown error occurred';

                        // // Extracting error details
                        // var errorMessage = 'An error occurred.';

                        // Optionally, you can check for the type of error
                        // if (xhr.status === 400) {
                        //     // Example of handling 400 Bad Request error
                        //     errorMessage =  xhr.responseText;
                        // } else if (xhr.status === 500) {
                        //     // Example of handling 500 Internal Server Error
                        //     errorMessage = 'Server error: ' + xhr.responseText;
                        // } else {
                        //     // You can include the status or other relevant details
                        //     errorMessage = 'Error ' + xhr.status + ': ' + error;
                        // }

                        // Displaying the error message
                        passing_alert_value('Alert', errorMessage, 'confirmation_alert',
                            'alert_header', 'alert_body', 'confirmation_alert');


                        // Optionally, log the error to console for debugging
                        console.error('Error details:', xhr, status, error);
                    }
                });
            }
        });

        // Define the reset_form function here within the $(document).ready block
        function reset_form() {
            $('#display_error').hide();
            validator.resetForm();
            change_button_as_insert('createuser', 'action', 'buttonaction', 'display_error', '', '');
            updateSelectColorByValue(document.querySelectorAll(".form-select"));
        }

        // If you have a button or event that calls reset_form, make sure it's hooked up
        // Example usage (when you have a reset button):
        $('#reset_button').on('click', function() {
            reset_form(); // Call the reset_form function
        });

        $(document).on('click', '.edit_user', function() {
            // Add more logic here
            var id = $(this).attr('id'); //Getting id of user clicked edit button.
            if (id) {
                reset_form();
                getuserdetail(id)
            }
        });

        function getuserdetail(deptuserid) {
            $.ajax({
                url: '/user/fetchUserData', // Your API route to get user details
                method: 'POST',
                data: {
                    deptuserid: deptuserid
                }, // Pass deptuserid in the data object
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        $('#display_error').hide();
                        validator.resetForm();
                        change_button_as_update('createuser', 'action', 'buttonaction',
                            'display_error', '', '');
                        var user = response.data;
                        // Populate the form or modal with user details for editing
                        $('#gendercode').val(user.gendercode);
                        $('#auditorflag').val(user.auditorflag);
                        $('#userid').val(deptuserid);
                        $('#username').val(user.username);
                        $('#email').val(user.email);
                        $('#deptcode').val(user.deptcode);
                        $('#desigid').val(user.desigcode);
                        $('#ifhrmsno').val(user.ifhrmsno);
                        $('#mobilenumber').val(user.mobilenumber);

                        datepicker('dob', convertDateFormatYmd_ddmmyy(user.dob));
                        datepicker('dor', convertDateFormatYmd_ddmmyy(user.dor));
                        datepicker('doj', convertDateFormatYmd_ddmmyy(user.doj));

                        // Call the function for all elements with the class .form-select
                        updateSelectColorByValue(document.querySelectorAll(".form-select"));

                    } else {
                        alert('User not found');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

        }

    });
</script>
