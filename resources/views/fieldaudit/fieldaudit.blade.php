@section('content')
    @extends('index2')
    @include('common.alert')


    <?php
    $instdel = json_decode($inst_details, true);
    $getmajorobjection = json_decode($get_majorobjection, true);
    
    $teamhead = $instdel[0]['auditteamhead'];
    $instid = $instdel[0]['instid'];
    // $teamheadid = $teamheadid;
    $auditscheduleid = $instdel[0]['auditscheduleid'];
    $schteammemberid = $instdel[0]['schteammemberid'];
    $auditplanid = $instdel[0]['auditplanid'];
    
    if ($teamhead == 'Y') {
        $buttonname = 'Approve';
    } else {
        $buttonname = 'Forward';
    }
    
    $entry_show_first_tab = '';
    $audit_show_first_tab = '';
    $show_tab = '';
    $entrytab = '';
    $worktab = '';
    
    if ($teamhead == 'Y') {
        // $workallocationslip = '2';
        $auditslip = '3';
        $view_auditslip = '4';
        $entry_show_first_tab = 'show active';
        $entrytab = 'active';
        $show_workform = '';
        $hidetablefield = '';
    } else {
        $audit_show_first_tab = 'show active';
        // $workallocationslip = '2';
        $auditslip = '3';
        $view_auditslip = '4';
        $show_tab = 'style="display:none"';
        $worktab = 'active';
        $show_workform = 'style="display:none"';
        $hidetablefield = 'style="display:none"';
    }
    ?>
    <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">
    <!-- {{-- <link rel="stylesheet" href="../assets/libs/daterangepicker/daterangepicker.css"> --}} -->
    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <style>
        #container {
            width: 1000px;
            margin: 20px auto;
        }

        .card-fixed-width {
            width: 300px;
            /* Adjust to your preferred fixed width */
            max-width: 100%;
            /* Ensures it doesn't exceed screen width on smaller devices */
        }


        .ck-editor__editable[role="textbox"] {
            min-height: 200px;
        }

        .ck-editor__editable {
            font-family: 'Marutham', sans-serif;
        }

        .content-cell {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            /* Show only 2 lines */
            overflow: hidden;
            text-overflow: ellipsis;
            height: 40px;
            /* Adjust this based on your line height */
            line-height: 20px;
            /* Set this to match your text height */
            white-space: normal;
            /* Allow wrapping */
        }

        /* @font-face {
                                                                                                                                                                                                                                                                                                                                                                                           font-family: 'Marutham';
                                                                                                                                                                                                                                                                                                                                                                                      src: url('path/to/marutham.ttf') format('truetype');
                                                                                                                                                                                                                                                                                                                                                                                 } */

        .card-body {
            padding: 15px 10px;
        }

        .card {
            margin-bottom: 10px;
        }

        .card-body {
            padding: 15px 10px;
        }

        .card {
            margin-bottom: 10px;
        }

        /* Step Circle Style */
        .step-circle {
            display: inline-block;
            width: 20px;
            height: 20px;
            line-height: 15px;
            text-align: center;
            border-radius: 50%;
            background-color: #fff;
            color: #0d6efd;
            font-weight: bold;
            /* position: absolute; */
            top: -10px;
            left: 10px;
            font-size: 14px;
            border: 2px solid #0d6efd;
        }

        /* Mobile View Adjustments */
        @media (max-width: 768px) {

            /* Make the navigation stack vertically on smaller screens */
            .nav-pills .nav-item {
                width: 100%;
                text-align: left;
                margin-bottom: 10px;
            }

            /* Adjust the .nav-link to display block on mobile */
            .nav-pills .nav-link {
                display: block;
                padding-left: 40px;
                /* Ensure the text doesn't overlap with the circle */
            }

            /* Adjust the circle position and size */
            .step-circle {
                position: relative;
                top: 0;
                left: 0;
                margin-right: 10px;
                font-size: 16px;
                display: inline-block;
            }

            /* Adjust the tab content for smaller screens */
            .tab-content {
                padding-left: 15px;
                padding-right: 15px;
            }

            /* Make the 3rd and 4th steps appear in separate rows */
            .tab-content .row {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
            }

            .tab-pane .col-md-6 {
                width: 100%;
            }
        }

        /* Small screens, stack elements even more */
        @media (max-width: 576px) {
            .nav-pills .nav-item {
                width: 100%;
                text-align: left;
            }

            .nav-pills .nav-link {
                display: flex;
                align-items: center;
                padding-left: 40px;
                /* Keeps the circle alignment */
            }

            .step-circle {
                margin-right: 10px;
                font-size: 18px;
                top: 0;
                left: 0;
                display: inline-block;
            }

            /* Adjust the tab content padding for small screens */
            .tab-content {
                padding-left: 15px;
                padding-right: 15px;
            }

            /* Adjust rows in tab content to display properly on mobile */
            .tab-pane .row {
                display: flex;
                flex-direction: column;
            }

            .tab-pane .col-md-6 {
                width: 100%;
                /* Ensure full width for each column */
            }
        }

        /* For larger screens, keep the default horizontal nav-pills layout */
        @media (min-width: 992px) {
            .nav-pills .nav-item {
                width: auto;
                /* Revert the width to auto for large screens */
            }

            .nav-pills .nav-link {
                display: inline-block;
                /* Horizontal layout */
            }

            .step-circle {
                margin-right: 10px;
                font-size: 16px;
                top: -10px;
                left: 10px;
            }
        }


        .wizard .nav-link {
            font-weight: bold;
            border: 1px solid #7198b9;
            margin: 0 5px;
            border-radius: 5px;
        }

        .wizard .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }
    </style> <?php $fromdate = \Carbon\Carbon::parse($instdel[0]['fromdate'])->format('d-m-Y'); ?> <div class="row">
        <div class="col-12">
            <div class="card card_border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3"> <label class="form-label required" for="validationDefault01">Institution
                                Name</label> <input type="text" class="form-control" id="total_mandays"
                                name="total_mandays" value="<?php echo $instdel[0]['instename']; ?>" disabled> </div>
                        <div class="col-md-2 mb-3"> <label class="form-label required" for="validationDefault01">Institution
                                Category</label> <input type="text" class="form-control" id="total_mandays"
                                name="total_mandays" value="<?php echo $instdel[0]['catename']; ?>" disabled> </div>
                        <div class="col-md-2 mb-3"> <label class="form-label required" for="validationDefault01">Type of
                                Audit</label> <input type="text" class="form-control" id="total_mandays"
                                name="total_mandays" value="<?php echo $instdel[0]['typeofauditename']; ?>" disabled> </div>
                        <div class="col-md-2 mb-3"> <label class="form-label required" for="validationDefault01">Year of
                                Audit</label> <input type="text" class="form-control" id="total_mandays"
                                name="total_mandays" value="<?php echo $instdel[0]['yearname']; ?>" disabled> </div>
                        <div class="col-md-3 mb-3"> <label class="form-label required" for="validationDefault01">Total
                                Mandays</label> <input type="text" class="form-control" id="total_mandays"
                                name="total_mandays" value="<?php echo $instdel[0]['mandays']; ?>" disabled> </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label required" for="validationDefault01">Select Form</label>
                            <select class=" form-control custom-select" name="form_sel" id="form_sel"
                                onchange="show_form()">
                                <option value="">--- Select Form ---</option>
                                <option value="E">Entry Meeting</option>
                                <option value="W">Work Allocation</option>
                                <option value="X">Exit Meeting</option>

                            </select>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
            </div>
            <!-- Step 1 -->
            <div class="card card_border hide_this" id="step1">
                <div class="card-header card_header_color">Entry Meeting</div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-4 mb-3"> <label class="form-label" for="validationDefault02">Entry
                                    Meet
                                    Date</label>
                                <div class="input-group" onclick="datepicker('from_date','')"> <input type="text"
                                        class="form-control datepicker" id="from_date" name="from_date"
                                        placeholder="dd/mm/yyyy" value="<?php echo $fromdate; ?>" disabled /> <span
                                        class="input-group-text"> <i class="ti ti-calendar fs-5"></i> </span>
                                </div>
                            </div>
                            <div class="col-md-4"> <label class="form-label" for="validationDefault02">Entry
                                    Metting</label>
                                <div class="card overflow-hidden">
                                    <div class="d-flex flex-row">
                                        <div class="p-2  align-items-center">
                                            <h3 class="text-danger box mb-0 round-56 p-2"> <i class="ti ti-file-text "></i>
                                            </h3>
                                        </div>
                                        <div class="p-3">
                                            <h3 class="text-dark mb-0 fs-3">Entrymeeting.pdf</h3>
                                            <!--<span>size:
                                                                                                                                                                                                                                                                                                                                10 mb</span>-->
                                        </div>
                                        <div class="p-3 align-items-center ms-auto">
                                            <h3 class="text-primary box mb-0"  onclick="downloadFile('entrymeeting')"> <i
                                                    class="ti ti-download"></i>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"> <label class="form-label" for="validationDefault02">Code
                                    of Ethics</label>
                                <div class="card overflow-hidden">
                                    <div class="d-flex flex-row">
                                        <div class="p-2  align-items-center">
                                            <h3 class="text-danger box mb-0 round-56 p-2"> <i
                                                    class="ti ti-file-text "></i> </h3>
                                        </div>
                                        <div class="p-3">
                                            <h3 class="text-dark mb-0 fs-3">codeofethics.pdf</h3>
                                            <!--<span>size:
                                                                                                                                                                                                                                                                                                                                    10 mb</span>-->
                                        </div>
                                        <div class="p-3 align-items-center ms-auto">
                                            <h3 class="text-primary box mb-0" onclick="downloadFile('codeofethics')">
                                                <i class="ti ti-download"></i>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="card card_border hide_this" id="step2">
                <div class="card-header card_header_color">Work Allocation</div>
                <div class="card-body">
                    <form <?php echo $show_workform; ?> id="work_allocation" name="work_allocation">
                        <div class="alert alert-danger alert-dismissible fade show hide_this" role="alert"
                            id="display_error">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        <input type="hidden" id="auditscheduleId" name="auditscheduleId"
                            value="{{ $inst_details->first()->auditscheduleid }}" />
                        <input type="hidden" id="workallocationid" name="workallocationid" value="" />
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="validationDefault01">Select Team
                                    Member</label>
                                <select class=" form-control custom-select" name="team_mem" id="team_mem">
                                    <option value="">Select Team Member</option>
                                    @foreach ($teammemdel as $teammember)
                                        <option value="{{ $teammember->schteammemberid }}">
                                            {{ $teammember->username }}
                                            -
                                            {{ $teammember->desigelname }}

                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="validationDefault01">Audit Period
                                    From
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="fromdate" name="fromdate"
                                        placeholder="dd/mm/yyyy" disabled value="<?php echo isset($inst_details->first()->fromdate) ? \Carbon\Carbon::parse($inst_details->first()->fromdate)->format('d/m/Y') : ''; ?>" />
                                    <span class="input-group-text">
                                        <i class="ti ti-calendar fs-5"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="validationDefault01">Audit Period
                                    To
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="todate" name="todate"
                                        placeholder="dd/mm/yyyy" disabled value="<?php echo isset($inst_details->first()->todate) ? \Carbon\Carbon::parse($inst_details->first()->todate)->format('d/m/Y') : ''; ?>" />
                                    <span class="input-group-text">
                                        <i class="ti ti-calendar fs-5"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="">Major Work Allocation

                                </label>
                                <select class="select2 form-select mr-sm-2" name="majorwa" id="majorwa"
                                    onchange="get_minorworkdet('','')">
                                    <option value="">Select Major Work Allocation</option>
                                    @foreach ($majorworkdel as $majorworkdetails)
                                        <option value="{{ $majorworkdetails->majorworkallocationtypeid }}">
                                            {{ $majorworkdetails->majorworkallocationtypeename }}

                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="">Sub Work Allocation

                                </label>

                                <select class="select2 form-control custom-select" multiple="multiple" id="minorwa"
                                    name="minorwa[]" aria-placeholder="Select Member">

                                    {{-- @foreach ($inst as $teammember)
                            <option value="{{ $teammember->teamMember }}">
                            {{ $teammember->teammemberName }} -
                            {{ $teammember->chargedescription }}

                            </option>
                            @endforeach --}}

                                </select>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-3 mx-auto">
                                <input type="hidden" name="work_action" id="work_action" value="insert" />
                                <button class="btn button_save mt-3" type="submit" action="insert" id="saveworkall"
                                    name="saveworkall">Save Draft </button>
                                <button class="btn bg-success button_finalise mt-3" type="submit" id="finaliseWork"
                                    action="finaliseWork">
                                    Finalize
                                </button>
                                <button type="button" class="btn btn-danger mt-3" id="reset_button">Clear</button>
                            </div>
                        </div>
                    </form>

                    <div class="card mt-6" style="border-color: #7198b9">
                        <div class="card-header card_header_color">Work Allocation Details</div>
                        <div class="card-body">
                            <div class="datatables">
                                <div class="table-responsive hide_this" id="tableshow">
                                    <table id="workallocationtable"
                                        class="table w-100 table-striped table-bordered display text-nowrap datatables-basic">
                                        <thead>
                                            <tr>
                                                <th class="lang" key="s_no">S.No</th>
                                                <th> <?php echo $hidetablefield; ?>User</th>
                                                <th>Audit Period</th>
                                                <th>Major Work Allocation</th>
                                                <th>Sub Work Allocation</th>
                                                <th <?php echo $hidetablefield; ?> class="all">Action</th>
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

            <!-- Step 5 -->
            <div class="card card_border hide_this" id="step5">
                <div class="card-header card_header_color">Exit Meeting</div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-4 mb-3"> <label class="form-label" for="validationDefault02">Exit
                                    Meet
                                    Date</label>
                                <div class="input-group"> <input type="text" class="form-control datepicker"
                                        id="exit_date" name="exit_date" placeholder="dd/mm/yyyy" value="" />
                                    <span class="input-group-text"> <i class="ti ti-calendar fs-5"></i> </span>
                                </div>
                            </div>
                            <div class="col-md-4"> <label class="form-label" for="validationDefault02">Exit
                                    Metting</label>
                                <div class="card overflow-hidden" style="border-color: #7198b9">
                                    <div class="d-flex flex-row">
                                        <div class="p-2  align-items-center">
                                            <h3 class="text-danger box mb-0 round-56 p-2"> <i
                                                    class="ti ti-file-text "></i> </h3>
                                        </div>
                                        <div class="p-3">
                                            <h3 class="text-dark mb-0 fs-3">Exitmeeting.pdf</h3>
                                            <!--<span>size:
                                                                                                                                                                                                                                                                                                                                10 mb</span>-->
                                        </div>
                                        <div class="p-3 align-items-center ms-auto">
                                            <h3 class="text-primary box mb-0" onclick="downloadFile('exitmeeting')">
                                                <i class="ti ti-download"></i>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </script>
    <script src="../assets/js/vendor.min.js"></script>
    <script src="../assets/js/extra-libs/moment/moment.min.js"></script>
    <script src="../assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- <script src="../assets/js/forms/daterangepicker-init.js"></script> -->
    <!--select 2 -->
    <script src="../assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="../assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="../assets/js/forms/select2.init.js"></script>
    <!--chat-app-->
    <script src="../assets/js/apps/chat.js"></script>
    <!-- Form Wizard -->
    <script src="../assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
    <!-- <script src="../assets/js/forms/form-wizard.js"></script> -->
    <script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="../assets/js/datatable/datatable-advanced.init.js"></script>


    <script>
        /***************************************************** View Form ******************************************************************* */
        function show_form() {

            const form_id = $('#form_sel').val();

            // alert();
            if (form_id == 'E') {
                $('#step1').show();
                $('#step2').hide();
                $('#step5').hide();
            } else if (form_id == 'W') {

                $('#step2').show();
                $('#step1').hide();
                $('#step5').hide();
            } else if (form_id == 'X') {
                $('#step5').show();
                $('#step2').hide();
                $('#step1').hide();
            } else if (form_id == '') {
                $('#step5').hide();
                $('#step2').hide();
                $('#step1').hide();
            }

        }
        /***************************************************** View Form ******************************************************************* */
        /***************************************************** View SLip ******************************************************************* */



        /******************************************************Language Dropdown******************************************************************* */
        function get_severity(selectedValue) {
            var severitylevel = [{
                    "severityval": "L",
                    "severityename": "Low",
                    "severitytname": "குறைவு"
                },
                {
                    "severityval": "M",
                    "severityename": "Medium",
                    "severitytname": "நடுத்தரம்"
                },
                {
                    "severityval": "H",
                    "severityename": "High",
                    "severitytname": "உயர்"
                },
            ];
            var lang = window.localStorage.getItem('lang');
            var severityDropdown = document.getElementById("severityid");
            selectedseverityValue = $('#severityid').val()
            if ((lang === "en") || (lang === null)) severityDropdown.innerHTML =
                '<option value="">--Select Severity--</option>';
            else if (lang === "ta") severityDropdown.innerHTML =
                '<option value="">--தீவிரத்தை தேர்ந்தெடுக்கவும்-- </option>';


            // Check if condition is 1 or 0 and populate accordingly
            if ((lang === "en") || (lang === null)) {


                severitylevel.forEach(function(item) {
                    var option = document.createElement("option");
                    option.value = item.severityval;
                    option.text = item.severityename;
                    // Check if this option matches the selected value
                    if (item.severityval === selectedValue) {
                        option.selected = true; // Mark this option as selected
                    }
                    severityDropdown.appendChild(option);

                });


            } else if (lang === "ta") {

                severitylevel.forEach(function(item) {
                    var option = document.createElement("option");
                    option.value = item.severityval;
                    option.text = item.severitytname;
                    // Check if this option matches the selected value
                    if (item.severityval === selectedValue) {
                        option.selected = true; // Mark this option as selected
                    }
                    severityDropdown.appendChild(option);

                });

            }
        }

        function get_objectiondetail(selectedValue) {


            var data = <?php echo json_encode($getmajorobjection); ?>;


            var lang = window.localStorage.getItem('lang');

            var majorObjectDropdown = document.getElementById("majorobjectioncode");
            var minorObjectDropdown = document.getElementById("minorobjectioncode");
            // var severityDropdown = document.getElementById("severityid");

            if (!(selectedValue)) {
                selectedValue = $('#majorobjectioncode').val()
            }


            if ((lang === "en") || (lang === null)) {
                majorObjectDropdown.innerHTML =
                    '<option value="">--Select  Title/Heading --</option>';
                minorObjectDropdown.innerHTML =
                    '<option value="">--Select  Categorization of paras -- </option>';
            } else if (lang === "ta") {
                majorObjectDropdown.innerHTML =
                    '<option value="">முக்கிய ஆட்சேபனையைத் தேர்ந்தெடுக்கவும் </option>';
                minorObjectDropdown.innerHTML =
                    '<option value="">சிறு ஆட்சேபனையைத் தேர்ந்தெடுக்கவும்</option>';
            }

            // selectedseverityValue = $('#severityid').val()
            // if ((lang === "en") || (lang === null)) severityDropdown.innerHTML =
            //     '<option value="">--Select Severity--</option>';
            // else if (lang === "ta") severityDropdown.innerHTML =
            //     '<option value="">--தீவிரத்தை தேர்ந்தெடுக்கவும்-- </option>';


            // Check if condition is 1 or 0 and populate accordingly
            if ((lang === "en") || (lang === null)) {
                // Add options from idprooflname
                // data.forEach(function(item) {
                //     var option = document.createElement("option");
                //     option.value = item.mainobjectionid;
                //     option.text = item.objectionename;
                //     majorObjectDropdown.appendChild(option);

                // });

                // var selectedValue = "someValue"; // Replace with the value you want to select dynamically.

                data.forEach(function(item) {
                    var option = document.createElement("option");
                    option.value = item.mainobjectionid;
                    option.text = item.objectionename;

                    // Check if this option matches the selected value
                    if (item.mainobjectionid === selectedValue) {
                        option.selected = true; // Mark this option as selected
                    }

                    majorObjectDropdown.appendChild(option);
                });


                // severitylevel.forEach(function(item) {
                //     var option = document.createElement("option");
                //     option.value = item.severityval;
                //     option.text = item.severityename;
                //     severityDropdown.appendChild(option);

                // });
                // bill_number = 'Enter bill number';
                // gstin = 'Enter Gstin Number';
                // shop_name = 'Enter shop name';
                // bill_date = 'Choose bill purchased date';
                // shop_dist = 'Select District';
                // bill_amount = 'Enter Bill amount';
                // bill_upload = 'Upload Bill';

            } else if (lang === "ta") {
                // Add options from idprooftname
                data.forEach(function(item) {
                    var option = document.createElement("option");
                    option.value = item.mainobjectionid;
                    option.text = item.objectiontname;
                    if (item.mainobjectionid === selectedValue) {
                        option.selected = true; // Mark this option as selected
                    }

                    majorObjectDropdown.appendChild(option);

                });
                // $('#severityid').empty();
                // severitylevel.forEach(function(item) {
                //     var option = document.createElement("option");
                //     option.value = item.severityval;
                //     option.text = item.severitytname;
                //     severityDropdown.appendChild(option);

                // });
                // bill_number = 'பட்டியல் எண்ணை உள்ளிடவும்';
                // gstin = 'ஜிஸ்டின் எண்ணை உள்ளிடவும்';
                // shop_name = 'கடையின் பெயரை உள்ளிடவும்';
                // bill_date  = 'பட்டியல் வாங்கிய தேதியைத் தேர்ந்தெடுக்கவும்';
                // shop_dist   =   'மாவட்டத்தைத் தேர்ந்தெடுக்கவும்';
                // bill_amount   =   'பட்டியல் தொகையை உள்ளிடவும்';
                // bill_upload   =   'பட்டியலைப் பதிவேற்றவும்';
            }

            // // var condition = document.getElementById("translate").value;
            // var lang = window.localStorage.getItem('lang');

            // var idproofDropdown = document.getElementById("shop_dist");

            // selectedValue = $('#shop_dist').val()

            // // Clear the previous options
            // // idproofDropdown.innerHTML = '<option value="">--Select District--</option>';

            // if ((lang === "en") || (lang === null)) idproofDropdown.innerHTML =
            //     '<option value="">--Select District--</option>';
            // else if (lang === "ta") idproofDropdown.innerHTML =
            //     '<option value="">-- மாவட்டத்தைத் தேர்ந்தெடுக்கவும் --</option>';


            // // Check if condition is 1 or 0 and populate accordingly
            // if ((lang === "en") || (lang === null)) {
            //     // Add options from idprooflname
            //     data.forEach(function(item) {
            //         var option = document.createElement("option");
            //         option.value = item.distcode;
            //         option.text = item.distename;
            //         idproofDropdown.appendChild(option);

            //     });

            //     bill_number = 'Enter bill number';
            //     gstin = 'Enter Gstin Number';
            //     shop_name = 'Enter shop name';
            //     bill_date = 'Choose bill purchased date';
            //     shop_dist = 'Select District';
            //     bill_amount = 'Enter Bill amount';
            //     bill_upload = 'Upload Bill';

            // } else if (lang === "ta") {
            //     // Add options from idprooftname
            //     data.forEach(function(item) {
            //         var option = document.createElement("option");
            //         option.value = item.distcode;
            //         option.text = item.disttname;
            //         idproofDropdown.appendChild(option);
            //     });
            //     bill_number = 'பட்டியல் எண்ணை உள்ளிடவும்';
            //     gstin = 'ஜிஸ்டின் எண்ணை உள்ளிடவும்';
            //     shop_name = 'கடையின் பெயரை உள்ளிடவும்';
            //     bill_date = 'பட்டியல் வாங்கிய தேதியைத் தேர்ந்தெடுக்கவும்';
            //     shop_dist = 'மாவட்டத்தைத் தேர்ந்தெடுக்கவும்';
            //     bill_amount = 'பட்டியல் தொகையை உள்ளிடவும்';
            //     bill_upload = 'பட்டியலைப் பதிவேற்றவும்';
            // }


            // document.getElementById('bill_number').placeholder = bill_number;
            // document.getElementById('gstin').placeholder = gstin;
            // document.getElementById('shop_name').placeholder = shop_name;
            // document.getElementById('bill_date').placeholder = bill_date;
            // document.getElementById('bill_amount').placeholder = shop_dist;
            // document.getElementById('bill_upload').placeholder = bill_amount;
            // document.getElementById('shop_dist').placeholder = bill_upload;


            // if (selectedValue) {
            //     for (var i = 0; i < idproofDropdown.options.length; i++) {
            //         if (idproofDropdown.options[i].value === selectedValue) {
            //             idproofDropdown.selectedIndex = i;
            //             break;
            //         }
            //     }
            // }
        }
        /****************************************************Language Dropdown******************************************************************** */


        /**************************************************** Editor ***********************************************************************/

        let viewslip_auditorremarks;

        CKEDITOR.ClassicEditor.create(document.getElementById("viewslip_auditorremarks"), {
                toolbar: {
                    items: [
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'numberedList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        'fontSize', 'fontFamily', '|',
                        'alignment', '|',
                        'uploadImage', 'insertTable',
                        '|',

                    ],
                    shouldNotGroupWhenFull: true
                },
                placeholder: 'Welcome to CAMS... Write Your Audit Objection here',
                fontFamily: {
                    options: [
                        'default', 'Marutham', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace',
                        'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif', 'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif', 'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                removePlugins: [
                    'AIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'Base64UploadAdapter', 'MultiLevelList',
                    'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory', 'Pagination',
                    'WProofreader',
                    'MathType', 'SlashCommand', 'Template', 'DocumentOutline', 'FormatPainter', 'TableOfContents',
                    'PasteFromOfficeEnhanced', 'CaseChange'
                ]
            })
            .then(e => {
                viewslip_auditorremarks = e;
                viewslip_auditorremarks.enableReadOnlyMode('initial');
            })
            .catch(error => {
                console.error(error);
            });

        let viewslip_auditeeremarks;

        CKEDITOR.ClassicEditor.create(document.getElementById("viewslip_auditeeremarks"), {
                toolbar: {
                    items: [
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'numberedList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        'fontSize', 'fontFamily', '|',
                        'alignment', '|',
                        'uploadImage', 'insertTable',
                        '|',

                    ],
                    shouldNotGroupWhenFull: true
                },
                placeholder: 'Welcome to CAMS... Write Your Audit Objection here',
                fontFamily: {
                    options: [
                        'default', 'Marutham', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace',
                        'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif', 'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif', 'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                removePlugins: [
                    'AIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'Base64UploadAdapter', 'MultiLevelList',
                    'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory', 'Pagination',
                    'WProofreader',
                    'MathType', 'SlashCommand', 'Template', 'DocumentOutline', 'FormatPainter', 'TableOfContents',
                    'PasteFromOfficeEnhanced', 'CaseChange'
                ]
            })
            .then(e => {
                viewslip_auditeeremarks = e;
                viewslip_auditeeremarks.enableReadOnlyMode('initial');

            })
            .catch(error => {
                console.error(error);
            });

        get_viewslipdetails('', 'fetch')

        function get_viewslipdetails(slipid, action) {

            $.ajax({
                url: '/getviewauditslip', // Your API route to get user details
                method: 'POST',
                data: {
                    auditslipid: slipid,
                    auditscheduleid: <?php echo $auditscheduleid; ?>
                }, // Pass deptuserid in the data object
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        $('#upload_preview').hide();

                        if (response.data && response.data.auditDetails.length > 0) {
                            if (action == 'fetch') {
                                const chatUsersList = document.querySelector(".chat-users-view");
                                // Clear any existing content inside the chatUsersList (if needed)
                                chatUsersList.innerHTML = '';

                                seriesnumber = Number($('#viewseriesno').val());
                                response.data.auditDetails.forEach(function(item) {
                                    addSlipNumber_forview(item.mainslipnumber, item
                                        .encrypted_auditslipid);
                                });
                                $('#varrow_v' + seriesnumber).show();
                            }

                            let firstItem = response.data.auditDetails[0];
                            $('#auditslipid').val(firstItem.encrypted_auditslipid);
                            $('#viewslip_majorobjection').val(firstItem.mainobjectionid)
                            $('#viewslip_minorobjection').val(firstItem.subobjectionename)
                            $('#viewslip_amtinvolved').val(firstItem.amtinvolved)
                            $('#viewslip_severityid').val(firstItem.severity)
                            $('#viewslip_slipdetails').val(firstItem.slipdetails)
                            viewslip_auditorremarks.setData(firstItem.auditorremarks);

                            $('#statusdisplay').html(firstItem.processelname);

                            $('#repliedon').html(change_dateformat(firstItem.auditeerepliedon));

                            if ((firstItem.processcode == 'A') || (firstItem.processcode == 'X')) {

                                $('#acceptreject_btndiv').hide();
                            } else $('#acceptreject_btndiv').show();

                            viewslip_files(firstItem.filedetails_1, 'viewslip_auditorcontainer')

                            if (firstItem.liability == 'Y') {
                                liability = 'Ye';
                                $('#viewslip_liabilitynamediv').show();
                                $('#viewslip_liabilityname').val(firstItem.liabilityname);
                            } else {
                                liability = 'Noo';
                                $('#viewslip_liabilitynamediv').hide();
                                $('#viewslip_liabilityname').val('');

                            }
                            $('input[name="viewslip_liability"][value="' + liability + '"]').prop('checked',
                                true);

                            if (response.data.auditorRemarks.length > 0) {
                                let auditeeremarks = response.data.auditorRemarks[0];
                                viewslip_auditeeremarks.setData(auditeeremarks.auditeeremarks);
                                viewslip_files(auditeeremarks.filedetails_1, 'viewslip_auditeecontainer')
                            }
                        }
                    } else {
                        alert('User not found');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

        }

        function addSlipNumber_forview(slipNumber, id) {

            // Get the 'ul' element where the slip numbers are listed
            const chatUsersList = document.querySelector(".chat-users-view");

            // Create a new 'li' element for the new slip number
            const newListItem = document.createElement("li");

            seriesno = $('#viewseriesno').val();

            // Add the HTML content for the new 'li'
            newListItem.innerHTML = `
                    <div class="hstack p-2 bg-hover-light-black position-relative border-bottom " id="v${seriesno}" onclick="viewhandleSlipClick('v${seriesno}')">
                        <input type="hidden" id="vslipid_v${seriesno}" name="slipid" value="${id}">
                        <input type="hidden" id="vslipnumber_v${seriesno}" name="vslipnumber_v${seriesno}" value='${slipNumber}'>

                        <a style="color:black;" href="javascript:void(0)" class="stretched-link"></a>
                        <div class="ms-2">
                            <a style="color:black;" href="javascript:void(0)">
                                <i class="text-primary ri ri-clipboard-text fs-5"></i>
                            </a>
                        </div>
                        <div class="ms-auto">
                            <h6 class="mb-0">${slipNumber}</h6>
                        </div>
                        <div class="ms-auto">
                            <a style="color:black;" href="javascript:void(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"
                                    class="icon icon-tabler icons-tabler-filled icon-tabler-arrow-big-right-lines slip-arrow" style="display:none" id="varrow_v${seriesno}">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12.089 3.634a2 2 0 0 0 -1.089 1.78l-.001 2.585l-1.999 .001a1 1 0 0 0 -1 1v6l.007 .117a1 1 0 0 0 .993 .883l1.999 -.001l.001 2.587a2 2 0 0 0 3.414 1.414l6.586 -6.586a2 2 0 0 0 0 -2.828l-6.586 -6.586a2 2 0 0 0 -2.18 -.434l-.145 .068z" />
                                    <path d="M3 8a1 1 0 0 1 .993 .883l.007 .117v6a1 1 0 0 1 -1.993 .117l-.007 -.117v-6a1 1 0 0 1 1 -1z" />
                                    <path d="M6 8a1 1 0 0 1 .993 .883l.007 .117v6a1 1 0 0 1 -1.993 .117l-.007 -.117v-6a1 1 0 0 1 1 -1z" />
                                </svg>
                            </a>
                        </div>
                    </div>`;

            // Append the new 'li' to the list
            chatUsersList.appendChild(newListItem);

            // Increment the slip number and series number
            slipNumber = slipNumber + 1;
            seriesno = Number($('#viewseriesno').val()) + 1;

            // Update the value of the autoslipnumber input field
            $('#viewseriesno').val(seriesno);

            // Flag to check if the click handler has been triggered before
            let clickHandled = false;
        }

        function viewhandleSlipClick(seriesno) {

            const clickedId = seriesno; // Get the ID of the clicked element
            currentslipnumber = $('#vslipnumber_' + clickedId).val();
            currentslipid = $('#vslipid_' + clickedId).val();
            $('#currentslipnumber').val(currentslipnumber);
            $('#auditslipid').val(currentslipid);
            $(".slip-arrow").hide();
            $('#varrow_' + clickedId).show();
            get_viewslipdetails(currentslipid, '')
        }

        function viewslip_files(filesresponse, divid) {
            const fileDetailsString = filesresponse; // Assuming this is the response field

            const fileDetailsArray = fileDetailsString.split(
                ','); // Split by comma for each file

            // Prepare files array for rendering
            const files = fileDetailsArray.map((fileDetail, index) => {
                const [name, path, size, fileuploadid] = fileDetail.split(
                    '-'); // Split by hyphen
                return {
                    id: index +
                        1, // Example ID (you can use an actual ID if available)
                    name: name,
                    path: path,
                    size: size,
                    fileuploadid: fileuploadid,
                };
            });

            const fileListContainer = $('#' + divid);
            fileListContainer.empty(); // Clear previous file cards

            files.forEach(file => {
                const fileCard = `
                        <div class="card overflow-hidden mb-3">
                            <div class="d-flex flex-row">
                                <div class="p-2 align-items-center">
                                    <h3 class="text-danger box mb-0 round-56 p-2">
                                        <i class="ti ti-file-text"></i>
                                    </h3>
                                </div>
                                <div class="p-3">
                                    <h3 class="text-dark mb-0 fs-4">
                                        <!-- Add an anchor tag to open the file in a new tab -->
                                        <a style="color:black;" href="/storage/${file.path}" target="_blank">${file.name}</a></h3>
                                </div>
                            </div>


                        </div>
                    `;
                fileListContainer.append(fileCard); // Add the file card to the container
            });

        }

        $('#viewslip_reject').on("click", function() {

            event.preventDefault();
            // Trigger the form validation
            if ($("#auditslip").valid()) {

                document.getElementById("process_button").onclick = function() {
                    updateslip('X')
                };
                // Show confirmation alert
                passing_alert_value('Confirmation', 'Are sure to Reject?', 'confirmation_alert', 'alert_header',
                    'alert_body', 'forward_alert');
            } else {
                //alert("Form is not valid. Please fix the errors.");
            }
        });


        $('#viewslip_accept').on("click", function() {

            event.preventDefault();
            // Trigger the form validation
            if ($("#auditslip").valid()) {


                document.getElementById("process_button").onclick = function() {
                    updateslip('A')
                };
                // Show confirmation alert
                passing_alert_value('Confirmation', 'Are sure to Accept?', 'confirmation_alert', 'alert_header',
                    'alert_body', 'forward_alert');


            } else {
                //alert("Form is not valid. Please fix the errors.");
            }
        });

        function updateslip(processcode) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // 'Content-Type': 'application/x-www-form-urlencoded',
                }
            });


            $.ajax({
                url: '/update_slip', // URL where the form data will be posted
                type: 'POST',
                data: {
                    auditslipid: $('#auditslipid').val(),
                    processcode: processcode
                },
                // processData: false, // Disable automatic data processing
                // contentType: false, // Let jQuery handle the content type for FormData
                success: function(response) {
                    if (response.success) {
                        reset_form(); // Reset the form after successful submission
                        get_objectiondetail();
                        get_severity();
                        passing_alert_value('Confirmation', response.message,
                            'confirmation_alert', 'alert_header', 'alert_body',
                            'confirmation_alert');

                        // table.ajax.reload(); // Reload the table with the new data
                        get_viewslipdetails('', 'fetch')
                    } else if (response.error) {
                        // Handle errors if needed
                        console.log(response.error);
                    }
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



        // $('#viewslip_reject')



        /**************************************************** Editor ***********************************************************************/






        /****************************************************** View SLip ***************************************************************** */



        /********************************** Common Function ****************************************************/

        $(document).ready(function() {

            // $(".daterange").daterangepicker({
            //     minDate: moment(), // Start from the current date
            //     autoApply: true, // Automatically apply the selected range
            //     locale: {
            //         format: 'DD-MM-YYYY' // Format of the date
            //     }
            // });

            // Dynamically adjust the date range based on #balance_mandays value
            const balanceMandaysInput = $("#balance_mandays");
            // const dateRangePickerInput = $(".daterange");

            // Function to update the max date based on the balance_mandays
            function updateDatePicker() {
                const balanceDays = parseInt(balanceMandaysInput.val()) || 0; // Get the value from #balance_mandays
                const maxDate = moment().add(balanceDays, 'days'); // Calculate the max date

                // Update the date range picker options
                // dateRangePickerInput.daterangepicker({
                //     minDate: moment(), // Current date
                //     maxDate: maxDate, // Max date based on balanceMandays
                //     autoApply: true, // Automatically apply the range
                //     locale: {
                //         format: 'DD-MM-YYYY' // Format
                //     }
                // });
            }

            // Initialize the picker with the current balance_mandays value
            updateDatePicker();

            // If #balance_mandays changes dynamically, reinitialize the picker
            balanceMandaysInput.on('change', function() {
                updateDatePicker();
            });
            // Initialize with different placeholders
            initSelect2("#user", "Select  User");
        });

        /********************************** Common Function ****************************************************/





        /*************************************************  Audit Tab Functions *********************************************/


        /*************************************************  Ckeditor  *********************************************/

        let editor;

        CKEDITOR.ClassicEditor.create(document.getElementById("auditorremarks"), {
                toolbar: {
                    items: [
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'numberedList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        'fontSize', 'fontFamily', '|',
                        'alignment', '|',
                        'uploadImage', 'insertTable',
                        '|',

                    ],
                    shouldNotGroupWhenFull: true
                },
                placeholder: 'Welcome to CAMS... Write Your Audit Objection here',
                fontFamily: {
                    options: [
                        'default', 'Marutham', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace',
                        'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif', 'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif', 'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                removePlugins: [
                    'AIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'Base64UploadAdapter', 'MultiLevelList',
                    'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory', 'Pagination',
                    'WProofreader',
                    'MathType', 'SlashCommand', 'Template', 'DocumentOutline', 'FormatPainter', 'TableOfContents',
                    'PasteFromOfficeEnhanced', 'CaseChange'
                ]
            })
            .then(e => {
                editor = e;
            })
            .catch(error => {
                console.error(error);
            });



        let view_editor;

        CKEDITOR.ClassicEditor.create(document.getElementById("view_auditorremarks"), {
                toolbar: {
                    items: [
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'numberedList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        'fontSize', 'fontFamily', '|',
                        'alignment', '|',
                        'uploadImage', 'insertTable',
                        '|',
                    ],
                    shouldNotGroupWhenFull: true
                },
                placeholder: 'Welcome to CAMS... Write Your Audit Objection here',
                fontFamily: {
                    options: [
                        'default', 'Marutham', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace',
                        'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif', 'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                removePlugins: [
                    'AIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'Base64UploadAdapter', 'MultiLevelList',
                    'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory', 'Pagination',
                    'WProofreader',
                    'MathType', 'SlashCommand', 'Template', 'DocumentOutline', 'FormatPainter', 'TableOfContents',
                    'PasteFromOfficeEnhanced', 'CaseChange'
                ]
            })
            .then(editor => {
                view_editor = editor;
                view_editor.enableReadOnlyMode('initial');
                // Disable editing (make read-only)
                // view_editor.enableReadOnlyMode();
            })
            .catch(error => {
                console.error(error);
            });


        /*************************************************  Ckeditor  *********************************************/


        /***************************************************** Upload File - Preview *********************************/

        function importData() {
            // Dynamically create a file input element
            let input = document.createElement('input');
            input.type = 'file';

            // Handle file selection
            input.onchange = () => {
                let files = Array.from(input.files);

                // Synchronize the files with the original input
                document.getElementById('upload_file').files = input.files;

                // Pass the selected file to the previewAttachment function
                previewAttachment(input, 'upload_preview');
            };

            // Trigger the file dialog
            input.click();
        }

        function previewAttachment(input, previewDivId) {
            // Ensure a file is selected
            if (!input.files || input.files.length === 0) return;

            const file = input.files[0];
            const previewDiv = document.getElementById(previewDivId);

            // Clear the preview area
            previewDiv.innerHTML = "";

            if (file) {
                const fileType = file.type;
                $('#upload_preview').show();

                // Check if the uploaded file is an image
                if (fileType.startsWith("image/")) {
                    const img = document.createElement("img");
                    img.src = URL.createObjectURL(file);
                    img.style.maxWidth = "100%";
                    img.style.maxHeight = "400px";

                    previewDiv.appendChild(img);
                }
                // Check if the uploaded file is a PDF
                else if (fileType === "application/pdf") {
                    const iframe = document.createElement("iframe");
                    iframe.src = URL.createObjectURL(file);
                    iframe.style.width = "100%";
                    iframe.style.height = "400px";
                    iframe.setAttribute("frameborder", "0");
                    previewDiv.appendChild(iframe);
                }
                // Handle unsupported file types
                else {
                    const message = document.createElement("p");
                    message.textContent = "Unsupported file type. Please upload an image or a PDF.";
                    previewDiv.appendChild(message);
                }
            }
        }

        /***************************************************** Upload File - Preview *********************************/



        ////////////////////////////////////// Search Audit Slip Number //////////////////////////////////////

        $(".search-chat").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".chat-users li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        ////////////////////////////////////// Search Audit Slip Number //////////////////////////////////////





        getauditslip('', 'fetch', 'Y');

        fetchallWorkdetail();

        $("#work_allocation").validate({
            rules: {
                team_mem: {
                    required: true,
                },
                fromdate: {
                    required: true
                },
                todate: {
                    required: true
                },
                majorwa: {
                    required: true
                },
                "minorwa[]": {
                    required: true
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
                team_mem: {
                    required: "Select User",

                },
                fromdate: {
                    required: "Select From Date",
                },
                todate: {
                    required: "Select To Date",
                },
                majorwa: {
                    required: "Select Major Work Allocation Type",
                },
                "minorwa[]": {
                    required: "Select Minor Work Allocation Type",
                },

            }
        });

        function enable_liability(selectedOption) {
            if (selectedOption === 'Y') {
                // Show the textbox when "Yes" is selected
                $("#liabilityname_div").show();
            } else {
                // Hide the textbox when "No" is selected
                $("#liabilityname_div").hide();
            }
        }


        function getminorobjection(mainobjectioncode, subobjectionid) {
            if (!mainobjectioncode) mainobjectioncode = $('#majorobjectioncode').val();

            var lang = window.localStorage.getItem('lang');
            if (!lang) lang = 'en'; // Default to English if no language is set

            $.ajax({
                url: '/getsubobjection', // Your API route to get minor objections
                method: 'POST',
                data: {
                    mainobjectioncode: mainobjectioncode
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        $("#minorobjectioncode").empty();

                        // Add default option based on language
                        if (lang === "en") {
                            $("#minorobjectioncode").append(
                                "<option value=''>---Select Minor Objection ---</option>");
                        } else if (lang === "ta") {
                            $("#minorobjectioncode").append(
                                "<option value=''>துணை ஆட்சேபனையைத் தேர்ந்தெடுக்கவும்---</option>");
                        }

                        // Populate options based on the language and response data
                        if (response.data && Array.isArray(response.data) && response.data.length > 0) {
                            var subobjection = response.data;

                            for (var i = 0; i < subobjection.length; i++) {
                                const isSelected = typeof subobjectionid !== 'undefined' &&
                                    subobjectionid ===
                                    subobjection[i].subobjectionid ? 'selected' : '';

                                // Select option text based on language
                                const optionText = (lang === "ta") ? subobjection[i].subobjectiontname :
                                    subobjection[i].subobjectionename;

                                $("#minorobjectioncode").append(`
                          <option value="${subobjection[i].subobjectionid}" ${isSelected}>
                              ${optionText}
                          </option>
                        `);
                            }
                        } else {
                            if (lang === "en") {
                                $("#minorobjectioncode").append(
                                    "<option value=''>No objections available</option>");
                            } else if (lang === "ta") {
                                $("#minorobjectioncode").append(
                                    "<option value=''>ஆட்சேபனைகள் இல்லை</option>");
                            }
                        }
                    } else {
                        console.error("Failed to fetch data:", response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }



        /*********************************************** Jqury Form Validation *******************************************/


        $("#auditslip").validate({
            rules: {
                majorobjectioncode: {
                    required: true,
                },
                minorobjectioncode: {
                    required: true
                },
                // amount_involved: {
                //     required: true
                // },
                slipno: {
                    required: true
                },
                slipdetails: {
                    required: true
                },
                auditorremarks: {
                    required: true
                },
                upload_file: {
                    required: true
                },
                severityid: {
                    required: true
                },
                liability: {
                    required: true
                },
                liabilityname: {
                    required: true
                },

            },
            messages: {
                majorobjectioncode: {
                    required: "Select a major objection type",
                    // number: "Please enter a valid number",
                    // minlength: "Slip number must be at least 5 digits long"
                },
                minorobjectioncode: {
                    required: "Select a minor objection type",
                },
                // amount_involved: {
                //     required: "Enter the amount involved",
                // },
                slipno: {
                    required: "Enter a slip number",
                },
                slipdetails: {
                    required: "Enter a slipdetails",
                },
                auditorremarks: {
                    required: "Enter a auditor remarks",
                },
                upload_file: {
                    required: "Upload a file",
                },
                severityid: {
                    required: "Select Severity",
                },
                liability: {
                    required: "Select liablility",
                },
                liabilityname: {
                    required: "Select liability name",
                },
            }
        });

        /*********************************************** Jqury Form Validation *******************************************/


        /*********************************************** Insert,update,finalise,reset *******************************************/

        // Event listener for the button to add a new slip number
        // Event listener for the button to add a new slip number
        $("#approvebtn").on("click", function() {

            event.preventDefault();
            // Trigger the form validation
            if ($("#auditslip").valid()) {
                document.getElementById("process_button").onclick = function() {
                    createslip('Y')
                };

                if (('<?php echo $teamhead; ?>' == 'Y')) alert_content =
                    'Are you sure to forward the slip details to the institution?';
                if (('<?php echo $teamhead; ?>' == 'N')) alert_content =
                    'Are you sure to forward the slip details to team head?';


                // Show confirmation alert
                passing_alert_value('Confirmation', alert_content, 'confirmation_alert', 'alert_header',
                    'alert_body', 'forward_alert');
            } else {}
        });

        $("#buttonaction").on("click", function(event) {
            // Prevent form submission (this stops the page from refreshing)
            event.preventDefault();

            //Trigger the form validation
            if ($("#auditslip").valid()) {
                createslip('N')
            } else {

            }
        });


        function createslip(finalise) {

            var formData = new FormData($('#auditslip')[0]); // Serialize form data, including files

            formData.append('remarks', editor.getData());
            formData.append('finaliseflag', finalise);
            formData.append('teamheadid', <?php echo $teamheadid; ?>);
            // formData.append('fileuploadstatus', $('fileuploadstatus').val());
            formData.append('instid', '<?php echo $instid; ?>');


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // 'Content-Type': 'application/x-www-form-urlencoded',
                }
            });


            $.ajax({
                url: '/audislip_insert', // URL where the form data will be posted
                type: 'POST',
                data: formData,
                processData: false, // Disable automatic data processing
                contentType: false, // Let jQuery handle the content type for FormData
                success: function(response) {
                    if (response.success) {
                        reset_form(); // Reset the form after successful submission
                        get_objectiondetail();
                        get_severity();
                        passing_alert_value('Confirmation', response.message,
                            'confirmation_alert', 'alert_header', 'alert_body',
                            'confirmation_alert');

                        // table.ajax.reload(); // Reload the table with the new data
                        if ($('#action').val() == 'insert') {
                            getauditslip(response.data, 'fetch', 'Y');
                        } else
                            getauditslip(response.data, 'fetch', 'N');

                    } else if (response.error) {
                        // Handle errors if needed
                        console.log(response.error);
                    }
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


        function reset_form() {
            $("#auditslip").validate().resetForm(); // Reset the validation errors
            $("#auditslip")[0].reset(); // Optionally reset the form fields as well
            $("#minorobjectioncode").empty();
            // get_objectiondetail();
            // get_severity();
            change_button_as_insert('auditslip', 'action', 'buttonaction', 'display_error', '', '');
            updateSelectColorByValue(document.querySelectorAll(".form-select"));
            $('#liabilityname_div').hide();

            editor.setData('');
        }


        /*********************************************** Insert,update,finalise,reset *******************************************/




        /*********************************************** Fetch Data *******************************************/

        function getauditslip(slipid, action, createnewone) {
            fixslipid = slipid;

            if (action == 'fetch') slipid = '';

            $.ajax({
                url: '/getauditslip', // Your API route to get user details
                method: 'POST',
                data: {
                    auditslipid: slipid,
                    auditscheduleid: <?php echo $auditscheduleid; ?>
                }, // Pass deptuserid in the data object
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        $('#upload_preview').hide();

                        if (response.data && response.data.length > 0) {

                            reset_form();

                            if (action == 'fetch') {
                                $('#seriesno').val(1);
                                const chatUsersList = document.querySelector(".chat-users");

                                // Clear any existing content inside the chatUsersList (if needed)
                                chatUsersList.innerHTML = '';


                                if (fixslipid == '') {
                                    seriesnumber = Number($('#seriesno').val());
                                    firstItem = response.data[0];
                                    fixarrow = seriesnumber;

                                }



                                response.data.forEach(function(item) {
                                    addSlipNumber(item.mainslipnumber, item.encrypted_auditslipid);

                                    if (fixslipid) {
                                        if (fixslipid == item.mainslipnumber) {
                                            fixarrow = $('#seriesno').val() - 1;
                                            firstItem = item;
                                        }
                                    }
                                });

                                $('#arrow_' + fixarrow).show();
                            } else if (action == 'edit') {
                                firstItem = response.data[0];
                            }


                            if (('<?php echo $teamhead; ?>' == 'Y')) {
                                if ((firstItem.processcode == 'E') || (firstItem.processcode == 'S')) {
                                    // if ((firstItem.processcode == 'S'))

                                    $('#auditslipcard').show();
                                    $('#viewauditslipcard').hide();
                                } else {
                                    //$('#forwardedby').html('Initiated By Self')
                                    $('#auditslipcard').hide();
                                    show_view_card(firstItem);
                                    // $('#viewauditslipcard').show();
                                }
                            }


                            if (('<?php echo $teamhead; ?>' == 'N')) {
                                if ((firstItem.processcode == 'E')) {
                                    $('#auditslipcard').show();
                                    $('#viewauditslipcard').hide();

                                } else {
                                    show_view_card(firstItem);
                                    $('#auditslipcard').hide();
                                    // $('#viewauditslipcard').show();
                                }
                            }





                            if (firstItem.encrypted_auditslipid) {
                                $('#forwardedby').html('')
                                $('#approvedby').html('')

                                if (firstItem.forwardedbyusername) {
                                    initiatedby = 'Initiated By ' + firstItem.forwardedbyusername +
                                        ' Forwarded on: ' + change_dateformat(firstItem.forwardedon);
                                } else {
                                    initiatedby = 'Initiated By Itself';
                                }

                                if (firstItem.approvedbyusername) {
                                    // initiatedby = 'Initiated By ' + firstItem.approvedbyusername + ' Forwarded on: ' + change_dateformat(firstItem.approvedon);
                                    var approvedon = ' Approved on: ' + change_dateformat(firstItem.approvedon);

                                }



                                $('#forwardedby').html(initiatedby)
                                $('#approvedby').html(approvedon)

                                $('#upload_file').hide();
                                change_button_as_update('auditslip', 'action', 'buttonaction', 'display_error',
                                    '', '');

                                const auditorremarksdata = JSON.parse(firstItem.auditorremarks);
                                auditorremarks = auditorremarksdata.content;

                                $('#currentslipnumber').val(firstItem.mainslipnumber);
                                $('#auditslipid').val(firstItem.encrypted_auditslipid);
                                getminorobjection(firstItem.mainobjectionid, firstItem.subobjectionid)
                                get_objectiondetail(firstItem.mainobjectionid)
                                get_severity(firstItem.severity);
                                // $('#majorobjectioncode').val(firstItem.mainobjectionid);
                                $('#amount_involved').val(firstItem.amtinvolved);
                                $('#slipdetails').val(firstItem.slipdetails);
                                // $('#auditorremarks').val(firstItem.auditorremarks);
                                editor.setData(auditorremarks);
                                // $('#severityid').val(firstItem.severity);

                                if (firstItem.liability == 'Y') $('#liabilityname').val(firstItem
                                    .liabilityname);

                                $('#fileuploadstatus').val('N');
                                enable_liability(firstItem.liability)

                                $('input[name="liability"][value="' + firstItem.liability + '"]').prop(
                                    'checked', true);
                                const fileDetailsString = firstItem
                                    .filedetails_1; // Assuming this is the response field
                                const fileDetailsArray = fileDetailsString.split(
                                    ','); // Split by comma for each file

                                // alert(firstItem.filedetails_1);
                                if (firstItem.filedetails_1) {
                                    $('#file-list-container').show()
                                }

                                // $('#file-list-container').show()

                                // Prepare files array for rendering
                                const files = fileDetailsArray.map((fileDetail, index) => {
                                    const [name, path, size, fileuploadid] = fileDetail.split(
                                        '-'); // Split by hyphen
                                    return {
                                        id: index +
                                            1, // Example ID (you can use an actual ID if available)
                                        name: name,
                                        path: path,
                                        size: size,
                                        fileuploadid: fileuploadid,
                                    };
                                });

                                renderFileList(files);
                                // alert(files);

                                var activeFileIds = files.map(function(file) {


                                    // Instead of splitting file, just access the 'id' property
                                    return file.id; // Use the 'id' property from the object
                                });

                                // Join all the file IDs and set it in the hidden input field
                                $('#active_fileid').val(activeFileIds.join(','));


                            }

                            if (createnewone == 'Y') {
                                addSlipNumber('', '');
                            }
                        } else {
                            $('#auditslipcard').show();
                            //  alert('e');
                            seriesnumber = Number($('#seriesno').val());
                            $('#currentslipnumber').val($('#autoslipnumber').val())
                            $('#fileuploadstatus').val('Y');

                            addSlipNumber('', '');
                            $('#arrow_' + seriesnumber).show();
                            //  $('#upload_file').show()

                            get_objectiondetail()
                            get_severity();

                        }
                    } else {
                        alert('User not found');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

        }



        function show_view_card(firstItem) {
            $('#viewauditslipcard').show();
            $('#view_majorobjectioncode').val(firstItem.mainobjectionid);
            $('#view_amount_involved').val(firstItem.amtinvolved);
            $('#view_slipdetails').val(firstItem.slipdetails);
            $('#view_auditorremarks').val(firstItem.auditorremarks);
            $('#view_severityid').val(firstItem.severity);
            $('#view_minorobjectioncode').val(firstItem.subobjectionename);
            if (firstItem.liability == 'Y') {
                liability = 'Yes';

                $('#viewliabilityname_div').show();
                $('#view_liabilityname').val(firstItem.liabilityname);
            } else {
                liability = 'No';
                $('#viewliabilityname_div').hide();
                $('#view_liabilityname').val('');

            }
            $('input[name="view_liability"][value="' + liability + '"]').prop(
                'checked', true);
            const fileDetailsString = firstItem
                .filedetails_1; // Assuming this is the response field
            const fileDetailsArray = fileDetailsString.split(
                ','); // Split by comma for each file

            // alert(firstItem.filedetails_1);
            if (firstItem.filedetails_1) {
                $('#file-list-container').show()
            }


            const files = fileDetailsArray.map((fileDetail, index) => {
                const [name, path, size, fileuploadid] = fileDetail.split(
                    '-'); // Split by hyphen
                return {
                    id: index +
                        1, // Example ID (you can use an actual ID if available)
                    name: name,
                    path: path,
                    size: size,
                    fileuploadid: fileuploadid,
                };
            });
            view_files(files)

            const auditorremarksdata = JSON.parse(firstItem.auditorremarks);
            auditorremarks = auditorremarksdata.content;

            view_editor.setData(auditorremarks);
            // view_editor.isReadOnly = true;

            //                            view_majorobjectioncode



        }

        /*********************************************** Fetch Data *******************************************/





        /*********************************************** Automatic Slip Add *******************************************/


        function addSlipNumber(slipNumber, id) {


            // Check if slipNumber is not provided
            if (!slipNumber) {
                // var stringValue = $('#autoslipnumber').val(); // Get value of the slip number input
                // var intValue = Number(stringValue); // Convert string to number using Number()
                // if (isNaN(intValue)) intValue = 0;
                slipNumber = 'NEW';
            }

            // Ensure id is not null or undefined (set to empty string by default)
            if (!id) id = '';

            // Get the 'ul' element where the slip numbers are listed
            const chatUsersList = document.querySelector(".chat-users");

            // Create a new 'li' element for the new slip number
            const newListItem = document.createElement("li");



            seriesno = $('#seriesno').val();

            // Add the HTML content for the new 'li'
            newListItem.innerHTML = `
                    <div class="hstack p-2 bg-hover-light-black position-relative border-bottom " id="${seriesno}" onclick="handleSlipClick('${seriesno}')">
                <input type="hidden" id="slipid_${seriesno}" name="slipid" value="${id}">
                <input type="hidden" id="slipnumber_${seriesno}" name="slipnumber_${seriesno}" value='${slipNumber}'>

                <a style="color:black;" href="javascript:void(0)" class="stretched-link"></a>
                <div class="ms-2">
                    <a style="color:black;" href="javascript:void(0)">
                        <i class="text-primary ri ri-clipboard-text fs-5"></i>
                    </a>
                </div>
                <div class="ms-auto">
                    <h6 class="mb-0">${slipNumber}</h6>
                </div>
                <div class="ms-auto">
                    <a style="color:black;" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"
                            class="icon icon-tabler icons-tabler-filled icon-tabler-arrow-big-right-lines slip-arrow" style="display:none" id="arrow_${seriesno}">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12.089 3.634a2 2 0 0 0 -1.089 1.78l-.001 2.585l-1.999 .001a1 1 0 0 0 -1 1v6l.007 .117a1 1 0 0 0 .993 .883l1.999 -.001l.001 2.587a2 2 0 0 0 3.414 1.414l6.586 -6.586a2 2 0 0 0 0 -2.828l-6.586 -6.586a2 2 0 0 0 -2.18 -.434l-.145 .068z" />
                            <path d="M3 8a1 1 0 0 1 .993 .883l.007 .117v6a1 1 0 0 1 -1.993 .117l-.007 -.117v-6a1 1 0 0 1 1 -1z" />
                            <path d="M6 8a1 1 0 0 1 .993 .883l.007 .117v6a1 1 0 0 1 -1.993 .117l-.007 -.117v-6a1 1 0 0 1 1 -1z" />
                        </svg>
                    </a>
                </div>
            </div>`;



            // Append the new 'li' to the list
            chatUsersList.appendChild(newListItem);



            // Increment the slip number and series number
            // slipNumber = slipNumber + 1;
            seriesno = Number($('#seriesno').val()) + 1;

            // Update the value of the autoslipnumber input field
            // $('#autoslipnumber').val(slipNumber);
            $('#seriesno').val(seriesno);

            // Flag to check if the click handler has been triggered before
            let clickHandled = false;

            // // Attach the click event listener using event delegation
            // $(".chat-users").on("click", ".getfullslipdetails", function() {
            //     if (clickHandled) return; // If the click was already handled, do nothing

            //     const clickedId = $(this).attr('id');  // Get the ID of the clicked element

            //     currentslipnumber = $('#slipnumber_' + clickedId).val();
            //     currentslipid = $('#slipid_' + clickedId).val();

            //     $('#currentslipnumber').val(currentslipnumber);
            //     $('#auditslipid').val(currentslipid);

            //     $(".slip-arrow").hide();
            //     $('#arrow_' + clickedId).show();

            //     $("#auditslip").validate().resetForm(); // Reset the validation errors
            //     $("#auditslip")[0].reset(); // Optionally reset the form fields as well

            //     if (currentslipid) {
            //         getauditslip(currentslipid);
            //     }

            //     // Set the flag to prevent further clicks
            //     //clickHandled = true;
            // });
        }


        function handleSlipClick(seriesno) {


            $('#upload_file').show();
            $('#fileuploadstatus').val('Y');
            $('#fileuploadid').val('');
            const fileListContainer = $('#file-list-container');
            fileListContainer.empty(); // Clear previous file cards
            $('#file-list-container').hide();

            //$('#upload_file').show();
            // $('#file-list-container').hide();

            const clickedId = seriesno; // Get the ID of the clicked element
            currentslipnumber = $('#slipnumber_' + clickedId).val();
            currentslipid = $('#slipid_' + clickedId).val();
            $('#upload_preview').hide();
            if (currentslipid) {
                getauditslip(currentslipid, 'edit');
            } else {
                $('#forwardedby').html('Initiated By Self')
                reset_form();
                get_objectiondetail();
                get_severity();
                $('#auditslipcard').show();
                $('#viewauditslipcard').hide();
            }



            $('#currentslipnumber').val(currentslipnumber);
            $('#auditslipid').val(currentslipid);

            $(".slip-arrow").hide();
            $('#arrow_' + clickedId).show();

            editor.setReadOnly(true);


        }

        // When the 'Add Slip Number' button is clicked (directly, no modal)
        $("#add-button").click(function() {
            addSlipNumber(); // Add a new slip number when the button is clicked
        });

        /*********************************************** Automatic Slip Add *******************************************/



        /**************************************** Fit the upload files, delete upload file in s **********************/

        function renderFileList(files) {
            const fileListContainer = $('#file-list-container');
            fileListContainer.empty(); // Clear previous file cards

            files.forEach(file => {
                $('#fileuploadid').val(file.fileuploadid);
                const fileCard = `
          <div class="card overflow-hidden mb-3" id="file-card-${file.id}">
          <input type="hidden" id="fileuploadid_${file.id}" name="fileuploadid_${file.id}" value="${file.fileuploadid}" >
              <div class="d-flex flex-row">
                  <div class="p-2 align-items-center">
                      <h3 class="text-danger box mb-0 round-56 p-2">
                          <i class="ti ti-file-text"></i>
                      </h3>
                  </div>
                  <div class="p-3">
                      <h3 class="text-dark mb-0 fs-4">
                          <!-- Add an anchor tag to open the file in a new tab -->
                          <a style="color:black;" href="/storage/${file.path}" target="_blank">${file.name}</a> </h3>
                  </div>

                  <div class="p-3 align-items-center ms-auto">
                      <button class="text-danger box mb-0" onclick="deleteFile(${file.id}, event)">
                          <i class="ti ti-trash"></i> Delete
                      </button>
                  </div>
              </div>
          </div>
      `;

                // <div class="p-3 align-items-center ms-auto">
                //     <a href="/files/download/${file.id}" class="text-primary box mb-0">
                //         <i class="ti ti-download"></i> Download
                //     </a>
                // </div>
                fileListContainer.append(fileCard); // Add the file card to the container
            });
        }


        function view_files(files) {


            const fileListContainer = $('#view_file-list-container');
            fileListContainer.empty(); // Clear previous file cards

            files.forEach(file => {
                $('#fileuploadid').val(file.fileuploadid);
                const fileCard = `
                 <label
                                                                        class="form-label required"
                                                                        for="validationDefaultUsername">Attachments</label>
          <div class="card overflow-hidden mb-3 bg-light card-fixed-width" id="viewfile-card-${file.id}">
              <div class="d-flex flex-row">
                  <div class="p-2 align-items-center">
                      <h3 class="text-danger box mb-0 round-56 p-2">
                          <i class="ti ti-file-text"></i>
                      </h3>
                  </div>
                  <div class="p-3">
                      <h3 class="text-dark mb-0 fs-4">
                          <!-- Add an anchor tag to open the file in a new tab -->
                          <a style="color:black;" href="/storage/${file.path}" target="_blank">${file.name}</a> </h3>
                  </div>


              </div>
          </div>
      `;

                // <div class="p-3 align-items-center ms-auto">
                //     <a href="/files/download/${file.id}" class="text-primary box mb-0">
                //         <i class="ti ti-download"></i> Download
                //     </a>
                // </div>
                fileListContainer.append(fileCard); // Add the file card to the container
            });
        }

        // Function to delete a file
        function deleteFile(fileId, event) {
            event.preventDefault(); // Prevents page refresh

            // Set up the confirmation process
            document.getElementById("process_button").onclick = function() {
                deletefilefromview(fileId);
            };

            // Show confirmation alert
            passing_alert_value('Confirmation', "Are you sure you want to delete this file?", 'confirmation_alert',
                'alert_header', 'alert_body', 'forward_alert');
        }

        function deletefilefromview(fileId) {
            $('#file-card-' + fileId).hide();

            // // Optionally, remove the file ID from activefileid (if necessary)
            // var activeFileIds = $('#active_fileid').val().split(',');
            // activeFileIds = activeFileIds.filter(function(id) {
            //     return id != fileId;
            // });
            // $('#active_fileid').val(activeFileIds.join(','));


            // // Get the current deactivefileid value and ensure it is an array
            // var deactiveFileIds = $('#deactive_fileid').val().split(',').filter(function(id) {
            //     return id !== ''; // Remove empty values (in case there's a leading comma)
            // });

            // // Add the file ID to deactivefileid if not already present
            // if (!deactiveFileIds.includes(fileId.toString())) {
            //     deactiveFileIds.push(fileId);
            // }

            // // Join the array with commas and update the deactive_fileid hidden input field
            // $('#deactive_fileid').val(deactiveFileIds.join(','));
            $('#upload_file').show();
            $('#fileuploadstatus').val('Y');

        }

        /**************************************** Fit the upload files, delete upload file in edit **********************/


        /*************************************************  Audit Tab Functions *********************************************/

        /*************************************************  Work  All *********************************************/
        function get_minorworkdet(majorid, selectedMinorWork = []) {
            const majorworkid = majorid || $('#majorwa').val(); // Use passed majorid or selected value
            const $select = $('#minorwa');
            $select.empty(); // Clear existing options
            console.log('Selected Minor Work:', selectedMinorWork);
            // Perform AJAX request to fetch minor work allocation types
            $.ajax({
                url: '/fetchminorworkdel', // API route
                method: 'POST',
                data: {
                    majorworkid: majorworkid
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
                },
                success: function(response) {
                    if (response && response.length > 0) {
                        $select.empty();
                        // Iterate through the response and create options
                        response.forEach(minorwork => {
                            const isSelected = selectedMinorWork.includes(minorwork
                                .subworkallocationtypeid);

                            // Create a new option element
                            const newOption = new Option(
                                minorwork.subworkallocationtypeename, // Display text
                                minorwork.subworkallocationtypeid, // Option value
                                isSelected, // Whether the option should be pre-selected
                                isSelected // Mark as selected for Select2
                            );

                            // Append the new option to the dropdown
                            $select.append(newOption);
                        });

                        // Re-initialize Select2
                        $select.select2({
                            placeholder: "Select Minor Work Allocation Type",
                            allowClear: true
                        });

                        // Set pre-selected values
                        if (selectedMinorWork.length > 0) {

                            $select.val(selectedMinorWork).trigger('change');
                        }
                    } else {
                        // No data found, show placeholder
                        $select.select2({
                            placeholder: "No Minor Work Allocation Types Available",
                            allowClear: true
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
        /*********************************************** Date Picker*******************************************/
        function datepicker(value, setdate) {
            var today = new Date();
            if (value == 'dateperiod') {
                // Calculate the minimum date (18 years ago)
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
        $('#reset_button').on('click', function() {
            reset_WorkAllform(); // Call the reset_form function
        });
        $("#saveworkall").on("click", function(event) {
            // Prevent form submission (this stops the page from refreshing)
            event.preventDefault();

            //Trigger the form validation
            if ($("#work_allocation").valid()) {
                insert_workAllocation('insert')
            } else {
                // If the form is not valid, show an alert
                // alert("Form is not valid. Please fix the errors.");
            }
        });
        $("#finaliseWork").on("click", function(event) {
            // Prevent form submission (this stops the page from refreshing)
            event.preventDefault();

            //Trigger the form validation
            if ($("#work_allocation").valid()) {
                insert_workAllocation('finalise')
            } else {
                // If the form is not valid, show an alert
                // alert("Form is not valid. Please fix the errors.");
            }
        });
        $(document).on('click', '.edit_btn', function() {
            // Add more logic here
            // alert();
            var id = $(this).attr('id'); //Getting id of user clicked edit button.
            var major_id = $(this).attr('major_id');


            if (id) {
                reset_WorkAllform();
                fetch_singleworkdet(id, major_id)

            }
        });

        function fetch_singleworkdet(schteammemberid, major_id) {

            $.ajax({
                url: '/fetch_singleworkdet', // URL where the form data will be posted
                type: 'POST',
                data: {
                    schteammemberid: schteammemberid,
                    major_id: major_id,
                    auditscheduleid: <?php echo $auditscheduleid; ?>
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // CSRF token for security
                },
                // Let jQuery handle the content type for FormData
                success: function(response) {

                    if (response.success) {
                        $('#display_error').hide();
                        reset_WorkAllform();
                        change_button_as_update('work_allocation', 'work_action', 'saveworkall',
                            'display_error', '', '');


                        const workdetail = response.data;
                        $('#workallocationid').val(workdetail[0].encrypted_workallocationid);
                        $('#team_mem').val(workdetail[0].schteammemberid);

                        // $('#majorwa').val(workdetail[0].majorworkallocationtypeid);
                        $('#majorwa').val(workdetail[0].majorworkallocationtypeid).trigger('change');
                        const selectedMinorWork = workdetail.map(minorwork => minorwork
                            .subworkallocationtypeid);
                        // alert(selectedMinorWork);
                        get_minorworkdet(workdetail[0].majorworkallocationtypeid, selectedMinorWork);




                    } else if (response.error) {
                        // Handle errors if needed
                        console.log(response.error);
                    }
                },
                error: function(xhr, status, error) {

                    var response = JSON.parse(xhr.responseText);

                    var errorMessage = response.error ||
                        'An unknown error occurred';
                    $('#display_error').show();
                    $('#display_error').text(errorMessage);

                    // Displaying the error message
                    // passing_alert_value('Alert', errorMessage, 'confirmation_alert',
                    //     'alert_header', 'alert_body', 'confirmation_alert');


                    // Optionally, log the error to console for debugging
                    console.error('Error details:', xhr, status, error);
                }
            });
        }

        function insert_workAllocation(action) {

            var formData = $('#work_allocation').serializeArray();
            if (action === 'finalise') {
                finaliseflag = 'F';
            } else if (action === 'insert') {
                finaliseflag = 'Y';
            }
            formData.push({
                name: 'finaliseflag',
                value: finaliseflag
            });



            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // 'Content-Type': 'application/x-www-form-urlencoded',
                }
            });


            $.ajax({
                url: '/insert_workAllocation', // URL where the form data will be posted
                type: 'POST',
                data: formData,
                // Let jQuery handle the content type for FormData
                success: function(response) {

                    if (response.success) {
                        reset_WorkAllform();

                        passing_alert_value('Confirmation', response.message,
                            'confirmation_alert', 'alert_header', 'alert_body',
                            'confirmation_alert');
                        fetchallWorkdetail();
                        // table.ajax.reload(); // Reload the table with the new data
                        // getauditslip('', 'fetch')
                    } else if (response.error) {
                        // Handle errors if needed
                        console.log(response.error);
                    }
                },
                error: function(xhr, status, error) {

                    var response = JSON.parse(xhr.responseText);

                    var errorMessage = response.error ||
                        'An unknown error occurred';
                    $('#display_error').show();
                    $('#display_error').text(errorMessage);

                    // Displaying the error message
                    // passing_alert_value('Alert', errorMessage, 'confirmation_alert',
                    //     'alert_header', 'alert_body', 'confirmation_alert');


                    // Optionally, log the error to console for debugging
                    console.error('Error details:', xhr, status, error);
                }
            });

        }

        function reset_WorkAllform() {

            $("#work_allocation").validate().resetForm();
            // $("#work_allocation").resetForm();
            $("#work_allocation")[0].reset(); // Reset the validation errors
            // const selectElement = document.getElementById("majorwa");
            // selectElement.value = '';
            $("#majorwa").val('').trigger("change");
            $("#majorwa").val('');
            $("#minorwa").empty();
            // $("#team_mem").append("<option value=''>Select Minor Objection Type---</option>");
            change_button_as_insert('work_allocation', 'work_action', 'saveworkall', 'display_error', '', '');
            updateSelectColorByValue(document.querySelectorAll(".form-select"));


        }

        function fetchallWorkdetail() {

            if ($.fn.dataTable.isDataTable('#workallocationtable')) {
                $('#workallocationtable').DataTable().clear().destroy();
            }
            var teamhead = '<?php echo $teamhead; ?>'; // Example variable to decide whether to hide the column

            var table = $('#workallocationtable').DataTable({
                "processing": true,
                "serverSide": false,
                "lengthChange": false,
                "ajax": {
                    "url": "/fetchAllWorkData", // Your API route for fetching data
                    "type": "POST",
                    "data": {
                        'auditscheduleid': '<?php echo $auditscheduleid; ?>',
                        'teamhead': '<?php echo $teamhead; ?>',
                        'userid': '<?php echo $schteammemberid; ?>'
                    },
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Pass CSRF token in headers
                    },
                    "dataSrc": function(json) {
                        if (json.data && json.data.length > 0) {
                            $('#tableshow').show();
                            $('#workallocationtable_wrapper').show();
                            $('#no_data').hide(); // Hide custom "No Data" message
                            return json.data;
                        } else {
                            $('#tableshow').hide();
                            $('#workallocationtable_wrapper').hide();
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
                        "data": 'username', // Serial number column
                        "visible": teamhead !== 'N'

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
                        "data": "majorworkallocationtypeename", // Serial number column

                    },
                    {
                        "data": "subtypecodes",

                    },
                    {
                        "data": "encrypted_schteammemberid", // Use the encrypted deptuserid
                        "visible": teamhead !== 'N',
                        "render": function(data, type, row) {
                            if (row.statusflag === 'Y') {
                                // Check if statusflag is 'N'
                                return `<center>
            <a style="color:black;" class="btn editicon edit_btn" id="${data}" major_id="${row.majorworkallocationtypeid}">
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
                    },

                ]
            });

        }

        /**Download PDF File */
        function downloadFile(filename) 
        {
            var language = window.localStorage.getItem('lang');
            // Add language as a query string parameter to the file URL
            let fileWithLanguage = '/' + filename + '?lang=' + language;           
            // Trigger download by navigating to the URL
            window.location.href = fileWithLanguage;
        }
    </script>
@endsection
