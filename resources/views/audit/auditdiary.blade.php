@extends('index2')
@section('content')
    <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle;

        }

        input,
        select textarea,
        th {
            font-size: 13px !important;
        }

        .error-msg {
            color: red;
            font-size: 12px;
            display: none;
        }

        .progress-container {
            height: 17px;
            width: 200px;
            vertical-align: middle;
            align: center;
            margin: 0 auto;
        }

        .percentage-label {
            font-size: 20px;
        }

        /**style="background-color: #539bff;padding:10px;" */
    </style>
    @include('common.alert')

    <div class="row">
        <div class="col-12">
            <div class="card" style="border-color: #7198b9">
            <div class="card-header card_header_color">
                    Audit Diary
                </div>
                <div class="card-body">
                    <div>
                        <!-- start File export -->
                        <div>
                            <form id="create_auditdiary" name="create_auditdiary">
                                @csrf
                                @if (sizeof($Workallocated_Category) == 0)
                                    <div id="no_data" class="hide_this" style="display: block;">
                                        <center>No Data Available</center>
                                    </div>
                                @else
                                    <table id="file_export" class="table w-100 table-bordered datatables-basic">
                                        <thead>
                                            <!-- start row -->
                                            <tr>
                                                <th colspan="2">Work Allocation</th>
                                                <th rowspan="2">Date</th>
                                                <th rowspan="2">Action</th>
                                                <th rowspan="2">Percentage</th>
                                            </tr>
                                            <tr>
                                                <th>Main Type</th>
                                                <th>Sub Type</th>
                                            </tr>
                                            <!-- end row -->
                                        </thead>
                                        <tbody>

                                            <input type="hidden" name="actiontype" value="{{ $actiontype }}" />

                                            @foreach ($Workallocated_Category as $workkey => $workval)
                                                <!-- Get the number of subcategories for this category -->
                                                @php
                                                    $subCategoryCount = count($Workallocated_SubCategory[$workkey]);
                                                @endphp
                                                <!-- First row with category and its subcategory -->
                                                <tr>
                                                    <!-- Work Allocation Category Selection with rowspan -->
                                                    @if ($subCategoryCount > 1)
                                                        <td rowspan="{{ $subCategoryCount }}">
                                                            <select disabled class="form-select"
                                                                aria-label="Default select example">
                                                                <option>{{ $workval }}</option>
                                                            </select>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <select disabled class="form-select"
                                                                aria-label="Default select example">
                                                                <option>{{ $workval }}</option>
                                                            </select>
                                                        </td>
                                                    @endif

                                                    <!-- First SubCategory Selection -->
                                                    <td>
                                                        <select disabled class="form-select"
                                                            aria-label="Default select example">
                                                            <?php $i = 0; ?>
                                                            @foreach ($Workallocated_SubCategory[$workkey] as $subCategoryKey => $subCategory)
                                                                <?php
                                                                    if ($i == 0):
                                                                ?>
                                                                <option value="{{ $subCategory }}">{{ $subCategory }}
                                                                </option>
                                                                <?php $i++; ?>
                                                                <!-- Increment $i after the first iteration -->
                                                                <?php endif; ?>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <!-- From Date Selection -->
                                                    <?php $i = 0; ?>
                                                    @foreach ($WorkAllocationId[$workkey] as $WorkAllocKey => $WorkAllocVal)
                                                        <?php
                                                                    if ($i == 0):
                                                                ?>
                                                        <td>
                                                            <input type="hidden" class="workallocationid"
                                                                value="{{ $WorkAllocVal }}"
                                                                name="workallocationid[{{ $WorkAllocVal }}]" />

                                                            <input type="hidden" class="auditdiaryid"
                                                                value="{{ isset($AuditDiaryId[$WorkAllocVal]) ? $AuditDiaryId[$WorkAllocVal] : '' }}"
                                                                name="auditdiaryid[{{ $WorkAllocVal }}]" />
                                                            <div class="input-group">
                                                                <input type="text" name="fromdate[{{ $WorkAllocVal }}]"
                                                                    id="fromdate{{ $WorkAllocVal }}"
                                                                    value="{{ isset($FromDate[$WorkAllocVal]) ? $FromDate[$WorkAllocVal] : '' }}"
                                                                    class="form-control datepicker" autocomplete="off"
                                                                    placeholder="dd-mm-yyyy">
                                                                <span class="input-group-text">
                                                                    <i class="ti ti-calendar fs-5"></i>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <!-- To Date Selection -->
                                                        <!-- <td>
                                                                                <div class="input-group" onclick="datepicker('from_date','')">
                                                                                    <input type="text" name="todate[{{ $WorkAllocVal }}]"
                                                                                        id="todate{{ $WorkAllocVal }}"
                                                                                        value="{{ isset($ToDate[$WorkAllocVal]) ? $ToDate[$WorkAllocVal] : '' }}"
                                                                                        autocomplete="off" class="form-control datepicker"
                                                                                        placeholder="dd-mm-yyyy">
                                                                                    <span class="input-group-text">
                                                                                        <i class="ti ti-calendar fs-5"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </td>-->
                                                        <!-- Remarks TextAre -->
                                                        <td>
                                                            <textarea class="form-control p-4" name="remarks[{{ $WorkAllocVal }}]" id="" cols="20" rows="1"
                                                                placeholder="Add Remarks...">{{ isset($Remarks[$WorkAllocVal]) ? $Remarks[$WorkAllocVal] : '' }}</textarea>
                                                        </td>
                                                        <!-- Percentage -->
                                                        <td>
                                                            <div class="progress progress-container"
                                                                data-uniqid="{{ $WorkAllocVal }}"
                                                                id="progress-container-{{ $WorkAllocVal }}"
                                                                data-min="{{ isset($Percent[$WorkAllocVal]) ? $Percent[$WorkAllocVal] : '0' }}"
                                                                align="center">
                                                                <div class="progress-bar bg-primary"
                                                                    id="progress-bar-{{ $WorkAllocVal }}"
                                                                    role="progressbar"
                                                                    style="width: {{ isset($Percent[$WorkAllocVal]) ? $Percent[$WorkAllocVal] : '0' }}%;"
                                                                    aria-valuenow="{{ isset($Percent[$WorkAllocVal]) ? $Percent[$WorkAllocVal] : '0' }}"
                                                                    aria-valuemin="0" aria-valuemax="100">
                                                                    {{ isset($Percent[$WorkAllocVal]) ? $Percent[$WorkAllocVal] : '0' }}%
                                                                </div>
                                                            </div>
                                                            <input type="hidden"
                                                                class="hiddenpercentagefield_{{ $WorkAllocVal }}"
                                                                value="{{ isset($Percent[$WorkAllocVal]) ? $Percent[$WorkAllocVal] : '0' }}"
                                                                name="percentage[{{ $WorkAllocVal }}]">
                                                        </td>
                                                        <!--<td>
                                                                                <span id="days-difference{{ $WorkAllocVal }}"
                                                                                    class="badge ms-auto text-bg-primary">
                                                                                    {{ isset($NoofDays[$WorkAllocVal]) ? $NoofDays[$WorkAllocVal] : '0' }}
                                                                                </span>
                                                                                <input type="hidden" name="noofdays[{{ $WorkAllocVal }}]"
                                                                                    value="{{ isset($NoofDays[$WorkAllocVal]) ? $NoofDays[$WorkAllocVal] : '' }}"
                                                                                    class="daysdiffhidden{{ $WorkAllocVal }}" />
                                                                            </td>-->
                                                        <?php $i++; ?> <!-- Increment $i after the first iteration -->
                                                        <?php endif; ?>
                                                    @endforeach
                                                </tr>

                                                <!-- Loop through subcategories (excluding the first) -->
                                                @if ($subCategoryCount > 1)
                                                    <?php $j = 0; ?>
                                                    @foreach ($Workallocated_SubCategory[$workkey] as $subCategoryKey => $subCategory)
                                                        <?php
                                                                if ($j > 0):
                                                            ?>
                                                        <!-- Skip the first subcategory as it has already been added in the first row -->
                                                        @php
                                                            $workallocid = $WorkAllocationId[$workkey][$subCategoryKey];
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <select disabled class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option value="{{ $subCategory }}">
                                                                        {{ $subCategory }}</option>
                                                                </select>
                                                            </td>
                                                            <!-- From Date Selection -->
                                                            <td>
                                                                <input type="hidden" class="workallocationid"
                                                                    value="{{ $workallocid }}"
                                                                    name="workallocationid[{{ $workallocid }}]" />

                                                                <input type="hidden" class="auditdiaryid"
                                                                    value="{{ isset($AuditDiaryId[$workallocid]) ? $AuditDiaryId[$workallocid] : '' }}"
                                                                    name="auditdiaryid[{{ $workallocid }}]" />
                                                                <div class="input-group"
                                                                    onclick="datepicker('from_date','')">
                                                                    <input type="text"
                                                                        name="fromdate[{{ $workallocid }}]"
                                                                        id="fromdate{{ $workallocid }}"
                                                                        value="{{ isset($FromDate[$workallocid]) ? $FromDate[$workallocid] : '' }}"
                                                                        autocomplete="off" class="form-control datepicker"
                                                                        placeholder="dd-mm-yyyy">
                                                                    <span class="input-group-text">
                                                                        <i class="ti ti-calendar fs-5"></i>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <!-- To Date Selection -->
                                                            <!--<td>
                                                                                        <div class="input-group"
                                                                                            onclick="datepicker('from_date','')">
                                                                                            <input type="text"
                                                                                                name="todate[{{ $workallocid }}]"
                                                                                                id="todate{{ $workallocid }}"
                                                                                                value="{{ isset($ToDate[$workallocid]) ? $ToDate[$workallocid] : '' }}"
                                                                                                autocomplete="off"
                                                                                                class="form-control datepicker"
                                                                                                placeholder="dd-mm-yyyy">
                                                                                            <span class="input-group-text">
                                                                                                <i class="ti ti-calendar fs-5"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </td>-->
                                                            <!-- Remarks TextAre -->
                                                            <td>
                                                                <textarea class="form-control p-4" name="remarks[{{ $workallocid }}]" id="" cols="20"
                                                                    rows="1" placeholder="Add Remarks...">{{ isset($Remarks[$workallocid]) ? $Remarks[$workallocid] : '' }}</textarea>
                                                            </td>
                                                            <!-- Percentage -->
                                                            <td>
                                                                <div class="progress progress-container"
                                                                    data-uniqid="{{ $workallocid }}"
                                                                    id="progress-container-{{ $workallocid }}"
                                                                    data-min="{{ isset($Percent[$workallocid]) ? $Percent[$workallocid] : '0' }}">
                                                                    <div class="progress-bar bg-primary"
                                                                        id="progress-bar-{{ $workallocid }}"
                                                                        role="progressbar"
                                                                        style="width: {{ isset($Percent[$workallocid]) ? $Percent[$workallocid] : '0' }}%;"
                                                                        aria-valuenow="{{ isset($Percent[$workallocid]) ? $Percent[$workallocid] : '0' }}"
                                                                        aria-valuemin="0" aria-valuemax="100">
                                                                        {{ isset($Percent[$workallocid]) ? $Percent[$workallocid] : '0' }}%
                                                                    </div>
                                                                </div>
                                                                <input type="hidden"
                                                                    class="hiddenpercentagefield_{{ $workallocid }}"
                                                                    value="{{ isset($Percent[$workallocid]) ? $Percent[$workallocid] : '0' }}"
                                                                    name="percentage[{{ $workallocid }}]">

                                                            </td>
                                                            <!--<td>
                                                                                        <span id="days-difference{{ $workallocid }}"
                                                                                            class="badge ms-auto text-bg-primary">{{ isset($NoofDays[$workallocid]) ? $NoofDays[$workallocid] : '0' }}</span>
                                                                                        <input type="hidden"
                                                                                            value="{{ isset($NoofDays[$workallocid]) ? $NoofDays[$workallocid] : '' }}"
                                                                                            name="noofdays[{{ $workallocid }}]"
                                                                                            class="daysdiffhidden{{ $workallocid }}" />

                                                                                    </td>-->
                                                        </tr>
                                                        <!-- Increment $i after the first iteration -->
                                                        <?php endif; ?>
                                                        <?php $j++; ?>
                                                    @endforeach
                                                @endif
                                            @endforeach

                                        </tbody>

                                    </table>
                                    <div class="row">
                                        <div class="col-md-2 mx-auto">
                                            <div class="d-flex align-items-center gap-6">
                                                <button type="submit" id="submitbtn"
                                                    class="btn btn-primary">Submit</button>
                                                <button type="button"
                                                    class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card" style="border-color: #7198b9">
                <div class="card-header card_header_color">
                    Audit Diary Details
                </div>
                <div class="card-body">

                    <div class="datatables ">
                        <!-- start File export -->
                        <div class="card" style="border-color: #7198b9">
                            <div class="card-body">
                                <div id="datatable" class="table-responsive hide_this">
                                    <table id="file_export"
                                        class="table w-100 table-striped table-bordered display text-nowrap datatables-basic diarytable">
                                        <thead>
                                            <!-- start row -->
                                            <tr>
                                                <th>Work Allocation Main Type</th>
                                                <th>Work Allocation Sub Type</th>
                                                <th>Date</th>
                                                <th>Remarks</th>
                                                <th>Percentage</th>
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
        <div align="right" class="btn-container">
            <a class="btn btn-primary"><i class="fa fa-download"></i>  Download Excel</a>
        </div>
        </script>
        <script src="../assets/js/datatable/datatable-advanced.init.js"></script>
        <script src="../assets/js/jquery_3.7.1.js"></script>
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="../assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <script src="../assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <script>
            $(document).ready(function() {
                var table = $('.diarytable').DataTable({
                    "processing": true,
                    "serverSide": false,
                    "autoWidth": false, // Disable auto-width calculation
                    "scrollX": true, // Enable horizontal scrolling
                    "ajax": {
                        "url": "/auditdiary/fetchAllData", // Your API route for fetching data
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
                            "data": "majorworkallocationtypeename"
                        },
                        {
                            "data": "subworkallocationtypeename"
                        },
                        {
                            "data": "fromdate"
                        },
                        {
                            "data": "remarks"
                        },
                        {
                            "data": "percentofcompletion"
                        }

                    ]
                });
                // Click event for each progress container
                $('.progress-container').click(function(event) {
                    // Get the minimum value for the progress bar from data-min attribute
                    const minVal = parseInt($(this).data('min'), 10);
                    const uniqid = $(this).data('uniqid');
                    const containerWidth = $(this).width();
                    const clickPosition = event.offsetX;

                    // Calculate the percentage based on where the user clicked
                    let percentage = Math.round((clickPosition / containerWidth) * 100);

                    // Ensure the percentage is between the minVal and 100
                    percentage = Math.max(minVal, Math.min(percentage, 100));

                    // Update the progress bar width and percentage text
                    const progressBar = $(this).find('.progress-bar');
                    progressBar.width(percentage + '%');
                    progressBar.attr('aria-valuenow', percentage);
                    progressBar.text(percentage + '%');
                    $('.hiddenpercentagefield_' + uniqid + '').val(percentage);
                });
            });

            $(document).ready(function() {
                $('.datepicker').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    startDate: new Date(),
                }).on('changeDate', function() {
                    $(this).datepicker('hide');
                });
            });


            /*function validatePercentages(index) {
                var inputvalue = $('#percentage' + index + '').val();
                //$('.error-msg').hide();
                if (inputvalue != '') {
                    if (isValidPercentage(inputvalue)) {
                        $('#error-msg' + index + '').hide();
                        enableSubmitButton();

                    } else {
                        $('#error-msg' + index + '').show();
                        $('#submitbtn').prop('disabled', true);

                    }

                }


            }

            function enableSubmitButton() {
                // Check if there are any visible error messages on the page
                var hasError = false;
                $('.error-msg').each(function() {
                    if ($(this).is(':visible')) {
                        hasError = true; // If any error message is visible, there is an error
                    }
                });

                // Enable the submit button only if there are no visible error messages
                if (!hasError) {
                    $('#submitbtn').prop('disabled', false);
                }
            }*/


            // Function to validate percentage (between 0 and 100)
            /*function isValidPercentage(value) {
                const num = parseFloat(value);
                return !isNaN(num) && num >= 0 && num <= 100;
            }*/


            $('#create_auditdiary').on('submit', function(e) {
                e.preventDefault(); // Prevents the default form submission
                // Collect form data
                var formData = $(this).serialize(); // Serialize the form data for submission

                // You can send the data to the server using AJAX
                $.ajax({
                    url: '/audit_diary/insert', // Replace with your actual server endpoint
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            passing_alert_value('Confirmation', response.success,
                                'confirmation_alert', 'alert_header', 'alert_body',
                                'confirmation_alert');
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
            });

            $('#ok_button').on('click', function() {
                location.reload();
            });



            function splitdate(dateString) {
                // Split the input date string (dd-mm-yyyy) into an array [dd, mm, yyyy]
                var dateParts = dateString.split('-');

                // Convert to yyyy-mm-dd format
                if (dateParts.length === 3) {
                    var formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];
                }
                return formattedDate;
            }

            function calculateDaysDifference(index) {
                // Get the dates from the input fields
                var fromDate = splitdate($('#fromdate' + index + '').val());
                var toDate = splitdate($('#todate' + index + '').val());

                if (fromDate && toDate) {
                    // Convert the dates into JavaScript Date objects
                    var startDate = new Date(fromDate);
                    var endDate = new Date(toDate);

                    // Calculate the difference in time (in milliseconds)
                    var timeDifference = endDate - startDate;

                    // Convert the difference into days
                    //var dayDifference = timeDifference / (1000 * 3600 * 24);
                    var dayDifference = (timeDifference / (1000 * 3600 * 24)) + 1;

                    // Update the display with the number of days
                    $('#days-difference' + index + '').text(Math.abs(
                        dayDifference)); // Use Math.abs() to always show positive value
                    $('.daysdiffhidden' + index + '').val(Math.abs(dayDifference));
                }
            }

            // Attach the change event to all fromdate and todate inputs dynamically
            $(document).on('change', '[id^=fromdate], [id^=todate]', function() {
                // Get the index of the changed field by extracting the number from the ID
                var index = $(this).attr('id').replace(/\D/g,
                    ''); // Extract the number from the ID (e.g., 'fromdate1' -> '1')

                // Calculate days difference for this index
                calculateDaysDifference(index);
            });
        </script>
    @endsection
