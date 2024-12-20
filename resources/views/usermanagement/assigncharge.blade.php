@extends('index2')
@section('content')

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


    <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <h4 class="card-title mb-0">Assign Charge</h4>
                </div>
                <div class="card-body">
                    <form>


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
                                <select class="form-select mr-sm-2" id="instmappingcode" name="instmappingcode" onchange="getdesignation_chargedet()">
                                    <option value="">Select Institution</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required" for="validationDefault01">Designation </label>
                                <select class="form-select mr-sm-2" id="desigcode" name="desigcode" onchange="getchargedescription()">
                                    <option value=''>Select Designation</option>
                                    @foreach ($designation as $department)
                                        <option value="{{ $department->desigcode }}">
                                            {{ $department->desigelname }} <!-- Display any field you need -->
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationDefault02">Charge </label>
                                <select class="form-select mr-sm-2" id="chargedescription" name="chargedescription">
                                    <option value=''>Select Charge</option>
                               

                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationDefaultUsername">User</label>
                                <select class="form-select mr-sm-2" id="user">
                                    <option value>Select User</option>
                                </select>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationDefaultUsername">Charge From Date</label>
                                <input type="date" class="form-control" id ="cod" name="cod" disabled />

                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-4  mx-auto">
                                <button class="btn btn-success mt-3" type="submit">
                                    Submit
                                </button>
                                <button class="btn btn-danger mt-3" type="submit">
                                    Cancel
                                </button>

                            </div>

                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
    <script src="../assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="../assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="../assets/js/vendor.min.js"></script>
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
                        'page'  :   'assigncharge',
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
                getdesignation_chargedet()
            }

            getuserbasedonroletype()

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
                    page : 'assigncharge',
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


        function getdesignation_chargedet() 
        {
            const deptcode = $('#deptcode').val();
            const roletypecode = $('#roletypecode').val();
            const regioncode = $('#regioncode').val();
            const distcode = $('#distcode').val();
            const instmappingcode = $('#instmappingcode').val();
            const $dropdown = $('#desigcode'); // Assuming the dropdown ID is `desigcode`

            // Clear the dropdown before making the AJAX call
            $dropdown.html('<option value="">Loading...</option>');

            $.ajax({
                url: '/getdesignation_fromchargedet',
                type: 'POST',
                data: {
                    deptcode: deptcode,
                    roletypecode: roletypecode,
                    regioncode: regioncode,
                    distcode: distcode,
                    instmappingcode: instmappingcode,
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                },
                success: function(response) {
                    $dropdown.empty(); // Clear previous options
                    $dropdown.html('<option value="">Select</option>');

                    if (response.success && Array.isArray(response.data)) {
                        // Map the response data into <option> elements
                        const options = response.data.map(item => {
                            return `<option value="${item.desigcode}">${item.desigelname}</option>`;
                        }).join('');

                        // Append options to the dropdown
                        $dropdown.append(options || '<option value="">No data available</option>');
                    } else {
                        console.error("Invalid response or no data:", response);
                        $dropdown.append('<option value="">No data available</option>');
                    }

                    // Update select color
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


        function getchargedescription() 
        {
            const deptcode = $('#deptcode').val();
            const roletypecode = $('#roletypecode').val();
            const regioncode = $('#regioncode').val();
            const distcode = $('#distcode').val();
            const instmappingcode = $('#instmappingcode').val();
            const desigcode = $('#desigcode').val();
            const $dropdown = $('#chargedescription'); // Assuming the dropdown ID is `desigcode`

            // Clear the dropdown before making the AJAX call
            $dropdown.html('<option value="">Loading...</option>');

            $.ajax({
                url: '/getchargedescription',
                type: 'POST',
                data: {
                    deptcode: deptcode,
                    roletypecode: roletypecode,
                    regioncode: regioncode,
                    distcode: distcode,
                    instmappingcode: instmappingcode,
                    desigcode:desigcode,
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                },
                success: function(response) {
                    $dropdown.empty(); // Clear previous options
                    $dropdown.html('<option value="">Select</option>');

                    if (response.success && Array.isArray(response.data)) {
                        // Map the response data into <option> elements
                        const options = response.data.map(item => {
                            return `<option value="${item.chargeid}">${item.chargedescription}</option>`;
                        }).join('');

                        // Append options to the dropdown
                        $dropdown.append(options || '<option value="">No data available</option>');
                    } else {
                        console.error("Invalid response or no data:", response);
                        $dropdown.append('<option value="">No data available</option>');
                    }

                    // Update select color
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


        function getuserbasedonroletype() 
        {
            const roletypecode = $('#roletypecode').val();
            const $dropdown = $('#user'); // Assuming the dropdown ID is `desigcode`

            // Clear the dropdown before making the AJAX call
            $dropdown.html('<option value="">Loading...</option>');

            $.ajax({
                url: '/getuserbasedonroletype',
                type: 'POST',
                data: {
                    roletypecode: roletypecode,
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                },
                success: function(response) {
                    $dropdown.empty(); // Clear previous options
                    $dropdown.html('<option value="">Select</option>');

                    if (response.success && Array.isArray(response.data)) {
                        // Map the response data into <option> elements
                        const options = response.data.map(item => {
                            return `<option value="${item.chargeid}">${item.chargedescription}</option>`;
                        }).join('');

                        // Append options to the dropdown
                        $dropdown.append(options || '<option value="">No data available</option>');
                    } else {
                        console.error("Invalid response or no data:", response);
                        $dropdown.append('<option value="">No data available</option>');
                    }

                    // Update select color
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





</script>

    @endsection
