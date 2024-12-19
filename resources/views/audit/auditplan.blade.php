@extends('index2')
@section('content')
    <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <style>
        .hiddenbtns {
            display: none;
        }

        .card-body {
            padding: 15px 10px;
        }

        .card {
            margin-bottom: 10px;
        }

        .largemodal td {
            padding: 12px;
            /* Adds 10px of padding on all sides of each cell */
            border: 1px solid #ddd;
            /* Optional: Add a border for visibility */
        }



        /*.audittable {
                                                                                        overflow: visible;
                                                                                    }



                                                                                    .audittable {
                                                                                        width: 100%;
                                                                                        table-layout: auto;
                                                                                        overflow: visible;
                                                                                    }*/
    </style>

    @include('common.alert')

    <div class="row">
        <div class="col-12">
            <div class="card" style="border-color: #7198b9">
                <div class="card-header card_header_color">Audit Plan (Institution to Team Mapping)</div>
                <div class="card-body">
                    <form id="create_auditplan" name="create_auditplan">
                        <input type="hidden" name="auditplanid" id="auditplanid" value="" />
                        <input type="hidden" name="finalize" id="finalize" value="Y" />


                        <div class="alert alert-danger alert-dismissible fade show hide_this" role="alert"
                            id="display_error">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="validationDefault01">Department </label>
                                <input type="hidden" value="1" />
                                <input type="hidden" id="hiddendeptonchange" value="1" />
                                <select class="select2 form-select mr-sm-2" name="deptcode" id="deptcode">
                                    <option value="">Select Department</option>
                                    @foreach ($dept as $department)
                                        <option value="{{ $department->deptcode }}">
                                            {{ $department->deptelname }} <!-- Display any field you need -->
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="validationDefault01">Region </label>
                                <input type="hidden" value="1" />
                                <select class="select2 form-select mr-sm-2" name="regioncode" id="regioncode">
                                    <option value="">Select Region</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="validationDefault01">District </label>
                                <input type="hidden" value="1" />
                                <select class="select2 form-select mr-sm-2" name="distcode" id="distcode">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="validationDefault01">Institution Category </label>
                                <select class="select2 form-select mr-sm-2" id="instcatcode" name="instcatcode">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div style="display:none;" class="col-md-4 mb-3 instsubcategorydiv subrow">
                                <label class="form-label required" for="validationDefault01">Institution SubCategory
                                </label>
                                <select class="select2 form-select mr-sm-2" id="instsubcatcode" name="instsubcatcode">
                                    <option value="">Select SubCategory</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="validationDefault01">Institute Name </label>
                                <select id="instcode" class="select2 form-control custom-select" name="instcode">
                                    <option value="">Select Institute Name</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Audit Team </label>
                                <select id="auditteamcode" class="select2 form-control custom-select" name="auditteamcode">
                                    <option value="">Select Audit Team</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label required" for="validationDefaultUsername">Type of Audit</label>
                                <select class="select2 form-select mr-sm-2" name="auditcode" id="auditcode">
                                    <option value="" selected>Select Type of Audit</option>
                                </select>

                            </div>
                            <!--<div class="col-md-2">
                                                                                                            <label class="form-label required"  for="validationDefaultUsername">Audit Plan</label>

                                                                                                            <div style="padding-bottom:5px;" class="form-check">
                                                                                                                <input onChange="AuditOnchange()" class="form-check-input" type="radio" name="auditplanoption" id="option1" value="1" checked>
                                                                                                                <label class="form-check-label" for="option1">
                                                                                                                Annual Audit
                                                                                                                </label>
                                                                                                            </div>
                                                                                                            <div class="form-check">
                                                                                                                <input onChange="AuditOnchange()" class="form-check-input" type="radio" name="auditplanoption" id="option2" value="2">
                                                                                                                <label class="form-check-label" for="option2">
                                                                                                                Quartely Audit
                                                                                                                </label>
                                                                                                            </div>

                                                                                                        </div>-->
                            <!--<div class="col-md-4">
                                    <label class="form-label required" for="validationDefaultUsername">Year</label>
                                    <input type="hidden" name="yearcode" value="01" />
                                    <input type="text" disabled id="yearcode" class="form-control " />

                                </div>-->

                            <div class="col-md-4 ">
                                <label class="form-label required" for="validationDefaultUsername">Audit Year</label>
                                <input type="hidden" name="yearcode" value="1" />
                                <select name="yearselected[]" id="yearcode" class="select2 form-control"
                                    multiple="multiple">
                                    <option value="" disabled>Select Year</option>
                                    <option value="2">2023-2024</option>
                                    <option value="3">2022-2023</option>
                                    <option value="4">2021-2022</option>
                                </select>
                            </div>

                            <div id="quartelydiv" class="col-md-4">
                                <label class="form-label required" for="validationDefaultUsername">In which
                                    Quarter</label>
                                <!-- <input type="hidden" value="03" name="periodcode" />-->
                                <select class="select2 form-select mr-sm-2" name="periodcode" id="periodcode">
                                    <option value="">Select Quarter</option>
                                    <!--<option value="1">Quarter 1 (April 2024 - June 2024)</option>
                                                <option value="2">Quarter 2 (July 2024 - September 2024)</option>
                                                <option value="3">Quarter 3 (October 2024 - December 2024)</option>
                                                        <option value="4" selected >Quarter 4 (January 2025 - March 2025)</option>-->
                                </select>

                            </div>

                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-4 text-center">
                                <input type="submit" name="buttonaction" id="buttonaction" class="btn mt-3 button_save"
                                    value="Save Draft" />
                                <button class="btn btn-success mt-3 button_finalize" id="finalize_button"
                                    type="button">Finalize</button>
                                <button class="btn btn-danger mt-3" id="reset_button" type="button">Clear</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="card" style="border-color: #7198b9">
                <div class="card-header card_header_color">
                    Audit Plan Details
                </div>
                <div class="card-body">

                    <div class="datatables ">
                        <!-- start File export -->
                        <div class="card" style="border-color: #7198b9">
                            <div class="card-body">
                                <div id="datatable" class="table-responsive hide_this">
                                    <table id="file_export"
                                        class="table w-100 table-striped table-bordered display text-nowrap datatables-basic audittable">
                                        <thead>
                                            <!-- start row -->
                                            <tr>
                                                <th>S.No</th>
                                                <th>Department</th>
                                                <th>Region / District</th>
                                                <th>Category</th>
                                                <th>Institute Name</th>
                                                <th>Audit Team </th>
                                                <th>Type of Audit</th>
                                                <th>Audit Year</th>
                                                <th> Quarter </th>
                                                <th> Action</th>


                                            </tr>
                                            <!-- end row -->
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div id='no_data' class='hide_this'>
                                    <center>No Data Available</center>
                                </div>
                            </div>
                        </div>
                        <!-- end Footer callback -->
                    </div>
                </div>
            </div>
        </div>
        </script>
        <script src="../assets/js/datatable/datatable-advanced.init.js"></script>
        <script src="../assets/js/jquery_3.7.1.js"></script>
        <script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/select2/dist/js/select2.full.min.js"></script>
        <script src="../assets/libs/select2/dist/js/select2.min.js"></script>
        <!-- <script src="../assets/js/forms/select2.init.js"></script>-->

        <script>
            //default arrays
            var AuditPeriod = {
                1: 'Quarter 1 (April 2023 - June 2023)',
                2: 'Quarter 2 (July 2023 - September 2023)',
                3: 'Quarter 3 (October 2023 - December 2023)',
                4: 'Quarter 4 (January 2024 - March 2024'
            };

            $(".select2").select2({

                width: '100%',

            });

            $(document).ready(function() {

                /** Data Table**/
                var table = $('.audittable').DataTable({
                    "processing": true,
                    "serverSide": false,
                    "autoWidth": false, // Disable auto-width calculation
                    "scrollX": true, // Enable horizontal scrolling
                    "ajax": {
                        "url": "/audit_plan/fetchAllData", // Your API route for fetching data
                        "type": "POST",
                        "data": function(d) {
                            d._token = $('meta[name="csrf-token"]').attr(
                                'content'); // CSRF token for security
                        },
                        "dataSrc": function(json) {
                            //console.log(json);
                            // Check if there is data
                            if (json.data && json.data.length > 0) {
                                $('#datatable').show();
                                $('#no_data').hide();
                                return json.data;

                            } else {
                                $('#datatable').hide();
                                $('#no_data').show();
                                return [];
                            }
                        }
                    },
                    "columns": [{
                            "data": "Slno"
                        },
                        {
                            "data": "deptname"
                        },
                        {
                            "data": "Reg_Dist"
                        },
                        {
                            "data": "instcatname"
                        },
                        {
                            "data": "instname"
                        },
                        {
                            "data": "auditteamname"
                        },
                        {
                            "data": "typeofaudit"
                        },
                        {
                            "data": "auditperiod"
                        },
                        {
                            "data": "auditquarter"
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                if (row.statusflag == 'F') {
                                    return `<span class="badge bg-success fs-2">Finalized</span>`;

                                } else {
                                    return `<div id="allbtns_${row.encrypted_auditid}" class=" mb-2 mx-auto allbtns" role="group" aria-label="First group">
                                        <button id="edit_user" data-id="${row.encrypted_auditid}"  title="Edit" type="button" class="btn btn-secondary btn-sm">
                                            <i class="ti ti-edit fs-4"></i>
                                        </button>
                                        <button id="delete-btn"  data-id="${row.encrypted_auditid}" type="button" title="Delete" class="btn btn-danger btn-sm">
                                            <i class="ti ti-trash fs-4"></i>
                                        </button>
                                    </div>
                                    <div id="progressbtn_${row.encrypted_auditid}" class=" mb-2 mx-auto hiddenbtns" role="group" aria-label="First group">
                                        <button data-id="${row.encrypted_auditid}"  title="Edit" type="button" class="btn btn-secondary btn-sm fs-2">
                                            Processing
                                        </button>
                                    </div>`;

                                }

                            }
                        }
                    ]
                });


                // Define the reset_form function here within the $(document).ready block
                function reset_form() {
                    $('.error').hide();
                    //validator.resetForm();
                    change_button_as_insert('create_auditplan', 'action', 'buttonaction', 'display_error', '', '');
                    $('.select2').val(null).trigger('change');
                    //$("#yearcode").val("");
                    //$('#periodcode').val(4).trigger('change');
                    $('#yearcode[multiple]').val(' ').trigger('change');
                    // updateSelectColorByValue(document.querySelectorAll(".form-select"));
                }

                // If you have a button or event that calls reset_form, make sure it's hooked up
                // Example usage (when you have a reset button):
                $('#reset_button').on('click', function() {
                    reset_form(); // Call the reset_form function
                });

                const $create_auditplan = $("#create_auditplan");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                /**Validation for form */
                $("#create_auditplan").validate({
                    rules: {
                        deptcode: {
                            required: true,
                        },
                        regioncode: {
                            required: true,
                        },
                        distcode: {
                            required: true,
                        },
                        instcatcode: {
                            required: true,
                        },
                        instsubcatcode: {
                            required: true,
                            //visible: true
                        },
                        instcode: {
                            required: true,
                        },
                        auditteamcode: {
                            required: true,
                        },
                        auditcode: {
                            required: true,
                        },
                        "yearselected[]": {
                            required: true,
                            minlength: 1
                        },
                        periodcode: {
                            required: true,
                        }
                    },
                    messages: {
                        instcatcode: {
                            required: "Select Institution Category",
                        },
                        instsubcatcode: {
                            required: "Select Institution Sub Category",
                        },
                        instcode: {
                            required: "Select Institution Name",
                        },
                        auditteamcode: {
                            required: "Select Audit Name",
                        },
                        auditcode: {
                            required: "Select Type of Audit",
                        },
                        "yearselected[]": {
                            required: "Please select at least one Year",
                            minlength: "Please select at least one year"
                        },
                        periodcode: {
                            required: "Select Audit Period",
                        }

                    },
                    errorPlacement: function(error, element) {
                        // Custom placement of the error message
                        if (element.hasClass("select2")) {
                            // Place the error message near the select2 rendered container
                            error.appendTo(element.siblings('.select2-container').find(
                                '.dropdown-wrapper'));
                        } else {

                            // Default error message placement for regular fields
                            error.insertAfter(element);
                        }

                    },
                    highlight: function(element) {
                        // Highlight the input field (add error class)
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element) {
                        // Remove error class if the validation passes
                        $(element).removeClass('is-invalid');
                    }
                });

                /**Savedraft,update click action */
                $(document).on('click', '#buttonaction', function(event) {
                    event.preventDefault(); // Prevent form submission

                    if ($create_auditplan.valid()) {
                        get_insertdata('insert')
                    } else {
                        scrollToFirstError();
                    }
                });

                /**Finalize Popup Display */
                $('#finalize_button').click(function(e) {
                    e.preventDefault(); // Prevent default button behavior (if it's inside a form)

                    if ($create_auditplan.valid()) {
                        var departname = $('#select2-deptcode-container').html();
                        var region = $('#select2-regioncode-container').html();
                        var district = $('#select2-distcode-container').html();
                        var instcatcode = $('#select2-instcatcode-container').html();
                        var instname = $('#select2-instcode-container').html();
                        var auditteam = $('#select2-auditteamcode-container').html();
                        var typeofaudit = $('#select2-auditcode-container').html();
                        var audit_period = $('#select2-periodcode-container').html();

                        var Years = [];

                        // Loop through each selected item in the Select2 container
                        $('.select2-selection__choice__display').each(function() {
                            Years.push($(this)
                                .text()); // Add the displayed text (selected value) to the array
                        });

                        var instsubcategorydiv = '';
                        if ($('.instsubcategorydiv').is(':visible')) {
                            var instsubcatcode = $('#select2-instsubcatcode-container').html();
                            instsubcategorydiv = '<tr><td><b>Institute Sub Category</b></td><td>' +
                                instsubcatcode + '</td></tr>';
                        } else {}

                        var datacontent =
                            '<table style="width:100;%" class="table table-hover w-100 table-bordered display largemodal"><tbody><tr><td><b>Department</b></td><td>' +
                            departname + '</td></tr><tr><td><b>Region / District</b></td><td>' + region +
                            ' / ' + district + '</td></tr><tr><td><b>Institute Category</b></td><td>' +
                            instcatcode + '</td></tr>' + instsubcategorydiv +
                            '<tr><td><b>Institute Name</b></td><td>' + instname +
                            '</td></tr><tr><td><b>Audit Team</b></td><td>' + auditteam +
                            '</td></tr><tr><td><b>Type Of Audit</b></td><td>' + typeofaudit +
                            '</td></tr><tr><td><b>Year</b></td><td>' + Years +
                            '</td></tr><tr><td><b>Audit Period</b></td><td>' + audit_period +
                            '</td></tr></tbody></table>';

                        passing_large_alert('Confirmation', datacontent, 'large_confirmation_alert',
                            'large_alert_header',
                            'large_alert_body', 'forward_alert');
                        $("#large_modal_process_button").html(" Ok");
                        $("#large_modal_process_button").addClass("button_finalize");
                        $('#large_modal_process_button').removeAttr('data-bs-dismiss');
                    } else {
                        scrollToFirstError();
                    }

                });

                $('#large_modal_process_button').on('click', function() {
                    var confirmation = 'Are you sure to Finalize?';
                    $('#large_confirmation_alert .modal-content').addClass('blurred');

                    passing_alert_value('Confirmation', confirmation, 'confirmation_alert', 'alert_header',
                        'alert_body', 'forward_alert');
                    $('#confirmation_alert').css('z-index', 100000);
                    $("#process_button").html("Ok");

                });

                /**Finalizing Process */
                $('#process_button').on('click', function() {
                    $('#finalize').val('F');
                    $("#large_confirmation_alert").modal("hide");
                    get_insertdata('finalise')


                });

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
                    if (!selectedcolor) selectedcolor = "#3782ce";

                    $(".modal-header").css({
                        "background-color": selectedcolor
                    });
                    $("#" + alert_header_id).html(alert_header);
                    $("#" + alert_body_id).html(alert_body);

                    $("#" + alert_name).modal("show");

                    // #593320
                }

                // Scroll to the first error field (for better UX)
                function scrollToFirstError() {
                    const firstError = $create_auditplan.find('.error:first');
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }
                }

                /**Insert,Update Ajax call for Form Post */
                function get_insertdata(action) {
                    var formData = $('#create_auditplan').serialize();

                    $.ajax({
                        url: '/audit_plan/insert', // For creating a new user or updating an existing one
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            //console.log(response.success);
                            if (response.success) {
                                reset_form();
                                var finalize = $('#finalize').val();
                                if (finalize == 'F') {
                                    var responsefinal = 'Data Finalized Successfully';

                                } else {
                                    var responsefinal = response.success;
                                }
                                passing_alert_value('Confirmation', responsefinal,
                                    'confirmation_alert', 'alert_header', 'alert_body',
                                    'confirmation_alert');

                                table.ajax.reload();
                            } else if (response.error) {
                                passing_alert_value('Alert', response.error, 'confirmation_alert',
                                    'alert_header', 'alert_body', 'confirmation_alert');
                            }
                        },
                        error: function(xhr, status, error) {

                            var response = JSON.parse(xhr.responseText);

                            var errorMessage = response.error ||
                                'An unknown error occurred';

                            // Displaying the error message
                            passing_alert_value('Alert', errorMessage, 'confirmation_alert',
                                'alert_header', 'alert_body', 'confirmation_alert');


                            // Optionally, log the error to console for debugging
                            //console.error('Error details:', xhr, status, error);
                        }
                    });


                }

                /* $(".select2").on("change", function() {
                    if ($(this).valid()) {
                        $(this).siblings('.select2-container').find('.invalid-feedback').hide();
                    }
                });*/

                $('#hiddenbtns').hide();
                $(document).on('click', '#edit_user', function() {
                    // Add more logic here
                    var auditplanid = $(this).data('id');
                    $('.allbtns').show();
                    $('.hiddenbtns').hide();
                    $('#allbtns_' + auditplanid + '').hide();
                    $('#progressbtn_' + auditplanid + '').toggle();
                    //alert('inprogress');

                    // Simulate a processing action (like an AJAX request)
                    setTimeout(function() {
                        //$(".spinner-border-sm").remove();
                        $('#progressbtn_' + auditplanid + '').prop('disabled', true);
                        $('#progressbtn_' + auditplanid + '').addClass('btn-disabled');

                    }, 100000);
                    if (auditplanid) {
                        reset_form();
                        getuserdetail(auditplanid)
                    }
                });

                function getuserdetail(auditplanid) {
                    $.ajax({
                        url: '/audit_plan/fetchUserData', // Your API route to get user details
                        method: 'POST',
                        data: {
                            auditplanid: auditplanid
                        }, // Pass deptuserid in the data object
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // CSRF token for security
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                $('#display_error').hide();
                                //validator.resetForm();
                                change_button_as_update('create_auditplan', 'action', 'buttonaction',
                                    'display_error', '', '');

                                var audit = response.data;
                                var hiddendeptonchange = $('#hiddendeptonchange').val('0');
                                $('#yearcode').val(audit.yearcode).trigger('change');

                                FilterByDept(audit.deptcode, 'edit', audit);
                                regioncode('edit', audit.distcode, audit.regioncode, audit.deptcode);

                                var data = {
                                    deptcode: audit.deptcode,
                                    regioncode: audit.regioncode,
                                    distcode: audit.distcode
                                };
                                districtcode(data, 'edit', audit.catcode, audit.auditteamid);


                                var data11 = {
                                    deptcode: audit.deptcode,
                                    regioncode: audit.regioncode,
                                    distcode: audit.distcode,
                                    instcatcode: audit.catcode
                                };

                                if (audit.subcatid) {
                                    instcode(data11, 'edit', audit.subcatid);
                                    var datasubcat = {
                                        deptcode: audit.deptcode,
                                        regioncode: audit.regioncode,
                                        distcode: audit.distcode,
                                        instcatcode: audit.catcode,
                                        instsubcatcode: audit.subcatid
                                    };
                                    instsubcode(datasubcat, 'edit', audit.instid);
                                    $('.instsubcategorydiv').show();
                                    //$('.subrow').removeClass('col-md-4');
                                    //$('.subrow').addClass('col-md-3');

                                } else {
                                    instcode(data11, 'edit', audit.instid);
                                    $('.instsubcategorydiv').hide();
                                    //$('.subrow').removeClass('col-md-3');
                                    //$('.subrow').addClass('col-md-4');
                                }

                                updateSelectColorByValue(document.querySelectorAll(".form-select"));

                            } else {
                                alert('Audit not found');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });

                }


                $('.audittable').on('click', '#delete-btn', function() {
                    var auditplanid = $(this).data('id');
                    passing_alert_value('Confirmation', 'Are you sure to Delete?', 'confirmation_alert',
                        'alert_header', 'alert_body', 'forward_alert');
                    $("#process_button").html("Yes, Delete");
                    $("#process_button").addClass("button_confirmation");
                    $('#process_button').removeAttr('data-bs-dismiss');
                    $('.button_confirmation').data('auditplanid', auditplanid);

                });

                $(document).on('click', '.button_confirmation', function() {
                    var auditplanid = $(this).data(
                        'auditplanid'); // Retrieve the auditplanid stored on the button

                    // If there's no auditplanid, do nothing
                    if (!auditplanid) return;

                    //confirmation popup and encryption of uniqid
                    $.ajax({
                        url: '/audit_plan/insert', // For creating a new user or updating an existing one
                        type: 'POST',
                        data: {
                            "auditencryptedplanid": auditplanid,
                            "statusflag": 'Y'
                        },
                        success: function(response) {
                            if (response.success) {

                                passing_alert_value('Confirmation', response.success,
                                    'confirmation_alert', 'alert_header', 'alert_body',
                                    'confirmation_alert');
                                table.ajax.reload();
                                //reset_form();
                            }

                        },
                        error: function(xhr, status, error) {

                            var response = JSON.parse(xhr.responseText);

                            var errorMessage = response.error || 'An unknown error occurred';

                            // Displaying the error message
                            passing_alert_value('Alert', errorMessage, 'confirmation_alert',
                                'alert_header', 'alert_body', 'confirmation_alert');

                            // Optionally, log the error to console for debugging
                            //console.error('Error details:', xhr, status, error);
                        }
                    });

                });

                /**For Department Onchange Filter */
                $('#deptcode').on('change', function() {

                    var deptcode = $('#deptcode').val();
                    var hiddendeptonchange = $('#hiddendeptonchange').val();
                    if (hiddendeptonchange == '1') {
                        FilterByDept(deptcode);

                    }
                });

                /**Start Region Onchange Filter */
                $('#regioncode').on('change', function() {
                    var hiddendeptonchange = $('#hiddendeptonchange').val();

                    if (hiddendeptonchange == '1') {
                        regioncode();

                    }

                });

                function regioncode(editval = '', valuesget = '', regcode = '', deptcode = '') {
                    if (regcode && deptcode) {
                        var regioncode = regcode;
                        var deptcode = deptcode;

                    } else {
                        var regioncode = $('#regioncode').val();
                        var deptcode = $('#deptcode').val();

                    }

                    $.ajax({
                        url: '/audit_plan/FilterByDept', // Your API route to get user details
                        method: 'POST',
                        data: {
                            regioncode: regioncode,
                            deptcode: deptcode
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // CSRF token for security
                        },
                        success: function(response) {
                            $('#hiddendeptonchange').val(0);

                            if (regioncode !== '') {
                                DropdownValuePrint('distcode', 'Select District', response);
                                DropdownValuePrint('instcatcode', 'Select Institute Category');
                                DropdownValuePrint('instcode', 'Select Institute Name');
                                DropdownValuePrint('auditteamcode', 'Select Audit Team');

                            }

                            if (editval == 'edit') {
                                $('#distcode').val(valuesget).trigger('change');
                            }
                            $('#hiddendeptonchange').val(1);

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });

                }
                /**End Region Onchange Filter */

                /**Start District Onchange Filter */
                $('#distcode').on('change', function() {
                    var deptcode = $('#deptcode').val();
                    var regioncode = $('#regioncode').val();
                    var distcode = $('#distcode').val();

                    var data = {
                        deptcode: deptcode,
                        regioncode: regioncode,
                        distcode: distcode
                    };


                    var hiddendeptonchange = $('#hiddendeptonchange').val();
                    if (hiddendeptonchange == '1') {
                        districtcode(data);

                    }

                });

                function districtcode(formdata, editval = '', valuesget = '', auditteamid = '') {
                    $.ajax({
                        url: '/audit_plan/FilterByDept', // Your API route to get user details
                        method: 'POST',
                        data: formdata,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // CSRF token for security
                        },
                        success: function(response) {
                            $('#hiddendeptonchange').val(0);
                            var data = response.split('~');
                            DropdownValuePrint('instcatcode', 'Select Institute Category', data[0]);
                            DropdownValuePrint('instcode', 'Select Institute Name');
                            DropdownValuePrint('auditteamcode', 'Select Audit Team', data[1]);
                            if (editval == 'edit') {
                                $('#instcatcode').val(valuesget).trigger('change');
                                $('#auditteamcode').val(auditteamid).trigger('change');
                            }
                            $('#hiddendeptonchange').val(1);

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
                /**End District Onchange Filter */

                /**Start Institute Onchange Filter */
                $('#instcatcode').on('change', function() {
                    var deptcode = $('#deptcode').val();
                    var regioncode = $('#regioncode').val();
                    var distcode = $('#distcode').val();
                    var instcatcode = $('#instcatcode').val();

                    var data = {
                        deptcode: deptcode,
                        regioncode: regioncode,
                        distcode: distcode,
                        instcatcode: instcatcode
                    };


                    var hiddendeptonchange = $('#hiddendeptonchange').val();
                    if (hiddendeptonchange == '1') {
                        instcode(data);
                    }
                });

                function instcode(formdata, editval = '', valuesget = '') {
                    $.ajax({
                        url: '/audit_plan/FilterByDept', // Your API route to get user details
                        method: 'POST',
                        data: formdata,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // CSRF token for security
                        },
                        success: function(response) {
                            $('#hiddendeptonchange').val(0);
                            var data = response.split('~~');
                            if (data[0] == 'subcategory') {
                                $('.instsubcategorydiv').show();
                                //  $('.subrow').removeClass('col-md-4');
                                //  $('.subrow').addClass('col-md-3');
                                DropdownValuePrint('instcode', 'Select Institute Name');
                                DropdownValuePrint('instsubcatcode', 'Select Institute Subcategory', data[
                                    1]);
                                if (editval == 'edit') {
                                    $('#instsubcatcode').val(valuesget).trigger('change');
                                }

                            } else {
                                $('.instsubcategorydiv').hide();
                                //$('.subrow').removeClass('col-md-3');
                                // $('.subrow').addClass('col-md-4');
                                DropdownValuePrint('instcode', 'Select Institute Name', data[1]);
                                if (editval == 'edit') {
                                    $('#instcode').val(valuesget).trigger('change');
                                }

                            }
                            $('#hiddendeptonchange').val(1);

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
                /**End Institute Onchange Filter */

                /**Start Institute Subcategory Onchange Filter */
                $('#instsubcatcode').on('change', function() {
                    var deptcode = $('#deptcode').val();
                    var regioncode = $('#regioncode').val();
                    var distcode = $('#distcode').val();
                    var instcatcode = $('#instcatcode').val();
                    var instsubcatcode = $('#instsubcatcode').val();


                    var data = {
                        deptcode: deptcode,
                        regioncode: regioncode,
                        distcode: distcode,
                        instcatcode: instcatcode,
                        instsubcatcode: instsubcatcode
                    };


                    var hiddendeptonchange = $('#hiddendeptonchange').val();
                    if (hiddendeptonchange == '1') {
                        instsubcode(data);
                    }
                });

                function instsubcode(formdata, editval = '', valuesget = '') {
                    $.ajax({
                        url: '/audit_plan/FilterByDept', // Your API route to get user details
                        method: 'POST',
                        data: formdata,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // CSRF token for security
                        },
                        success: function(response) {
                            $('#hiddendeptonchange').val(0);
                            if ($('.instsubcategorydiv').is(':visible')) {
                                DropdownValuePrint('instcode', 'Select Institute Name', response);
                            }
                            if (editval == 'edit') {
                                $('#instcode').val(valuesget).trigger('change');
                            }

                            $('#hiddendeptonchange').val(1);

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
                /**End Institute Subcategory Onchange Filter */

                /**Set values for dropdown while editing the form */
                function setvalues(audit) {
                    $('.form-select').select2();
                    $('#auditplanid').val(audit.auditplanid).trigger('change');
                    $('#deptcode').val(audit.deptcode).trigger('change');
                    $('#regioncode').val(audit.regioncode).trigger('change');
                    $('#auditteamcode').val(audit.auditteamid).trigger('change');
                    $('#auditcode').val(audit.typeofauditcode).trigger('change');
                    $('#periodcode').val(audit.auditquartercode).trigger('change');
                    var hiddendeptonchange = $('#hiddendeptonchange').val('1');
                }

                /**Filter for Depatment,Region,District etc...**/
                function FilterByDept(deptcode, editval = '', valuesget = '') {
                    $('.instsubcategorydiv').hide();
                    $.ajax({
                        url: '/audit_plan/FilterByDept', // Your API route to get user details
                        method: 'POST',
                        data: {
                            deptcode: deptcode
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // CSRF token for security
                        },
                        success: function(response) {
                            var data = response.split('~');
                            console.log(data);
                            if (deptcode !== '') {
                                DropdownValuePrint('regioncode', 'Select Region', data[0], editval);
                                DropdownValuePrint('distcode', 'Select District');
                                DropdownValuePrint('instcatcode', 'Select Institute Category');
                                DropdownValuePrint('instcode', 'Select Institute Name');
                                DropdownValuePrint('auditteamcode', 'Select Audit Team');
                                DropdownValuePrint('auditcode', 'Select Type Of Audit', data[3], editval);
                                DropdownValuePrint('periodcode', 'Select Audit period', data[2], editval);

                                //$('#yearcode').val(data[1]);

                            }

                            if (editval == 'edit') {
                                setvalues(valuesget);

                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });

                }

                /**Dropdown from filter values display */
                function DropdownValuePrint(dynid, placeholder, resarr, editval = '') {
                    $('#' + dynid + '').empty();
                    // Add a placeholder option (optional)
                    $('#' + dynid + '').append('<option value="">' + placeholder + '</option>');


                    if ($.isEmptyObject(resarr)) {} else {
                        var parsedData = JSON.parse(resarr);
                        // Loop through response data and append options
                        $.each(parsedData, function(TeamId, TeamName) {
                            /* if (dynid == 'periodcode') {
                                 if (TeamId == 3) {
                                     $('#' + dynid).append('<option selected value="' + TeamId + '">' +
                                         TeamName + '</option>');
                                 } else {
                                     $('#' + dynid).append('<option value="' + TeamId + '">' + TeamName +
                                         '</option>');
                                 }
                             } else {*/
                            $('#' + dynid).append('<option value="' + TeamId + '">' + TeamName +
                                '</option>');
                            /* }*/

                        });
                    }
                }

            });
        </script>
    @endsection
