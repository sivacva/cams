@section('content')
    @extends('index2')
    @include('common.alert')
    <style>
        .card_seperator {
            height: 10px;
            border: 0;
            box-shadow: 0 10px 10px -10px #8c8b8b inset;
        }

        .card-title {
            font-size: 15px;
        }

        .title-part-padding {
            background-color: #e3efff;
        }

        .card-body {
            padding: 15px 10px;
        }

        .card {
            margin-bottom: 10px;
        }

        .dataTables_info {
            margin-bottom: 1rem !important;
        }
    </style>
    <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

    <div class="row">
        <div class="col-12">
            <!-- <div class="repeater-default">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div data-repeater-list="">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div data-repeater-item=""> -->
            <div class="card card_border" style="border-color: #7198b9">

                <div class="card-header card_header_color">
                    Audit Schedule Details
                </div>

                <div class="card-body collapse show">
                    <form id="audit_schedule" name="audit_schedule">
                        <div class="alert alert-danger alert-dismissible fade show hide_this" role="alert"
                            id="display_error">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @csrf
                        <input type="hidden" name="audit_scheduleid" id="audit_scheduleid" value="" />
                        <input type="hidden" name="as_code" id="as_code" value="" />
                        <input type="hidden" name="ap_code" id="ap_code"
                            value="{{ $inst->first()->auditplanid ?? '' }}" />

                        <div class="card" style="border-color: #7198b9">
                            {{-- <div class="border-bottom title-part-padding">
                                <h4 class="card-title mb-0">Institute</h4>
                            </div> --}}

                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-4 mb-1">
                                        <label class="form-label required" for="validationDefault01">Instituition </label>
                                        <input type="hidden" id="inst_code" name="inst_code"
                                            value={{ $inst->first()->auditeeinstitutionid ?? '' }}>
                                        <select class="form-select mr-sm-2" id="inst_name" name="inst_name" disabled>

                                            @foreach ($inst as $institution)
                                                <option value="{{ $institution->auditeeinstitutionid }}"
                                                    data-instename="{{ $institution->instename }}">
                                                    {{ $institution->instename }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-2 mb-1">
                                        <label class="form-label required" for="validationDefault01">Total Mandays </label>
                                        <input type="text" class="form-control" id="total_mandays" name="total_mandays"
                                            placeholder="Total Mandays " value={{ $inst->first()->mandays ?? '' }} required
                                            disabled />
                                    </div> --}}
                                    <div class="col-md-4 mb-1">
                                        <label class="form-label required" for="validationDefault01">Total Team Size
                                        </label>
                                        <input type="text" class="form-control" id="total_teamsize" name="total_teamsize"
                                            placeholder="Total Team Size"
                                            value="{{ $inst->first()->team_member_count ?? '0' }}" required disabled />

                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label required" for="validationDefault01">Team Head </label>
                                        <input type="hidden" class="form-control" value={{ $inst->first()->userid ?? '' }}
                                            id="th_uid" name="th_uid" />
                                        <select class="form-select mr-sm-2" id="th_uid_name" name="th_uid_name" disabled>

                                            @foreach ($inst as $institution)
                                                <option value="{{ $institution->userid }}">
                                                    {{ $institution->username }} -
                                                    {{ $institution->desigelname }}
                                                </option>
                                            @endforeach



                                        </select>




                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-4 ">
                                        <label class="form-label required" for="validationDefault01">Team Member </label>
                                        <select class="select2 form-control custom-select" multiple="multiple"
                                            id="tm_uid" name="tm_uid[]" aria-placeholder="Select Member">
                                            {{-- @foreach ($inst as $teammember)
                                                <option value="{{ $teammember->teamMember }}">
                                        {{ $teammember->teammemberName }} -
                                        {{ $teammember->chargedescription }}

                                        </option>
                                        @endforeach --}}

                                        </select>


                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label required" for="validationDefault02">RC. No</label>
                                        <input type="text" class="form-control" placeholder="Enter R.C No" id="rc_no"
                                            name="rc_no" />
                                    </div>
                                    <div class="col-md-2 mb-1">
                                        <label class="form-label required" for="validationDefault02">From date</label>
                                        <div class="input-group" onclick="datepicker('from_date','')">
                                            <input type="text" class="form-control datepicker" id="from_date"
                                                name="from_date" placeholder="dd/mm/yyyy" />
                                            <span class="input-group-text">
                                                <i class="ti ti-calendar fs-5"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-1">
                                        <label class="form-label required" for="validationDefault02"> To date</label>
                                        <div class="input-group" onclick="datepicker('to_date','')">
                                            <input type="text" class="form-control datepicker" id="to_date"
                                                name="to_date" placeholder="dd/mm/yyyy" />
                                            <span class="input-group-text">
                                                <i class="ti ti-calendar fs-5"></i>
                                            </span>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>


                        <div class="row justify-content-center">
                            <div class="col-md-3 mx-auto">
                                <input type="hidden" name="action" id="action" value="insert" />
                                <button class="btn button_save mt-3" type="submit" action="insert" id="buttonaction"
                                    name="buttonaction">Save Draft</button>
                                <button class="btn bg-success button_finalise mt-3" type="submit" id="finalisebtn"
                                    action ="finalise">
                                    Finalize
                                </button>
                                <button type="button" class="btn btn-danger mt-3" id="reset_button">Clear</button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
    <div class="card " style="border-color: #7198b9">
        <div class="card-header card_header_color">Audit Schedule Details</div>
        <div class="card-body">
            <div class="datatables">
                <div class="table-responsive hide_this" id="tableshow">
                    <table id="scheduletable"
                        class="table w-100 table-striped table-bordered display text-nowrap datatables-basic">
                        <thead>
                            <tr>
                                <th class="lang" key="s_no">S.No</th>
                                <th>Institute</th>
                                <th>Team Members</th>
                                {{-- <th>Mandays</th> --}}
                                <th>Team Size</th>
                                <th>RC Number</th>
                                <th>Period</th>

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
    <script src="../assets/js/vendor.min.js"></script>
    <script src="../assets/js/jquery_3.7.1.js"></script>
    <script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>

    <script src="../assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <script src="../assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="../assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="../assets/js/forms/select2.init.js"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <!-- <script src="../assets/libs/prismjs/prism.js"></script> -->
    <!-- <script src="../assets/js/widget/ui-card-init.js"></script> -->
    <script src="../assets/js/plugins/toastr-init.js"></script>

    {{-- data table --}}
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script src="../assets/js/datatable/datatable-advanced.init.js"></script>


    <script>
        $(document).ready(function() {
            // Initialize 'from_date' datepicker
            $('#from_date').datepicker({
                format: 'dd/mm/yyyy',
                daysOfWeekDisabled: [0, 6], // Disable Sundays (0) and Saturdays (6)
                startDate: new Date(), // Minimum date is today
                autoclose: true
            });

            // Initialize 'to_date' datepicker with the default start date as today + 11 days
            $('#to_date').datepicker({
                format: 'dd/mm/yyyy',
                daysOfWeekDisabled: [0, 6], // Disable Sundays (0) and Saturdays (6)
                startDate: new Date(), // Minimum date is today
                autoclose: true
            });

            // Update 'to_date' minDate when 'from_date' changes
            $('#from_date').on('changeDate', function() {
                var fromDate = $('#from_date').datepicker('getDate');
                if (fromDate) {
                    // Add 11 days to the selected 'from_date'
                    fromDate.setDate(fromDate.getDate() + 1);

                    // Update 'to_date' minDate
                    $('#to_date').datepicker('setStartDate', fromDate);

                    // If the selected from_date is before the required minDate for to_date, clear to_date
                    var toDate = $('#to_date').datepicker('getDate');
                    if (toDate && toDate < fromDate) {
                        $('#to_date').datepicker('clearDates');
                    }
                }
            });

            // Update 'from_date' minDate when 'to_date' changes
            $('#to_date').on('changeDate', function() {
                var toDate = $('#to_date').datepicker('getDate');
                if (toDate) {
                    // Add 11 days to the selected 'to_date'
                    toDate.setDate(toDate.getDate() - 1);

                    // Update 'from_date' maxDate
                    $('#from_date').datepicker('setEndDate', toDate);

                    // If the selected to_date is before the required minDate for from_date, clear from_date
                    var fromDate = $('#from_date').datepicker('getDate');
                    if (fromDate && fromDate > toDate) {
                        $('#from_date').datepicker('clearDates');
                    }
                }
            });
        });

        function datepicker(value, setdate) {
            var today = new Date();
            if (value == 'from_date') {
                // Calculate the minimum date (18 years ago)
                var maxDate = new Date(today);
                maxDate.setMonth(today.getMonth() + 4);

                // Calculate the maximum date (60 years ago)
                var minDate = today;

            }
            if (value == 'to_date') {
                var maxDate = new Date(today);
                maxDate.setMonth(today.getMonth() + 4);

                // Calculate the maximum date (60 years ago)
                var minDate = today;
            }

            // Format the dates to dd/mm/yyyy format
            var minDateString = formatDate(minDate); // Format date to dd/mm/yyyy
            var maxDateString = formatDate(maxDate); // Format date to dd/mm/yyyy

            init_datepicker(value, minDateString, maxDateString, setdate)
        }


        var room = 1;

        function education_fields(cardCounter) {

            // alert(room);
            var id = "team_size_" + cardCounter;
            var size = $('#' + id).val();

            if (!size) {
                toastr.error("Please select the team size !", "", {
                    closeButton: true,
                });
                exit;
            } else {

                if (room < size) {

                    room++;
                    var objTo = document.getElementById("education_fields_" + cardCounter);
                    var divtest = document.createElement("div");
                    divtest.setAttribute("class", "mb-3 removeclass" + room);
                    var rdiv = "removeclass" + room;
                    divtest.innerHTML =
                        '<form class="row"><div class="col-md-4"><label class="form-label" for="validationDefault01">Team Member </label><select class="form-select mr-sm-2" id="designation"><option>Select Member</option><option value="1">Siva</option><option value="2">Swathi</option><option value="3">Niji </option></select></div><div class="col-md-3"><div class="mb-3"><label class="form-label" for="validationDefault02">From date</label><input type="date" class="form-control" value="2018-05-13" id="dob"name="dob" /></div></div><div class="col-md-3"><div class="mb-3"><label class="form-label" for="validationDefault02">To date</label><input type="date" class="form-control" value="2018-05-13" id="dob"name="dob" /></div></div><div class="col-sm-2 mt-4"><div class="mb-3"><label class="form-label" for="validationDefault02"></label><button class="btn btn-danger" type="button" onclick="remove_education_fields(' +
                        room +
                        ');"> <i class="ti ti-minus"></i> </button> </div></div></form>';

                    objTo.appendChild(divtest);
                } else {
                    toastr.error("Reached the maximum member list of " + size + "", "", {
                        closeButton: true,
                    });
                }
            }

        }

        function remove_education_fields(rid) {
            // Remove the specified row
            $(".removeclass" + rid).remove();
            room--;

            // Reassign classes and update attributes for all remaining rows
            const rows = document.querySelectorAll("[class^='removeclass']");

            rows.forEach((row, index) => {
                // Calculate the new index
                const newIndex = index + 1;

                // Update the class name to reflect the new order
                const oldClass = row.className.match(/removeclass\d+/)[0];
                row.className = row.className.replace(oldClass, `removeclass${newIndex}`);

                // Update the button `onclick` function
                const button = row.querySelector("button[onclick]");
                if (button) {
                    button.setAttribute("onclick", `remove_education_fields(${newIndex});`);
                }
            });
        }
        list = 1;

        function listofObjections_field(cardCounter) {
            // Check if the list variable is defined, else initialize it
            if (typeof list === 'undefined') {
                list = 0;
            }

            list++;
            var objTo = document.getElementById("listofObjections_" + cardCounter);
            var divtest = document.createElement("div");
            divtest.setAttribute("class", "mb-3 removeObjclass" + list);
            var rdiv = "removeObjclass" + list;

            // Dynamically add the form row
            divtest.innerHTML =
                '<form class="row"><div class="col-md-4 ">' +
                '<select class="select2 form-control custom-select dynamic-select-' + list + '">' +
                '<option>Select Category</option>' +
                '<option value="CA">Rent </option>' +
                '<option value="NV">Hundial </option>' +
                '<option value="OR">Category 3</option>' +
                '<option value="WA">Category 4</option>' +
                '</select></div>' +
                '<div class="col-md-5 ">' +
                '<select class="select2 form-control dynamic-select-' + list + '" multiple="multiple" >' +
                '<option>Select Sub Category</option>' +
                '<option value="M">Deposit not collected</option>' +
                '<option value="F">Hundial amount not fully deposited in bank</option>' +
                '<option value="T">Hundial theft</option>' +
                '<option value="T">Sub Category 4</option>' +
                '</select></div>' +
                '<div class="col-sm-2 "><div class="">' +
                '<button class="btn btn-danger" type="button" onclick="remove_Objection_fields(' + list + ');">' +
                '<i class="ti ti-minus"></i></button></div></div></form>';

            objTo.appendChild(divtest);

            // Initialize Select2 for the dynamically added elements
            $('.dynamic-select-' + list).select2();
        }


        function remove_Objection_fields(rid) {

            $(".removeObjclass" + rid).remove();
            list--;
        }

        $(function() {
            "use strict";

            // Default
            $(".repeater-default").repeater();

            // Custom Show / Hide Configurations
            $(".file-repeater, .email-repeater").repeater({
                show: function() {
                    $(this).slideDown();
                },
                hide: function(remove) {
                    if (confirm("Are you sure you want to remove this item?")) {
                        $(this).slideUp(remove);
                    }
                },
            });
        });

        function show_others(cardnumber) {
            var id = 'particulars_' + cardnumber;

            var element = document.getElementById(id);
            var isChecked = document.getElementById(id).checked;

            if (isChecked == false) {


                element.checked = true;
                $('#particulars_div_' + cardnumber).show();
            } else {
                if (isChecked == true) {

                    element.checked = false;
                    $('#particulars_div_' + cardnumber).hide();
                }
            }

        }

        function show_date(cardnumber, type) {
            // alert(type);
            if (type == "select") {
                $('.selectDate').show();
                $('.rangeDate').hide();
                $('.add_btn').show();

            } else {
                $('.rangeDate').show();
                $('.selectDate').hide();
                $('.add_btn').show();
            }


        }
        /***********************************Jquery Form Validation **********************************************/

        const $audit_scheduleForm = $("#audit_schedule");

        // Validation rules and messages
        $audit_scheduleForm.validate({
            rules: {
                inst_code: {
                    required: true,
                },
                from_date: {
                    required: true,
                },
                to_date: {
                    required: true,
                },
                "tm_uid[]": {
                    required: true,
                },
                rc_no: {
                    required: true,
                },


            },
            errorPlacement: function(error, element) {
                // For datepicker fields inside input-group, place error below the input group
                if (element.hasClass('datepicker')) {
                    // Insert the error message after the input-group, so it appears below the input and icon
                    error.insertAfter(element.closest('.input-group'));
                } else {
                    // For other elements, insert the error after the element itself
                    error.insertAfter(element);
                }

            },

            messages: {
                inst_code: {
                    required: "Select Institute ",
                },
                from_date: {
                    required: "Select From Date ",
                },
                to_date: {
                    required: "Select  To Date",
                },
                "tm_uid[]": {
                    required: "Select Team Member",
                },
                rc_no: {
                    required: "Enter RC Number",
                }

                // highlight: function(element, errorClass) {
                //     $(element).removeClass(errorClass); //prevent class to be added to selects
                // },

            }
        });




        // Scroll to the first error field (for better UX)
        function scrollToFirstError() {
            const firstError = $auditteamForm.find('.error:first');
            if (firstError.length) {
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
            }
        }
        /***********************************Jquery Form Validation **********************************************/
        function reset_form() {

            $('#display_error').hide();
            var validator = $("#audit_schedule").validate();
            validator.resetForm();
            $("#tm_uid").empty();
            fetch_audit_memberdata();
            fetchAlldata();
            change_button_as_insert('audit_schedule', 'action', 'buttonaction', 'display_error', '', '');
            updateSelectColorByValue(document.querySelectorAll(".form-select"));
        }
        /***********************************Submission Button Function**********************************************/
        $(document).on('click', '#buttonaction', function(event) {
            event.preventDefault(); // Prevent form submission

            if ($audit_scheduleForm.valid()) {
                get_insertdata('insert')
            } else {
                scrollToFirstError();
            }
        });

        $(document).on('click', '#finalisebtn', function() {
            // Prevent form submission (this stops the page from refreshing)
            event.preventDefault();
            //Trigger the form validation
            if ($("#audit_schedule").valid()) {
                var inst_name = $('#inst_name option:selected').text();
                //var total_mandays = $('#total_mandays').val();
                var total_teamsize = $('#total_teamsize').val();
                var th_uid_name = $('#th_uid_name option:selected').text();
                var rcno = $('#rc_no').val();
                var fromdate = $('#from_date').val();
                var todate = $('#to_date').val();
                // alert(total_teamsize);
                var selectedValues = [];

                // Loop through each selected item in the Select2 container
                $('.select2-selection__rendered .select2-selection__choice__display').each(function() {
                    selectedValues.push($(this)
                        .text()); // Add the displayed text (selected value) to the array
                });

                //accountparticualrs
                var Accountparticulars = @json($Accountparticulars);

                // console.log(Accountparticulars);

                // var datacontent =
                //     '<div class="card" style="border-color: #7198b9"><div class="card-header card_header_color">Audit Scheduling Details</div><div class="card-body"><table style="width:100%;" class="table  table-hover w-100 table-bordered display largemodal"><tbody><tr><td><b>Institution</b></td><td>' +
                //     inst_name + '</td></tr><tr><tr><td><b>Total Mandays</b></td><td>' + total_mandays +
                //     '</td></tr><tr><td><b>Total Team Size</b></td><td>' +
                //     total_teamsize + '</td></tr><tr><td><b>Team Head</b></td><td>' +
                //     th_uid_name + '</td></tr><tr><td><b>Team Members</b></td><td>' +
                //     selectedValues + '</td></tr><tr><td><b>RC.No</b></td><td>' +
                //     rcno + '</td></tr><td><b>From Date</b></td><td>' +
                //     fromdate + '</td></tr><td><b>To Date</b></td><td>' +
                //     todate +
                //     '</td></tr></tbody></table></div></div><div class="card" style="border-color: #7198b9"><div class="card-header card_header_color">Account Particulars</div><div class="card-body"><table style="width:100%;" class="table  table-hover w-100 table-bordered display largemodal accountparticulars"><tbody><tr><td width="30%" rowspan="' +
                //     Accountparticulars.original.account_particulars.length +
                //     '" ><b>Account Particulars Name</b></td><td class="tdforaccountparticular"></td></tr></tbody></table></div></div><div class="card" style="border-color: #7198b9"><div class="card-header card_header_color">Call for Records</div><div class="card-body"><table style="width:100%;" class="table  table-hover w-100 table-bordered display largemodal callforrecords"><tbody class="tbodycallforrecords"></tbody></table></div></div>';

                var datacontent =
                '<div class="card" style="border-color: #7198b9"><div class="card-header card_header_color">Audit Scheduling Details</div><div class="card-body"><table style="width:100%;" class="table  table-hover w-100 table-bordered display largemodal"><tbody><tr><td><b>Institution</b></td><td>' +
                inst_name + '</td></tr><tr><td><b>Total Team Size</b></td><td>' +
                total_teamsize + '</td></tr><tr><td><b>Team Head</b></td><td>' +
                th_uid_name + '</td></tr><tr><td><b>Team Members</b></td><td>' +
                selectedValues + '</td></tr><tr><td><b>RC.No</b></td><td>' +
                rcno + '</td></tr><td><b>From Date</b></td><td>' +
                fromdate + '</td></tr><td><b>To Date</b></td><td>' +
                todate +
                '</td></tr></tbody></table></div></div><div class="card" style="border-color: #7198b9"><div class="card-header card_header_color">Account Particulars</div><div class="card-body"><table style="width:100%;" class="table  table-hover w-100 table-bordered display largemodal accountparticulars"><tbody><tr><td width="30%" rowspan="' +
                Accountparticulars.original.account_particulars.length +
                '" ><b>Account Particulars Name</b></td><td class="tdforaccountparticular"></td></tr></tbody></table></div></div><div class="card" style="border-color: #7198b9"><div class="card-header card_header_color">Call for Records</div><div class="card-body"><table style="width:100%;" class="table  table-hover w-100 table-bordered display largemodal callforrecords"><tbody class="tbodycallforrecords"></tbody></table></div></div>';

                //$("#large_confirmation_alert").modal("show");

                $('#large_confirmation_alert .container').html(datacontent);

                // Loop through the data and append rows to the table
                $.each(Accountparticulars.original.account_particulars, function(index, item) {

                    var row = '' + item.accountparticularsename + '<br>';
                    // Append the row to the table body
                    $('.accountparticulars .tdforaccountparticular').append(row);
                });


                var previousMajorType = ''; // Store the previous major work allocation type
                var rowspanCount = 1; // Track how many rows for the current major type

                // Loop through the data and build the table dynamically
                $.each(Accountparticulars.original.data, function(index, row) {
                    var currentMajorType = row.majorworkallocationtypeename; // Get the current major type
                    var currentSubType = row.subworkallocationtypeename; // Get the current sub type

                    // Check if the current major type is the same as the previous one
                    if (currentMajorType === previousMajorType) {
                        // If the same, add the sub type in a comma-separated list
                        var lastRow = $('.callforrecords .tbodycallforrecords tr').last();
                        var lastSubTypeCell = lastRow.find('td').eq(1); // Get the second cell (subtype)
                        var existingSubTypes = lastSubTypeCell.text().split(
                            ', '); // Split existing subtypes by commas
                        existingSubTypes.push(currentSubType); // Add the new subtype
                        lastSubTypeCell.text(existingSubTypes.join(', ')); // Join the subtypes with commas
                    } else {
                        // If it's different, apply rowspan to the previous major type's first occurrence
                        if (previousMajorType !== '') {
                            $('.callforrecords .tbodycallforrecords tr').each(function() {
                                if ($(this).find('td').first().text() === previousMajorType) {
                                    $(this).find('td').first().attr('rowspan',
                                        rowspanCount); // Set the calculated rowspan
                                }
                            });
                        }

                        // Reset the count for the new group
                        previousMajorType = currentMajorType; // Update the previous major type
                        rowspanCount = 1; // Reset the rowspan count for the new group

                        // Add the first row of the new group with rowspan set
                        var newRow = $('<tr>').append(
                            $('<td style="font-weight: bold;width:30%;">').text(currentMajorType).attr(
                                'rowspan', 2), // Add major type with rowspan
                            $('<td>').text(currentSubType) // Add the sub type
                        );
                        $('.callforrecords .tbodycallforrecords').append(newRow);
                    }
                });

                // Apply rowspan for the last group
                if (previousMajorType !== '') {
                    $('.callforrecords .tbodycallforrecords tr').each(function() {
                        if ($(this).find('td').first().text() === previousMajorType) {
                            $(this).find('td').first().attr('rowspan',
                                rowspanCount); // Apply rowspan to the last occurrence
                        }
                    });
                }

                passing_large_alert('Send Intimation', datacontent, 'large_confirmation_alert',
                    'large_alert_header',
                    'large_alert_body', 'forward_alert');
                $("#large_modal_process_button").html("Send Intimation");
                $("#large_modal_process_button").addClass("button_finalize");
                $('#large_modal_process_button').removeAttr('data-bs-dismiss');


            } else {
                // If the form is not valid, show an alert
                // alert("Form is not valid. Please fix the errors.");
            }
        });

        $('#large_modal_process_button').on('click', function() {
            var confirmation = 'Are you sure to send intimation?';
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



        $('#reset_button').on('click', function() {
            reset_form(); // Call the reset_form function
        });
        /***********************************Submission Button Function**********************************************/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /*********************************** Insert,update,Finalise,Reset **********************************************/
        function get_insertdata(action) {


            var formData = $('#audit_schedule').serializeArray();



            if (action === 'finalise') {
                finaliseflag = 'F';
            } else if (action === 'insert') {
                finaliseflag = 'Y';
            }

            // Push the finaliseflag to the formData array
            formData.push({
                name: 'finaliseflag',
                value: finaliseflag
            });


            $.ajax({
                url: '/audit/storeOrUpdate', // For creating a new user or updating an existing one
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {

                        passing_alert_value('Confirmation', response.success,
                            'confirmation_alert', 'alert_header', 'alert_body',
                            'confirmation_alert');
                        // fetchAlldata();
                        reset_form();
                        table.ajax.reload(); // Reload the table


                    } else if (response.error) {}
                },
                error: function(xhr, status, error) {

                    var response = JSON.parse(xhr.responseText);

                    var errorMessage = response.error ||
                        'An unknown error occurred';

                    passing_alert_value('Alert', errorMessage, 'confirmation_alert',
                        'alert_header', 'alert_body', 'confirmation_alert');


                    // Optionally, log the error to console for debugging
                    console.error('Error details:', xhr, status, error);
                }
            });
        }


        /*********************************** Insert,update,Finalise,Reset **********************************************/

        function fetchAlldata() {
            if ($.fn.dataTable.isDataTable('#scheduletable')) {
                $('#scheduletable').DataTable().clear().destroy();
            }
            var table = $('#scheduletable').DataTable({
                "processing": true,
                "serverSide": false,
                "lengthChange": false,
                "ajax": {
                    "url": "/audit/fetchAllScheduleData", // Your API route for fetching data
                    "type": "POST",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Pass CSRF token in headers
                    },
                    "dataSrc": function(json) {

                        if (json.data && json.data.length > 0) {
                            $('#tableshow').show();
                            $('#scheduletable_wrapper').show();
                            $('#no_data').hide(); // Hide custom "No Data" message
                            return json.data;
                        } else {
                            $('#tableshow').hide();
                            $('#scheduletable_wrapper').hide();
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
                        "data": "instename"
                    },
                    {
                        "data": "teammembers"
                    },

                    // {
                    //     "data": "mandays"
                    // },
                    {
                        "data": "team_member_count"
                    },
                    {
                        "data": "rcno"
                    },
                    {
                        "data": "null",
                        "render": function(data, type, row) {
                            // Convert DOB to dd-mm-yyyy format
                            let fromdate = row.fromdate ? new Date(row.fromdate).toLocaleDateString(
                                    'en-GB') :
                                "N/A";
                            let todate = row.todate ? new Date(row.todate).toLocaleDateString(
                                    'en-GB') :
                                "N/A";

                            return ` ${fromdate} - ${todate}`;
                        }
                    },
                    {
                        "data": "encrypted_auditscheduleid", // Use the encrypted deptuserid
                        "render": function(data, type, row) {
                            if (row.statusflag === 'Y') {
                                // Check if statusflag is 'N'
                                return `<center>
                        <a class="btn editicon edit_btn" id="${data}">
                            <i class="ti ti-edit fs-4"></i>
                        </a>
                    </center>`;
                            } else {
                                // Otherwise, show the Finalize button
                                return `<center>
                        <button class="btn btn-primary finalize_btn" id="${data}">
                            Finalized
                        </button>
                    </center>`;
                            }
                        }
                    }
                ]
            });
        }

        $(document).on('click', '.edit_btn', function() {
            // Add more logic here
            // alert();
            var id = $(this).attr('id'); //Getting id of user clicked edit button.

            if (id) {
                reset_form();
                fetchscehdule_data(id)

            }
        });

        function fetchscehdule_data(auditscheduleid) {

            $.ajax({
                url: '/audit/fetchschedule_data', // Your API route to get user details
                method: 'POST',
                data: {
                    auditscheduleid: auditscheduleid
                }, // Pass deptuserid in the data object
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        $('#display_error').hide();
                        change_button_as_update('audit_schedule', 'action', 'buttonaction',
                            'display_error', '', '');
                        // validator.resetForm();

                        const inst = response.data; // The array of schedule data

                        datepicker('from_date', convertDateFormatYmd_ddmmyy(inst[0].fromdate));
                        datepicker('to_date', convertDateFormatYmd_ddmmyy(inst[0].todate));
                        $('#rc_no').val(inst[0].rcno);
                        $('#instcode').val(inst[0].rcno);
                        $('#as_code').val(inst[0].encrypted_auditscheduleid);
                        $('#total_mandays').val(inst[0].mandays);
                        $('#total_teamsize').val(inst[0].total_team_count);
                        // appending institute details //
                        $('#inst_code').val(inst[0].instid);
                        $('#inst_name').empty();
                        $('#inst_name').append(
                            `<option value="${inst[0].instid} "selected">
                             ${inst[0].instename}
                             </option>`
                        );
                        // appending team head Details //
                        $('#th_uid_name').empty();
                        $('#th_uid_name').append(
                            `<option value="${inst[0].team_head_userid} "selected">
                        ${inst[0].team_head_name} - ${inst[0].desigelname}
                    </option>`
                        );
                        // appending team member Details //
                        $("#tm_uid").empty();

                        const selectedTeamMembers = inst.map(member => member
                            .team_member_userid); // Extract IDs for selection
                        fetch_audit_memberdata(selectedTeamMembers);

                    } else {
                        alert('Schedule Details not found');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function fetch_audit_memberdata(selectedTeamMembers = []) {
            var planid = $('#ap_code').val();
            $.ajax({
                url: '/audit/audit_members', // Replace with your endpoint
                method: 'POST',
                data: {
                    planid: planid
                },
                success: function(response) {
                    const $select = $("#tm_uid");
                    $select.empty(); // Clear the existing options

                    // If selectedTeamMembers is not empty, pre-select the matching values
                    if (selectedTeamMembers.length > 0) {
                        // Iterate over the response data to append options dynamically
                        response.forEach(member => {
                            // Check if the member is in the selected list
                            const isSelected = selectedTeamMembers.includes(member
                                .userid);

                            // Create a new option element
                            let newOption = new Option(
                                `${member.username} - ${member.desigelname}`, // Display text
                                member.userid, // Option value
                                isSelected, // Set as selected in the dropdown if it's in selectedTeamMembers
                                isSelected // Mark as selected for Select2
                            );

                            // Append the new option to the dropdown
                            $select.append(newOption);
                        });

                        // Re-initialize Select2
                        $select.select2({
                            placeholder: "Select Team Member",
                            allowClear: true
                        });

                        // Set the selected values dynamically and trigger change for Select2
                        $select.val(selectedTeamMembers).trigger('change');
                    } else {
                        // If selectedTeamMembers is empty, just list all the options without any pre-selected
                        response.forEach(member => {
                            let newOption = new Option(
                                `${member.username} - ${member.desigelname}`, // Display text
                                member.userid, // Option value
                                false, // Not selected
                                false // Not selected for Select2
                            );
                            // Append the new option to the dropdown
                            $select.append(newOption);
                        });

                        // Re-initialize Select2 for listing all options without pre-selection
                        $select.select2({
                            placeholder: "Select Team Member",
                            allowClear: true
                        });
                    }
                },
                error: function() {
                    alert("Failed to fetch team members!");
                }
            });
        }

        // When editing, you can call the fetch_audit_memberdata function and pass the selected values
        $("#edit_button").on("click", function() {
            const selectedTeamMembers = [ /* Array of already selected team member IDs */ ];

            // Fetch and populate the dropdown, passing the selected values to pre-select them
            fetch_audit_memberdata(selectedTeamMembers);
        });

        // If no members are selected (empty array), call it like this
        $("#edit_button_no_selection").on("click", function() {
            fetch_audit_memberdata([]); // Pass an empty array for no selection
        });

        // function fetch_instituteData() {
        //     $.ajax({
        //         url: 'audit/creatauditschedule_dropdownvalues', // The route to call your controller method
        //         method: 'POST',
        //         data: {
        //             auditplanid: '' // Passing the auditplanid from the button's id
        //         },
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
        //                 'content') // CSRF token for security
        //         },
        //         success: function(response) {
        //             alert(resaponse);
        //             if (response.success) {
        //                 // Handle the success case (you can redirect, update UI, etc.)
        //                 alert("Data loaded successfully.");
        //                 // You can use response data to update your UI dynamically
        //             } else {
        //                 alert("Failed to load data.");
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle error
        //             console.log("AJAX error: " + error);
        //         }
        //     });
        // }
        $(document).ready(function() {
            fetch_audit_memberdata(selectedTeamMembers = []);
            fetchAlldata();
            // fetch_instituteData();
        });
    </script>
@endsection
