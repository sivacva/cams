@section('content')
    @extends('index2')
    @include('common.alert')

    @php
    $sessionchargedel = session('charge'); 
    $roleTypeCode = $sessionchargedel->roletypecode; 
    $deptcode = $sessionchargedel->deptcode;
    $regioncode = $sessionchargedel->regioncode;
    $distcode = $sessionchargedel->distcode;

    $dga_roletypecode = $DGA_roletypecode;
    $Dist_roletypecode = $Dist_roletypecode;
    $Re_roletypecode = $Re_roletypecode;
    $Ho_roletypecode = $Ho_roletypecode;
    $Admin_roletypecode =   $Admin_roletypecode;


    $make_dept_disable = $deptcode ? 'disabled' : '';
    $make_deptdiv_show = $deptcode ? '' : 'hide_this';
    $make_region_disable = $regioncode ? 'disabled' : '';
    $make_regiondiv_disable = $regioncode ? '' : 'hide_this';
    $make_district_disable = $distcode ? 'disabled' : '';
    $make_districtdiv_disable = $distcode ? '' : 'hide_this';

@endphp

    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

    <div class="row">
        <div class="col-12">
            <div class="card card_border">
            <div class="card-header card_header_color">Create Charge</div>
                <div class="card-body">
                    <form id="chargeform" name="chargeform">
                        <input type="hidden" name="chargeid" id="chargeid">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3" id="deptdiv">
                                <label class="form-label required" for="dept">Department</label>

                                <select class="form-select mr-sm-2" id="deptcode" name="deptcode"
                                    onchange="getroletypecode_basedondept('')" <?php echo $make_dept_disable ?>>
                                    <option value="">Select Department</option>
                                    @if (!empty($dept) && count($dept) > 0)
                                        @foreach ($dept as $department)
                                            <option value="{{ $department->deptcode }}"
                                                @if (old('dept', $deptcode) == $department->deptcode) selected @endif>
                                                {{ $department->deptelname }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option disabled>No Departments Available</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="roletypecode">Role Type</label>
                                <select class="form-select mr-sm-2" id="roletypecode" name="roletypecode"
                                    onchange="settingform_basedonroletypcode('','','','','')" >
                                    <option value=''>Select Role Type</option>
                                    @if (isset($roletype) && is_iterable($roletype))
                                        @foreach ($roletype as $role)
                                            <option value="{{ $role->roletypecode }}">
                                                {{ $role->roletypeelname }}
                                            </option>
                                        @endforeach
                                    @else
                                    @endif
                                </select>
                            </div>


                            <div class="col-md-4 mb-3 <?php echo $make_regiondiv_disable?>" id="regiondiv">
                                <label class="form-label required" for="validationDefault01">Region </label>
                                <select class="form-select mr-sm-2" id="regioncode" name="regioncode"
                                    onchange="getvaluebasedon_regionroletype('', '', '', '', '')" <?php echo $make_region_disable ?>>
                                    <option value="">Select Region</option>

                                    @if($regiondetails)
                                    {
                                        <option value="{{ $regiondetails['regioncode'] }}" selected> 
                                            {{ $regiondetails['regionename'] }}
                                        </option>
                                    }
                                    @endif

                                </select>
                            </div>
                            <div class="col-md-4 mb-3 <?php echo $make_districtdiv_disable?>" id="distdiv">
                                <label class="form-label required" for="validationDefault01">District </label>
                                <select class="form-select mr-sm-2" id="distcode" name="distcode" 
                                onchange="getdistregioninst_basedondept('', '', '', '', 'institution', 'instmappingcode','')" <?php echo $make_district_disable ?>>
                                    <option value="">Select District</option>

                                    @if($distdetails)
                                    {
                                        <option value="{{ $distdetails['distcode'] }}" selected> 
                                            {{ $distdetails['distename'] }}
                                        </option>
                                    }
                                    @endif

                                    
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 hide_this" id="instdiv">
                                <label class="form-label required" for="validationDefault01">Insitution </label>
                                <select class="form-select mr-sm-2" id="instmappingcode" name="instmappingcode">
                                    <option value="">Select Institution</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="validationDefault01">Designation </label>
                                <select class="form-select mr-sm-2" id="desigcode" name="desigcode">
                                    <option value=''>Select Designation</option>
                                    @foreach ($designation as $department)
                                        <option value="{{ $department->desigcode }}">
                                            {{ $department->desigelname }} <!-- Display any field you need -->
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required " for="validationDefault02">Charge Description</label>
                                <input type="text" class="form-control" id="chargedescription" name="chargedescription"
                                    placeholder="description" required />
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="validationDefaultUsername">Role Action</label>
                                <select class="form-select mr-sm-2" id="roleactioncode" name="roleactioncode">
                                    <option value=''>Select Role Action</option>
                                    @foreach ($roleaction as $roleaction)
                                        <option value="{{ $roleaction->roleactioncode }}">
                                            {{ $roleaction->roleactionelname }} <!-- Display any field you need -->
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-md-4  mx-auto">
                                <button class="btn btn-success mt-3" type="submit"> Submit </button>
                                <button class="btn btn-danger mt-3" type="submit"> Cancel </button>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-3 mx-auto">
                                <input type="hidden" name="action" id="action"
                                    value="insert" />
                                <button class="btn button_save mt-3" type="submit" action="insert"
                                    id="buttonaction" name="buttonaction">Save Draft </button>
                                <button type="button" class="btn btn-danger mt-3"
                                    id="reset_button" onclick="reset_form()">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card_border">
                <div class="card-header card_header_color">Department Charge Details</div>
                <div class="card-body"><br>
                    <div class="datatables">
                        <div class="table-responsive hide_this" id="tableshow">
                            <table id="chargetable"
                                class="table w-100 table-striped table-bordered display text-nowrap datatables-basic">
                                <thead>
                                    <tr>
                                        <th class="lang" key="s_no">S.No</th>
                                        <th>Department</th>
                                        <th>Roletype</th>
                                        <th>Region</th>
                                        <th>District</th>
                                        <th>Institution</th>
                                        <th>RoleAction</th>
                                        <th>Designation</th>
                                        <th>chargedescription</th>
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

    <script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>

    <script>

       var session_roletypecode =   '<?php echo $roleTypeCode ?>';



        function getroletypecode_basedondept(deptcode, roletypecode) {
            const defaultOption = "<option value=''>Select Role Type</option>";
            const $dropdown = $("#roletypecode");

            // Get department code from DOM if not passed
            if (!deptcode) deptcode = $('#deptcode').val();

            if (deptcode) {
                // Clear the dropdown and set the default option
                $dropdown.html(defaultOption);

                $.ajax({
                    url: '/getroletypecode_basedondept',
                    type: 'POST',
                    data: {
                        deptcode: deptcode,
                        'page'  :   'createcharge',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success && Array.isArray(response.data)) {
                            let options = defaultOption;

                            // Iterate through the roles and build options
                            response.data.forEach(({
                                roletypecode: code,
                                roletypeelname: name
                            }) => {
                                if (code && name) {
                                    const isSelected = (code === roletypecode) ? "selected" : "";
                                    options += `<option value="${code}" ${isSelected}>${name}</option>`;
                                }
                            });

                            // Append the options to the dropdown
                            $dropdown.html(options);
                        } else {
                            console.error("Invalid response or data format:", response);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        let errorMessage = response.error;

                        if (xhr.responseText) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                errorMessage = response.message || errorMessage;
                            } catch (e) {
                                console.error("Error parsing error response:", e);
                            }
                        }

                        passing_alert_value('Alert', errorMessage, 'confirmation_alert',
                            'alert_header', 'alert_body', 'confirmation_alert');
                    }
                });
                
            } else {
                // Reset to default option if no department code is provided
                $dropdown.html(defaultOption);
            }
        }

        function settingform_basedonroletypcode(roletypecode, deptcode, regioncode, distcode,instmappingcode) {
            if (!roletypecode) roletypecode = $('#roletypecode').val();

            if (!deptcode) deptcode = $('#deptcode').val();

            // if ((roletypecode) && ((roletypecode == '<?php echo $Dist_roletypecode; ?>') || (roletypecode == '<?php echo $Re_roletypecode; ?>'))) 
            // {
            //     if((session_roletypecode == '<?php echo $dga_roletypecode; ?>')||(session_roletypecode == '<?php echo $Ho_roletypecode; ?>'))
            //     {
            //         makedropdownempty('regioncode', 'Select Region')
            //         getdistregioninst_basedondept(roletypecode, deptcode, regioncode, distcode, 'region', 'regioncode')
            //         $('#regiondiv').show();

            //         makedropdownempty('instmappingcode', 'Select Insittuion')
            //         $('#instdiv').show();

            //         if ((roletypecode == '<?php echo $Dist_roletypecode; ?>')) {
            //             // getdistregioninst_basedondept(roletypecode, deptcode, regioncode, distcode, 'region')
            //             makedropdownempty('distcode', 'Select District')
            //             $('#distdiv').show();
            //         } else {
            //             $('#distdiv').hide();
            //         }
            //     }

            //     if((session_roletypecode == '<?php echo $Dist_roletypecode; ?>')|| (session_roletypecode == '<?php echo $Re_roletypecode; ?>'))
            //     {
            //         makedropdownempty('instmappingcode', 'Select Insittuion')
            //         $('#instdiv').show();

            //         if((session_roletypecode == '<?php echo $Re_roletypecode; ?>'))
            //         {
            //             if(roletypecode == '<?php echo $Re_roletypecode; ?>')
            //             {
            //                 getdistregioninst_basedondept(roletypecode, deptcode, regioncode, '', 'institution', 'instmappingcode','')
            //             }
            //             else
            //             {
            //                 getdistregioninst_basedondept(roletypecode, deptcode, regioncode, '', 'district', 'distcode')
            //             }
            //         }
                       
            //         }
            //         if((session_roletypecode == '<?php echo $Dist_roletypecode; ?>'))
            //         {
            //             makedropdownempty('instmappingcode', 'Select Insittuion')
            //             $('#instdiv').show();
            //             getdistregioninst_basedondept(roletypecode, deptcode, regioncode, '', 'institution', 'instmappingcode','')
            //         }
            // }
            // else {
            //     $('#distdiv').hide();
            //     $('#regiondiv').hide();
            //     $('#instdiv').hide();
            // } 

            if (
                roletypecode &&
                (roletypecode == '<?php echo $Dist_roletypecode; ?>' || roletypecode == '<?php echo $Re_roletypecode; ?>')
            ) {
           
                if (
                    session_roletypecode == '<?php echo $dga_roletypecode; ?>' ||  session_roletypecode == '<?php echo $Admin_roletypecode; ?>' ||
                    session_roletypecode == '<?php echo $Ho_roletypecode; ?>'
                ) {
                    makedropdownempty('regioncode', 'Select Region');
                    getdistregioninst_basedondept(roletypecode, deptcode, regioncode, distcode, 'region', 'regioncode');
                    $('#regiondiv').show();

                    makedropdownempty('instmappingcode', 'Select Institution');
                    $('#instdiv').show();

                    if (roletypecode == '<?php echo $Dist_roletypecode; ?>') {
                        makedropdownempty('distcode', 'Select District');
                        $('#distdiv').show();
                    } else {
                        $('#distdiv').hide();
                    }
                }

                if (
                    session_roletypecode == '<?php echo $Dist_roletypecode; ?>' || 
                    session_roletypecode == '<?php echo $Re_roletypecode; ?>'
                ) {
                    makedropdownempty('instmappingcode', 'Select Institution');
                    $('#instdiv').show();

                    if (session_roletypecode == '<?php echo $Re_roletypecode; ?>') {
                        if (roletypecode == '<?php echo $Re_roletypecode; ?>') {
                            getdistregioninst_basedondept(
                                roletypecode, deptcode, regioncode, distcode, 'institution', 'instmappingcode', instmappingcode
                            );
                        } else {
                            getdistregioninst_basedondept(
                                roletypecode, deptcode, regioncode, distcode, 'district', 'distcode'
                            );
                        }
                    } else if (session_roletypecode == '<?php echo $Dist_roletypecode; ?>') {
                        getdistregioninst_basedondept(
                            roletypecode, deptcode, regioncode, '', 'institution', 'instmappingcode', instmappingcode
                        );
                    }
                }
            } else {
                $('#distdiv').hide();
                $('#regiondiv').hide();
                $('#instdiv').hide();
            }

        }
        

        function getvaluebasedon_regionroletype(roletypecode, deptcode, regioncode, distcode) {
            if (!roletypecode) roletypecode = $('#roletypecode').val();
            if (!deptcode) deptcode = $('#deptcode').val();
            if (!regioncode) regioncode = $('#regioncode').val();


            if (roletypecode == '<?php echo $Re_roletypecode; ?>') {
                getdistregioninst_basedondept(roletypecode, deptcode, regioncode, '', 'institution', 'instmappingcode','')
            }
            if (roletypecode == '<?php echo $Dist_roletypecode; ?>') {
                getdistregioninst_basedondept(roletypecode, deptcode, regioncode, '', 'district', 'distcode')
            }
        }

        function getdistregioninst_basedondept(roletypecode, deptcode, regioncode, distcode, valuefor, valueforid,instmappingcode) 
        {
            if(valuefor == 'institution')
            {
                if (!roletypecode) roletypecode = $('#roletypecode').val();
                if (!deptcode) deptcode = $('#deptcode').val();
                if (!regioncode) regioncode = $('#regioncode').val();
                if (!distcode) distcode = $('#distcode').val();
            }

            const $dropdown = $("#" + valueforid);

            // Clear existing options and display a "Select" placeholder
            $dropdown.html('<option value="">Select</option>');

            // Make the AJAX request
            $.ajax({
                url: '/getRegionDistInstBasedOnDept',
                type: 'POST',
                data: {
                    roletypecode,
                    deptcode,
                    regioncode,
                    distcode,
                    valuefor,
                    page : 'createcharge',
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                },
                success: function(response) {
                    if (response.success && Array.isArray(response.data)) {

                        // Map the response data into <option> elements
                        const options = response.data.map(item => {
                            switch (valuefor) {
                                case 'region':
                                    return `<option value="${item.regioncode}" ${item.regioncode === regioncode ? "selected" : ""}>${item.regionename}</option>`;
                                case 'district':
                                    return `<option value="${item.distcode}" ${item.distcode === distcode ? "selected" : ""}>${item.distename}</option>`;
                                case 'institution':
                                    return `<option value="${item.instmappingcode}" ${item.instmappingcode === instmappingcode ? "selected" : ""}>${item.instename}</option>`;

                                    // return `<option value="${item.instmappingcode}">${item.instename}</option>`;
                                default:
                                    return '';
                            }
                        }).join('');

                        // Append options to the dropdown
                        $dropdown.append(options || '<option value="">No data available</option>');
                    } else {
                        console.error("Invalid response or no data:", response);
                        $dropdown.append('<option value="">No data available</option>');
                    }
                    updateSelectColorByValue(document.querySelectorAll(".form-select"));
                },
                error: function(xhr) {
                    console.error("Error during AJAX request:", xhr);

                    // Show error message and reset dropdown
                    $dropdown.html('<option value="">Error loading data</option>');
                    passing_alert_value(
                        'Alert',
                        'Error loading data. Please try again.',
                        'confirmation_alert',
                        'alert_header',
                        'alert_body',
                        'confirmation_alert'
                    );
                }
            });
        }



        $("#chargeform").validate({
            rules: {
                deptcode: {
                    required: true,
                },
                roletypecode: {
                    required: true
                },
                desigcode: {
                    required: true
                },
                chargedescription: {
                    required: true
                },
                roleactioncode: {
                    required: true
                },
                regioncode: {
                    required: true
                },
                instmappingcode: {
                    required: true
                },
                distcode: {
                    required: true
                },
            },
            messages: {
                deptcode: {
                    required: "Select a department",
                },
                roletypecode: {
                    required: "Select a roletype",
                },
                desigcode: {
                    required: "Select a designation",
                },
                chargedescription: {
                    required: "Enter a charge description",
                },
                roleactioncode: {
                    required: "Select a role action",
                },
                regioncode: {
                    required: "select a region",
                },
                distcode: {
                    required: "Select a District",
                },
                instmappingcode: {
                    required: "Select a institution",
                },
            }
        });


        $("#buttonaction").on("click", function(event) {
            // Prevent form submission (this stops the page from refreshing)
            event.preventDefault();

            //Trigger the form validation
            if ($("#chargeform").valid()) 
            {
                $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
                 });

                var formData = $('#chargeform').serializeArray();

                
                if (
                    session_roletypecode == '<?php echo $Dist_roletypecode; ?>' || 
                    session_roletypecode == '<?php echo $Re_roletypecode; ?>'
                ) 


                $.ajax({
                    url: '/charge_insertupdate', // URL where the form data will be posted
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            reset_form(); // Reset the form after successful submission
                            passing_alert_value('Confirmation', response.message,
                                'confirmation_alert', 'alert_header', 'alert_body',
                                'confirmation_alert');
                                table.ajax.reload();

                        } else if (response.error) {
                            // Handle errors if needed
                            console.log(response.error);
                        }
                    },
                    error: function(xhr, status, error) {

                        var response = JSON.parse(xhr.responseText);

                        var errorMessage = response.message ||
                            'An unknown error occurred';

                        // Displaying the error message
                        passing_alert_value('Alert', errorMessage, 'confirmation_alert',
                            'alert_header', 'alert_body', 'confirmation_alert');


                        // Optionally, log the error to console for debugging
                        console.error('Error details:', xhr, status, error);
                    }
                });
                
                } else {

                 }

                 
        });

        function reset_form() 
        {
            if (
                session_roletypecode == '<?php echo $Ho_roletypecode; ?>' || 
                session_roletypecode == '<?php echo $Re_roletypecode; ?>' || 
                session_roletypecode == '<?php echo $Dist_roletypecode; ?>'
            ) {
                makedropdownempty('instmappingcode', 'Select Institution');

                if (session_roletypecode == '<?php echo $Ho_roletypecode; ?>') {
                    makedropdownempty('regioncode', 'Select Region');
                    makedropdownempty('distcode', 'Select District');
                } else if (session_roletypecode == '<?php echo $Re_roletypecode; ?>') {
                    makedropdownempty('distcode', 'Select District');
                }
            } else {
                $('#chargeform')[0].reset();
            }


            $('#roletypecode').val('');
            $('chargedescription').val('');
            $('desigcode').val('');
            $('#display_error').hide();
           
            $('#chargeform').validate().resetForm();
            change_button_as_insert('chargeform', 'action', 'buttonaction', 'display_error', '', '');
            updateSelectColorByValue(document.querySelectorAll(".form-select"));
        }

        $(document).ready(function () {
            // Reset form and update select box colors on page load
            $('#chargeform')[0].reset();
            updateSelectColorByValue(document.querySelectorAll(".form-select"));

        });

            // Initialize DataTable
            var table = $('#chargetable').DataTable({
                processing: true,
                serverSide: false,
                lengthChange: false,
                ajax: {
                    url: "/fetchchargeData",
                    type: "POST",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataSrc: function (json) {
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
                    },                    
                },
                columns: [
                    {
                        data: null,
                        render: (_, __, ___, meta) => meta.row + 1, // Serial number column
                        className: 'text-end' // Align to the right
                    },
                    { data: "deptesname" },
                    { data: "roletypeelname" },
                    { data: "regionename" },
                    { data: "distename" },
                    { data: "instename" },
                    { data: "roleactionelname" },
                    { data: "desigesname" },
                    { data: "chargedescription" },
                    {
                        data: "encrypted_chargeid",
                        render: (data) =>
                            `<center>
                                <a class="btn editicon editchargedel" id="${data}">
                                    <i class="ti ti-edit fs-4"></i>
                                </a>
                            </center>`
                    }
                ]
            });
           

            // Handle Edit Button Click
            $(document).on('click', '.editchargedel', function () {
                const id = $(this).attr('id');
                if (id) {
                    reset_form();
                    $('#chargeid').val(id);
                    $.ajax({
                        url: '/fetchchargeData',
                        method: 'POST',
                        data: { chargeid :id  },
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function (response) {
                            if (response.success) {
                                populateChargeForm(response.data[0]);
                            } else {
                                alert('Charge not found');
                            }
                        },
                        error: function (xhr) {
                            console.error('Error:', xhr.responseText || 'Unknown error');
                        }
                    });
                }
            });
       



        // Populate form with fetched charge details
        function populateChargeForm(charge) {
            $('#display_error').hide();
            change_button_as_update('chargeform', 'action', 'buttonaction', 'display_error', '', '');
            $('#deptcode').val(charge.deptcode);
            $('#desigcode').val(charge.desigcode);
            $('#roleactioncode').val(charge.roleactioncode);
            $('#chargedescription').val(charge.chargedescription);
            getroletypecode_basedondept(charge.deptcode, charge.roletypecode);
            //settingform_basedonroletypcode(charge.roletypecode, charge.deptcode, charge.regioncode, charge.distcode,charge.instmappingcode);

            // const roletypeCodes = [`<?php echo $Re_roletypecode; ?>`, `<?php echo $Dist_roletypecode; ?>`];
            // if (roletypeCodes.includes(charge.roletypecode)) {
            //     if (charge.roletypecode === '<?php echo $Dist_roletypecode; ?>') 
            //     {
            //         getdistregioninst_basedondept(charge.roletypecode, charge.deptcode, charge.regioncode, charge.distcode, 'district', 'distcode');
            //     }
            //     getdistregioninst_basedondept(charge.roletypecode, charge.deptcode, charge.regioncode, charge.distcode, 'institution', 'instmappingcode', charge.instmappingcode);
            // }
            updateSelectColorByValue(document.querySelectorAll(".form-select"));
        }

        // Reset form and related UI elements
        function resetForm() {
            const dropdowns = ['roletypecode', 'instmappingcode', 'regioncode', 'distcode'];
            dropdowns.forEach(id => makedropdownempty(id, `Select ${id.replace('code', '')}`));
            $('#display_error').hide();
            $('#chargeform')[0].reset();
            change_button_as_insert('chargeform', 'action', 'buttonaction', 'display_error', '', '');
            updateSelectColorByValue(document.querySelectorAll(".form-select"));
        }


    </script>
@endsection