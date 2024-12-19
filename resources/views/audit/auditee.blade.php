@section('content')
    @extends('index2')
    @include('common.alert')
    <style>
        .list-group-item:nth-child(odd) {
            background-color: white;
        }

        .list-group-item:nth-child(even) {
            background-color: #ebf3fe;
            /* Light grey */
        }

        .list-group-item:hover {
            background-color: #809fff;
            /* Light grey */
        }

        .list-group-item:hover {
            cursor: pointer;
            /* Light grey */
        }

        .card-body {
            padding: 10px 10px;
        }

        .card {
            margin-bottom: 2px;
        }

        #wizard_NavBar {
            align: center;
        }

        #wizard_NavBar .nav-item {
            border: 1px solid #eaeff4;
            border-radius: 10px;
            background-color: #eaeff4;
        }

        #wizard_NavBar .nav-item active {
            border: none;

        }

        .callforrecords_th {
            background-color: #eaeff4 !important;
            color: black !important;
            padding: 10px !important;
        }

        /*.ressts
            {
                width:10% !important;
                text-align:center !important;
            }*/
    </style>
    <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <div class="row">
        <div class="card" style="border-color: #7198b9">
            <div class="card-body">
                <div class="">
                    <ul id="wizard_NavBar" class="nav nav-pills p-3 mb-3 rounded card flex-row  justify-content-center"
                        style="border: 1px solid #7198b9;">
                        <li class="col-md-4 nav-item">
                            <a href="javascript:void(0)"
                                class="nav-link gap-6 note-link d-flex align-items-center justify-content-center active"
                                id="all-category">
                                <i class="ti ti-list fill-white"></i>
                                <span class="d-none d-md-block fw-medium">Intimation</span>
                            </a>
                        </li>
                        <li style="width:10px;"></li>
                        <li class="nav-item col-md-4">
                            <a href="javascript:void(0)"
                                class="nav-link gap-6 note-link d-flex align-items-center justify-content-center disabled"
                                id="details-tab">
                                <i class="ti ti-briefcase fill-white"></i>
                                <span class="d-none d-md-block fw-medium">Records</span>
                            </a>
                        </li>
                        {{-- <li class="nav-item ms-auto">
                            <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center px-3 gap-6"
                                id="add-notes">
                                <i class="ti ti-file fs-4"></i>
                                <span class="d-none d-md-block fw-medium fs-3">Add Notes</span>
                            </a>
                        </li> --}}
                    </ul>

                    <div class="tab-content">

                        <div id="note-full-container" class="note-has-grid row">
                            <div class="single-note-item all-category">

                                <div class="card mt-2" style="border-color: #7198b9">
                                    <div class="card-header" id="inst_name"></div>
                                    <div class="card-body">


                                        <div class="row">
                                            <div class="col-md-4 ">
                                                <label class="form-label" for="validationDefault02">Entry Meeting
                                                    date</label>
                                                <div class="input-group" onclick="datepicker('entry_date','')">
                                                    <input type="text" class="form-control datepicker" id="entry_date"
                                                        name="entry_date" placeholder="dd/mm/yyyy" disabled />
                                                    <span class="input-group-text">
                                                        <i class="ti ti-calendar fs-5"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label style="text-align:center;" align="center" class="form-label"
                                                    for="validationDefault02">Proposed Date</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <label class="form-label" for="validationDefault02">From
                                                                Date&nbsp;&nbsp; : &nbsp;&nbsp;</label>
                                                            <input type="text" class="form-control" id="start_date"
                                                                name="start_date" placeholder="dd/mm/yyyy" disabled />
                                                            <span class="input-group-text">
                                                                <i class="ti ti-calendar fs-5"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <label class="form-label" for="validationDefault02">To
                                                                Date&nbsp;&nbsp; : &nbsp;&nbsp;</label>
                                                            <input type="text" class="form-control" id="end_date"
                                                                name="end_date" placeholder="dd/mm/yyyy" disabled />
                                                            <span class="input-group-text">
                                                                <i class="ti ti-calendar fs-5"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="validationDefault02">Audit Type</label>
                                                <input type="text" class="form-control" value="Financial" id="audit_type"
                                                    name="audit_type" disabled />
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="validationDefault02">Audit Year</label>
                                                <input type="text" class="form-control" id="financial_year"
                                                    name="financial_year" disabled />
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="validationDefault02">Quarter</label>
                                                <input type="text" class="form-control"
                                                    value="Quarter4 (January 2024- March 2024)" id="audit_period"
                                                    name="audit_period" disabled />
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label" for="validationDefault02">Audit Team
                                                    Head</label>
                                                <select class="select2 form-control custom-select" multiple="multiple"
                                                    id="tm_hid" name="tm_hid" aria-placeholder="Select Member"
                                                    disabled>


                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="validationDefault02">Audit Team
                                                    Member</label>
                                                <select class="select2 form-control custom-select" multiple="multiple"
                                                    id="tm_uid" name="tm_uid[]" aria-placeholder="Select Member"
                                                    disabled>


                                                </select>
                                            </div>
                                        </div>
                                        <div id="statusmessage" class="row  hide_this">
                                            <div class="col-md-8 ms-4 mt-4"><span class="required"></span>
                                                Data has been submitted successfully.
                                            </div>
                                        </div>
                                        <div id="buttonsforacceptance" class="row justify-content-center">
                                            <div class="col-md-8 ms-auto mt-4">
                                                <button type="button " class="btn btn-success" data-bs-toggle="modal"
                                                    id="accept" data-bs-target="#success-header-modal"
                                                    onclick="show_div('accept')">
                                                    <i class="ti ti-circle-check"><span class="ms-2">
                                                            Accepted</span>
                                                    </i>
                                                </button>



                                                <button type="button " class="btn btn-primary  " data-bs-toggle="modal"
                                                    id="partially_accept" data-bs-target="#success-header-modal"
                                                    onclick="show_div('date_change')">
                                                    <i class="ti ti-replace "> <span class="ms-2">Partially Accepted
                                                        </span>
                                                    </i>
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" id="actionformtype"
                                            name="actionformtype" value="insertform">
                                        <input type="hidden" class="form-control" id="auditscheduleidNewforGet"
                                            name="auditscheduleidNewforGet">
                                        <form id="auditee_partial" name="auditee_partial">
                                            @csrf
                                            <input type="hidden" class="form-control" id="audit_scheduleid"
                                                name="audit_scheduleid">
                                            <div class="row mt-4 date_change" style="display:none">
                                                <div class="col-md-3">
                                                    <label class="form-label" for="validationDefault02">Date</label>
                                                    <div class="input-group" onclick="datepicker('change_date','')">
                                                        <input type="text" class="form-control datepicker"
                                                            id="change_date" name="change_date"
                                                            placeholder="dd/mm/yyyy" />
                                                        <span class="input-group-text">
                                                            <i class="ti ti-calendar fs-5"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">

                                                    <div class="mb-3">
                                                        <label class="form-label" for="message-text"
                                                            class="">Remarks</label>
                                                        <textarea class="form-control" id="part_remarks" name="part_remarks"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2  mx-auto">

                                                        <button class="btn btn-success mt-3" type="submit"
                                                            action="update" id="buttonaction" name="buttonaction">
                                                            Submit
                                                        </button>
                                                        <button class="btn btn-danger mt-3" type="submit">
                                                            Cancel
                                                        </button>

                                                    </div>

                                                </div>
                                            </div>



                                    </div>

                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="details-section" class="tab-pane fade">
                        <div class="card" style="border-color: #7198b9">

                            <div class="card-body">

                                <form id="callforrecords" name="callforrecords">
                                    <input type="hidden" class="form-control" id="audit_scheduleid"
                                        name="auditscheduleid">
                                    <h5 class="mt-2">Audit Particulars</h5>
                                    <div class="table-responsive rounded-4">
                                        <table class="table table-bordered">
                                            <tbody id="part_details"></tbody>
                                        </table>
                                        <table class="table table-bordered">
                                            <tbody id="part_details_fetch"></tbody>
                                        </table>


                                    </div>
                                    <div id="details_tabletab_buttons" class="row">
                                        <div class="col-md-2  mx-auto">
                                            <button class="btn btn-success mt-3 " type="submit" action="insert"
                                                id="buttonaccept" name="buttonaccept">
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
            </div>
        </div>

    </div>
    </div>

    </div>
    </div>

    </body>

    <script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>
    {{-- <script src="../assets/js/vendor.min.js"></script> --}}
    <script src="../assets/js/jquery_3.7.1.js"></script>
    <script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="../assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="../assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="../assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="../assets/js/forms/select2.init.js"></script>
    <script src="../assets/js/apps/notes.js"></script>



    <script>
        // Function to handle the visibility and toggling of tabs
        function show_div(reply, edit = '') {
            const detailsTab = document.getElementById('details-tab');
            const detailsContent = document.getElementById('details-section'); // Target content for Details tab

            if (reply === 'not_accept') {
                // Show "Not Accept" section and hide others
                $('.not_accept').show();
                $('.date_change').hide();
            } else if (reply === 'date_change') {
                // Show "Date Change" section and hide others
                $('.not_accept').hide();
                $('.date_change').show();
            } else if (reply === 'accept') {
                if (edit == 'edit') {
                    var audit_scheduleidget = $('#auditscheduleidNewforGet').val();
                    acceptstatus(audit_scheduleidget);

                } else {
                    fetch_audit_particulars_detail();

                }
                // Enable and navigate to "Details" tab
                detailsTab.classList.remove('disabled');
                detailsTab.setAttribute('href', '#details-section'); // Add target content
                detailsTab.setAttribute('data-bs-toggle', 'tab'); // Enable Bootstrap tab

                // Redirect to the "Details" tab
                detailsTab.click();
                detailsContent.style.display = 'block';
                detailsContent.classList.add('show', 'active'); // Make it "active" for Bootstrap tab

            }
        }
        // Function to reset the "Details" tab when returning to the "Intimation" screen
        document.getElementById('all-category').addEventListener('click', function() {

            const detailsTab = document.getElementById('details-tab');
            const detailsContent = document.getElementById('details-section');

            // Disable the "Details" tab
            var formtype = $('#actionformtype').val();
            if (formtype != 'editform') {
                // Disable the "Details" tab
                detailsTab.classList.add('disabled');

            }
            detailsTab.removeAttribute('href');
            detailsTab.removeAttribute('data-bs-toggle');

            // Hide the content of the "Details" tab
            if (detailsContent) {

                detailsContent.style.display = 'none';
            }
        });

        function fetch_audit_particulars_detail() {

            $.ajax({
                url: 'audit/audit_particulars', // Replace with your endpoint
                method: 'GET',

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Pass CSRF token in headers
                },
                success: function(response) {
                    populateTable(response);
                },
                error: function() {
                    alert("Failed to fetch team members!");
                }
            });
        }

        function populateTable(response) {

const tableBody = $('#part_details'); // Select the table's tbody
tableBody.empty(); // Clear existing rows

// Group rows by 'majorworkallocationtypeename'
const groupedData = response.data.reduce((acc, item) => {
    if (!acc[item.majorworkallocationtypeename]) {
        acc[item.majorworkallocationtypeename] = [];
    }
    acc[item.majorworkallocationtypeename].push(item);
    return acc;
}, {});

const accountParticulars = response.account_particulars.reduce((acc, item) => {
    if (!acc[item.accountparticularsename]) {
        acc[item.accountparticularsename] = [];
    }
    acc[item.accountparticularsename].push(item);
    return acc;
}, {});

// Calculate the total number of rows in the table
const totalRows = Object.values(groupedData).reduce((sum, group) => sum + group.length, 0);
const accountTotalRows = Object.values(accountParticulars).reduce((sum, group) => sum + group.length, 0);

// Start the table with "Call for Records" and "Account Particulars" as row headers
let tableHTML = `<tr>
                    <th rowspan="${accountTotalRows + 2}" class="">Availability of  Account Particulars</th>
                </tr>
                <tr>
                    <th class="callforrecords_th">Type</th>
                    <th class="callforrecords_th ressts">Response Status</th>
                    <th class="callforrecords_th">
                        <div>
                            <label class="form-label required" for="validationDefault01">File Upload&nbsp;&nbsp;<Label>
                            <span style="color:red;font-weight:300;">(&nbsp;&nbsp;File size must not exceed 1 MB&nbsp;&nbsp;)</span>
                        </div>
                    </th>
                    <th class="callforrecords_th">
                        <div>
                            <label class="form-label required" >Remarks</label>
                        </div>
                    </th>
                </tr>`;

// Iterate over account particulars and create rows
for (const [accountParticularsName, accountParts] of Object.entries(accountParticulars)) {
    const accountRowSpan = accountParts.length; // Number of subcategories under the account category

    accountParts.forEach((accountParticular, index) => {
        tableHTML += `
<tr>

<td>${accountParticular.accountparticularsename}
<input type="hidden" id="${accountParticular.accountparticularsid}-accountcode" name="${accountParticular.accountparticularsid}-accountcode" value="${accountParticular.accountparticularsid}"></td> <!-- Account Item -->
<td>
<div class="col-md-12">
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="${accountParticular.accountparticularsid}-radio"
            id="${accountParticular.accountparticularsid}-radio" value="Y"
            onclick="toggleAttachment('${accountParticular.accountparticularsid}', true)" />
        <label class="form-check-label" for="account-${accountParticular.accountparticularsid}-yes">Yes</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="${accountParticular.accountparticularsid}-radio"
            id="${accountParticular.accountparticularsid}-radio" value="N"
            onclick="toggleAttachment('${accountParticular.accountparticularsid}', false)" />
        <label class="form-check-label" for="${accountParticular.accountparticularsid}-no">No</label>
    </div>
</div>
</td>
    <td>
           <div id="${accountParticular.accountparticularsid}-attachment" name="${accountParticular.accountparticularsid}-file " style="padding:10px;">

               <input type="file" class="form-control"
                   id="${accountParticular.accountparticularsid}-attachment" name="${accountParticular.accountparticularsid}-accountfile">

           </div>

       </td>

<td style="padding:10px;">
<textarea id="account-${accountParticular.accountparticularsid}" name="${accountParticular.accountparticularsid}-accountvalues" class="form-control" placeholder="Enter remarks"></textarea>
</td>
</tr>

`;
    });
}


// Call for Records Section
tableHTML += `<tr>
                 <th rowspan="${totalRows+ 2}" >Call For Records</th>
              </tr>
              <tr>
                 <th class="callforrecords_th">Major Type</th>
                 <th class="callforrecords_th">Sub Type</th>
                 <th class="callforrecords_th ressts">Response Status</th>
                 <th class="callforrecords_th">Remarks</th>
              </tr>`;



// Iterate over grouped data (major work and subcategories) to create rows
for (const [majorWork, subWorks] of Object.entries(groupedData)) {
    const rowSpan = subWorks.length; // Number of subcategories under the major category

    subWorks.forEach((subWork, index) => {
        tableHTML += `
<tr>
    ${index === 0 ? `<td rowspan="${rowSpan}" >${majorWork}</td>` : ''} <!-- Major Work -->
    <td>${subWork.subworkallocationtypeename}
    <input type="hidden" id="${subWork.subworkallocationtypeid}-cfrcode" name="${subWork.subworkallocationtypeid}-cfrcode" value="${subWork.subworkallocationtypeid}"></td> <!-- Sub Work -->
    <td>
        <div class="col-md-12">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="${subWork.subworkallocationtypeid}-cfrradio"
                    id="${subWork.subworkallocationtypeid}-cfrradio" value="Y"
                  />
                <label class="form-check-label" for="Sub${subWork.subworkallocationtypeid}-yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="${subWork.subworkallocationtypeid}-cfrradio"
                    id="${subWork.subworkallocationtypeid}-cfrradio" value="N"
                    />
                <label class="form-check-label" for="Sub${subWork.subworkallocationtypeid}-no">No</label>
            </div>
        </div>
    </td>
    <td style="padding:10px;">
        <textarea id="${subWork.subworkallocationtypeid}" name="${subWork.subworkallocationtypeid}-cfrvalues" class="form-control" placeholder="Enter remarks"></textarea>
    </td>
</tr>
`;
    });
}

// Add Nodal Person and Remarks
tableHTML += `
<tr>
<th>Nodal Person</th>
<td colspan="4">
 <div class="row">
    <div class="col-md-6">
       <label class="form-label required" for="nodal_name">Name</label>
       <input type="text" class="form-control " id="nodalname" name="nodalname" placeholder="Enter Name"  />
    </div>
    <div class="col-md-6">
       <label class="form-label required" for="mobile">Mobile Number</label>
       <input type="text" class= "form-control only_numbers" id="nodalmobile" name="nodalmobile" placeholder="Enter Mobile Number" maxlength = 10 />
    </div>
</div><br>
<div class="row">
    <div class="col-md-6">
        <label class="form-label required" for="mobile">Email</label>
        <input type="text" class="form-control" id="nodalemail" name="nodalemail" placeholder="Enter Email"  />
    </div>
    <div class="col-md-6">
        <label class="form-label required" for="mobile">Designation</label>
        <input type="text" class="form-control" id="nodaldesignation" name="nodaldesignation" placeholder="Enter Designation"  />
    </div>
</div>
<br>
</td>
</tr>
<tr>
<th>Remarks</th>
<td colspan="4">
<div class="col-md-12">
    <label class="form-label required" for="remarks">Remarks</label>
    <textarea id="auditee_remarks" name="auditee_remarks" class="form-control" placeholder="Enter remarks"></textarea>
</div><br>
</td>
</tr>
`;

// Append the generated table HTML to the table body
tableBody.html(tableHTML);

}

        function addDynamicValidation(accountParticularId) {
            // Add validation for file input
            $(`#${accountParticularId}-attachment input[type="file"]`).rules("add", {
                required: true,
                accept: "pdf|jpg|jpeg|png",
                messages: {
                    required: "File upload is required",
                    accept: "Only PDF, JPG, or PNG files are allowed",
                },
            });

            // Add validation for remarks textarea
            $(`#account-${accountParticularId}`).rules("add", {
                required: true,
                minlength: 5,
                messages: {
                    required: "Remarks are required",
                    minlength: "Remarks must be at least 5 characters long",
                },
            });
        }

        function toggleAttachment(name, isYes) {

            // Show attachment button if "Yes" is clicked
            const attachmentBtn = document.getElementById(`${name}-attachment`);
            const remarksField = document.getElementById(`${name}-remarks`);

            if (isYes) {
                attachmentBtn.style.display = "inline-block";
                remarksField.style.display = "none";
            } else {
                attachmentBtn.style.display = "none";
                // remarksField.style.display = "block";
            }
        }

        function importData() {
            let input = document.createElement('input');
            input.type = 'file';
            input.onchange = _ => {
                // you can use this method to get file and perform respective operations
                let files = Array.from(input.files);
                console.log(files);
            };
            input.click();

        }

        function datepicker(value, setdate) {
            var today = new Date();
            if (value == 'entry_date') {
                // Calculate the minimum date (18 years ago)
                var maxDate = new Date(today);
                maxDate.setMonth(today.getMonth() + 4);

                // Calculate the maximum date (60 years ago)
                var minDate = today;
            }
            if (value == 'change_date') {
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

        /***********************************Jquery Form Validation **********************************************/

        const $auditee_partialForm = $("#auditee_partial");
        const $callforrecordsForm = $("#callforrecords");
        // Validation rules and messages
        $auditee_partialForm.validate({
            rules: {

                change_date: {
                    required: true,
                },
                part_remarks: {
                    required: true,
                },



            },
            messages: {
                change_date: {
                    required: "Select Date ",
                },
                part_remarks: {
                    required: "Select Remarks ",
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

            }
        });



        // callforrecordsForm.validate({
        //     rules: {
        //         nodalname: {
        //             required: true,

        //         },
        //         nodalmobile: {
        //             required: true,
        //             digits: true,
        //             minlength: 10,
        //             maxlength: 10,
        //         },
        //         nodalemail: {
        //             required: true,
        //             email: true,
        //         },
        //         nodaldesignation: {
        //             required: true,
        //         },
        //         auditee_remarks: {
        //             required: true,
        //             minlength: 10,
        //         },
        //     },
        //     messages: {
        //         nodalname: {
        //             required: "Name is required",

        //         },
        //         nodalmobile: {
        //             required: "Mobile number is required",
        //             digits: "Enter a valid mobile number",
        //             minlength: "Must be 10 digits",
        //             maxlength: "Must be 10 digits",
        //         },
        //         nodalemail: {
        //             required: "Email is required",
        //             email: "Enter a valid email address",
        //         },
        //         nodaldesignation: {
        //             required: "Designation is required",
        //         },
        //         auditee_remarks: {
        //             required: "Remarks are required",
        //             minlength: "Remarks must be at least 10 characters long",
        //         },
        //     },
        //     errorPlacement: function(error, element) {
        //         // For datepicker fields inside input-group, place error below the input group
        //         if (element.hasClass('datepicker')) {
        //             // Insert the error message after the input-group, so it appears below the input and icon
        //             error.insertAfter(element.closest('.input-group'));
        //         } else {
        //             // For other elements, insert the error after the element itself
        //             error.insertAfter(element);
        //         }

        //     }
        // });

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

        $(document).on('click', '#buttonaction', function(event) {
            event.preventDefault(); // Prevent form submission

            passing_alert_value('Confirmation', 'Are you sure to Submit?', 'confirmation_alert',
                'alert_header', 'alert_body', 'forward_alert');
            $("#process_button").html("Ok");
            $("#process_button").addClass("button_Partial_confirmation");
            $('#process_button').removeAttr('data-bs-dismiss');
            $('.button_Partial_confirmation').data('auditplanid', auditplanid);
        });

        $(document).on('click', '.button_Partial_confirmation', function() {
            // alert();
            if ($auditee_partialForm.valid()) {
                get_insertdata();
            } else {
                scrollToFirstError();
            }
        });

        $(document).on('click', '#buttonaccept', function(event) {
            event.preventDefault(); // Prevent form submission

            passing_alert_value('Confirmation', 'Are you sure to Submit?', 'confirmation_alert',
                'alert_header', 'alert_body', 'forward_alert');
            $("#process_button").html("Ok");
            $("#process_button").addClass("button_confirmation");
            $('#process_button').removeAttr('data-bs-dismiss');
            $('.button_confirmation').data('auditplanid', auditplanid);
        });

        $(document).on('click', '.button_confirmation', function() {

            // if ($callforrecordsForm.valid()) {
            $('#callforrecords').append(
                `<input type="hidden" name="auditscheduleid" value="${$('#audit_scheduleid').val()}">`);

            // Create the FormData object
            var formData = new FormData($('#callforrecords')[0]);

            $.ajax({
                url: 'audit/auditee_accept', // Replace with your endpoint
                method: 'POST',
                data: formData,
                processData: false, // Disable automatic data processing
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Pass CSRF token in headers
                },
                success: function(response) {
                    // var validator = $("#audit_schedule").validate();
                    // validator.resetForm();
                    if (response.success) {
                        var response = 'Data Submitted to teamhead successfully';
                        passing_alert_value('Confirmation', response,
                            'confirmation_alert', 'alert_header', 'alert_body',
                            'confirmation_alert');

                    }

                    const detailsTab = document.getElementById('details-tab');
                    const detailsContent = document.getElementById('details-section');

                    // Disable the "Details" tab
                    detailsTab.classList.add('disabled');
                    detailsTab.removeAttribute('href');
                    detailsTab.removeAttribute('data-bs-toggle');

                    // Hide the content of the "Details" tab
                    if (detailsContent) {

                        detailsContent.style.display = 'none';
                    }
                    $('.date_change').hide();
                    $('.nav-link').removeClass('active');

                    // Add 'active' class to #all-category
                    $('#all-category').addClass('active');
                    $('.all-category').show();
                    $('#buttonsforacceptance').hide();
                    $('#statusmessage').show();
                    $('#details-tab').removeClass('disabled');
                    $('#part_details').hide();

                },
                error: function() {
                    alert("Failed to fetch team members!");
                }
            });
            // } else {
            //     scrollToFirstError();
            // }
            // alert();
            // if ($callforrecordsForm.valid()) {
            //     get_insertdata();
            // } else {
            //     scrollToFirstError();
            // }
        });


        function get_insertdata() {
            var formData = $('#auditee_partial').serializeArray();
            var entry_date = $('#entry_date').val();
            formData.push({
                name: 'entry_date',
                value: entry_date
            });
            $.ajax({
                url: 'audit/auditee_partialchange', // Replace with your endpoint
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Pass CSRF token in headers
                },
                success: function(response) {
                    // var validator = $("#audit_schedule").validate();
                    // validator.resetForm();
                    passing_alert_value('Confirmation', response.success,
                        'confirmation_alert', 'alert_header', 'alert_body',
                        'confirmation_alert');
                    $('.date_change').hide();
                    $('#buttonsforacceptance').hide();
                    $('#statusmessage').show();

                },
                error: function() {
                    alert("Failed to fetch team members!");
                }
            });
        }

        function fetchalldata() {
            $.ajax({
                url: 'audit/audit_scheduledetails', // Replace with your endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Pass CSRF token in headers
                },
                success: function(response) {
                    // console.log(response);
                    const audit_schedule = response.data;

                    const audit_period = response.auditperiod;

                    var concat = audit_period.from + ' - ' + audit_period.to;
                    // $('#financial_year').val(concat);
                    const audit_year = audit_schedule[0].yearname;
                    $('#financial_year').val(audit_year);



                    if (audit_schedule && audit_schedule.length > 0) {
                        var auditeeresponse = audit_schedule[0].auditeeresponse;

                        if (auditeeresponse != null) {
                            // document.getElementById("accept").disabled = true;
                            // document.getElementById("partially_accept").disabled = true;
                            $('#buttonsforacceptance').hide();
                            $('#statusmessage').show();
                            if (auditeeresponse == 'A') {
                                $('#details-tab').removeClass('disabled');
                            }

                        }
                        $('#inst_name').text(audit_schedule[0].instename);
                        $('#audit_type').val(audit_schedule[0].typeofauditename);
                        $('#audit_period').val(audit_schedule[0].auditquarter);

                        $('#audit_scheduleid').val(audit_schedule[0].encrypted_auditscheduleid);
                        $('#auditscheduleid').val(audit_schedule[0].encrypted_auditscheduleid);
                        $('#auditscheduleid').val(audit_schedule[0].encrypted_auditscheduleid);

                        $('#auditscheduleidNewforGet').val(audit_schedule[0].auditscheduleid);


                        $('#entry_date').val(convertDateFormatYmd_ddmmyy(audit_schedule[0]
                            .fromdate));
                        $('#start_date').val(convertDateFormatYmd_ddmmyy(audit_schedule[0]
                            .fromdate));
                        $('#end_date').val(convertDateFormatYmd_ddmmyy(audit_schedule[0]
                            .todate));

                        /* datepicker('entry_date', convertDateFormatYmd_ddmmyy(audit_schedule[0]
                             .fromdate));*/


                        // Clear existing options in both dropdowns
                        $('#tm_uid, #tm_hid').empty();

                        // Get selected team members' user IDs
                        const selectedTeamMembers = audit_schedule.map(member => member.userid);

                        // If there are any selected team members
                        if (selectedTeamMembers.length > 0) {

                            // Iterate over the response data to append options dynamically
                            audit_schedule.forEach(member => {
                                // Check if the member is in the selected list
                                const isSelected = selectedTeamMembers.includes(member.userid);
                                // Check if the member is a team member or a team head based on 'teamtype'
                                if (member.auditteamhead === 'N') {
                                    // Create a new option element for team members
                                    let newOption = new Option(
                                        `${member.username} - ${member.desigelname}`, // Display text
                                        member.userid, // Option value
                                        isSelected, // Set as selected in the dropdown if it's in selectedTeamMembers
                                        isSelected // Mark as selected for Select2
                                    );

                                    // Append the new option to the Team Member dropdown
                                    $('#tm_uid').append(newOption);
                                } else if (member.auditteamhead === 'Y') {
                                    // Create a new option element for team heads
                                    let newOption = new Option(
                                        `${member.username} - ${member.desigelname}`, // Display text
                                        member.userid, // Option value
                                        isSelected, // Set as selected in the dropdown if it's in selectedTeamMembers
                                        isSelected // Mark as selected for Select2
                                    );

                                    // Append the new option to the Team Head dropdown
                                    $('#tm_hid').append(newOption);
                                }
                            });

                            // Re-initialize Select2 for both dropdowns
                            $('#tm_uid').select2({
                                placeholder: "Select Team Member",
                                allowClear: true
                            });

                            $('#tm_hid').select2({
                                placeholder: "Select Team Head",
                                allowClear: true
                            });

                            // Set selected values for both dropdowns
                            $('#tm_uid').val(selectedTeamMembers).trigger('change');
                            $('#tm_hid').val(selectedTeamMembers).trigger('change');
                        }


                    }




                },
                error: function() {
                    alert("Failed to fetch team members!");
                }
            });
        }

        $(document).ready(function() {
                fetchalldata();
            }

        );

        $(document).on('click', '#details-tab', function() {
            show_div('accept', 'edit');
            $('#actionformtype').val('editform');
        });

        function acceptstatus(auditscheduleid) {
            $.ajax({
                url: 'audit/auditee_acceptdetails', // The route to call your controller method
                method: 'POST',
                data: {
                    auditscheduleid: auditscheduleid // Passing the auditplanid from the button's id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // CSRF token for security
                },
                success: function(response) {
                    // alert(response);
                    populateTableFetch(response)
                    // if (response.success) {
                    //     // Handle the success case (you can redirect, update UI, etc.)
                    //     alert("Data loaded successfully.");
                    //     // You can use response data to update your UI dynamically
                    // } else {
                    //     alert("Failed to load data.");
                    // }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.log("AJAX error: " + error);
                }
            });
        }

        function populateTableFetch(response) {
            const tableBody = $('#part_details_fetch'); // Select the table's tbody
            tableBody.empty(); // Clear existing rows

            const data = response.data;
            const cfr = response.cfr;

            // Grouping data for Account Particulars
            const accountParticulars = data.reduce((acc, item) => {
                if (!acc[item.accountparticularsename]) {
                    acc[item.accountparticularsename] = [];
                }
                acc[item.accountparticularsename].push(item);
                return acc;
            }, {});

            // Grouping data for Call for Records
            const callForRecords = cfr.reduce((acc, item) => {
                if (!acc[item.majorworkallocationtypeename]) {
                    acc[item.majorworkallocationtypeename] = [];
                }
                acc[item.majorworkallocationtypeename].push(item);
                return acc;
            }, {});
            const totalRows = Object.values(callForRecords).reduce((sum, group) => sum + group.length, 0);
            const accountTotalRows = Object.values(accountParticulars).reduce((sum, group) => sum + group.length, 0);
            // Start building the table HTML
            let tableHTML = '';
            tableHTML += `<tr>
                            <th rowspan="${accountTotalRows + 2}" class="">Account Particulars</th>
                        </tr>
                        <tr>
                            <th class="callforrecords_th">Type</th>
                            <th class="callforrecords_th ressts">Response Status</th>
                            <th class="callforrecords_th">
                                <div>
                                    <label class="form-label" for="validationDefault01">File Upload&nbsp;&nbsp;<Label>
                                </div>
                            </th>
                            <th class="callforrecords_th">
                                <div>
                                    <label class="form-label" >Remarks</label>
                                </div>
                            </th>
                        </tr>`;

            // Account Particulars Section
            tableHTML += `
                `;

            for (const [particularName, particulars] of Object.entries(accountParticulars)) {
                particulars.forEach((particular) => {
                    const isFileUploaded = particular.fileuploadid !== 0;
                    const fileDetailsString = particular.filedetails;
                    const fileDetailsArray = fileDetailsString.split(
                        ',');

                    const fileCardsHTML = fileDetailsArray.map((fileDetail, index) => {
                        const [name, path, size, fileuploadid] = fileDetail.split('-'); // Split by hyphen

                        const file = {
                            id: index + 1, // Use index+1 as unique ID for the file
                            name: name,
                            path: path,
                            size: size,
                            fileuploadid: fileuploadid,
                        };

                        return isFileUploaded ?
                            `<div class="card overflow-hidden mb-3" id="file-card-${file.id}">
                    <input type="hidden" id="fileuploadid_${file.id}" name="fileuploadid_${file.id}" value="${file.fileuploadid}">
                    <div class="d-flex flex-row">
                        <div class="p-2 align-items-center">
                            <h3 class="text-danger box mb-0 round-56 p-2">
                                <i class="ti ti-file-text"></i>
                            </h3>
                        </div>
                        <div class="p-3">
                            <h3 class="text-dark mb-0 fs-4">
                                <a style="color:black" href="/storage/${file.path}" target="_blank">${file.name}</a>
                            </h3>

                        </div>
                    </div>
                </div>` :
                            `<div class=""></div>`;
                    }).join('');

                    tableHTML += `
            <tr>
                <td>${particular.accountparticularsename}
                    <input type="hidden" id="${particular.accountparticularsid}-cfrcode" name="${particular.accountparticularsid}-cfrcode" value="${particular.accountparticularsid}">
                </td>
                <td>${isFileUploaded ? 'Yes' : 'No'}</td>

                  <td>${fileCardsHTML}</td>
                <td>
                    <textarea id="${particular.accountparticularsid}" name="${particular.accountparticularsid}-cfrvalues" class="form-control" placeholder="Enter remarks" disabled>${particular.remarks || ''}</textarea>
                </td>
            </tr>`;
                });
            }

            // Call for Records Section
            tableHTML += `<tr>
                             <th rowspan="${totalRows+ 2}" >Call For Records</th>
                          </tr>
                          <tr>
                             <th class="callforrecords_th">Major Type</th>
                             <th class="callforrecords_th">Sub Type</th>
                             <th class="callforrecords_th ressts">Response Status</th>
                             <th class="callforrecords_th">Remarks</th>
                          </tr>`;




            // Loop through each major work group in callForRecords
            for (const [majorWork, subWorks] of Object.entries(callForRecords)) {
                const majorWorkRowspan = subWorks.length; // Get the number of sub-works for this major work

                // Loop through each subWork for the current major work
                subWorks.forEach((subWork, index) => {
                    const isReplyPending = subWork.replystatus !== 'Y';

                    // Only add the major work name in the first row (index 0)
                    if (index === 0) {
                        tableHTML += `
                            <tr>
                                <td rowspan="${majorWorkRowspan}">${subWork.majorworkallocationtypeename}</td>
                                <td>${subWork.subworkallocationtypeename}</td>
                                <td>${isReplyPending ? 'No' : 'Yes'}</td>
                                <td>
                                    <textarea id="${subWork.subworkallocationtypeid}" name="${subWork.subworkallocationtypeid}-cfrvalues" class="form-control" placeholder="Enter remarks" disabled>${subWork.cfr_remarks || ''}</textarea>
                                </td>
                            </tr>`;
                    } else {
                        // For subsequent rows, only add sub-work details (without the major work)
                        tableHTML += `
                            <tr>
                                <td>${subWork.subworkallocationtypeename}</td>
                                <td>${isReplyPending ? 'No' : 'Yes'}</td>
                                <td>
                                    <textarea id="${subWork.subworkallocationtypeid}" name="${subWork.subworkallocationtypeid}-cfrvalues" class="form-control" placeholder="Enter remarks" disabled>${subWork.cfr_remarks || ''}</textarea>
                                </td>
                            </tr>`;
                    }
                });
            }

            // Nodal Person Section
            tableHTML += `
    <tr>
        <th>Nodal Person</th>
        <td colspan="4">
            <div class="row">
                <div class="col-md-6">
                   <label class="form-label" for="nodal_name">Name</label>
                   <input type="text" class="form-control " id="nodalname" name="nodalname" value="${data[0].nodalname || ''}" disabled placeholder="Enter Name"  />
                </div>
                <div class="col-md-6">
                   <label class="form-label" for="mobile">Mobile Number</label>
                   <input type="text" class= "form-control only_numbers" id="nodalmobile" value="${data[0].nodalmobile || ''}" disabled name="nodalmobile" placeholder="Enter Mobile Number" maxlength = 10 />
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label" for="mobile">Email</label>
                    <input type="text" class="form-control" id="nodalemail" value="${data[0].nodalemail || ''}" disabled name="nodalemail" placeholder="Enter Email"  />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="mobile">Designation</label>
                    <input type="text" class="form-control" id="nodaldesignation" value="${data[0].nodaldesignation || ''}" disabled name="nodaldesignation" placeholder="Enter Designation"  />
                </div>
            </div><br>
        </td>
    </tr>
    <tr>
        <th>Remarks</th>
        <td colspan="4">
            <label class="form-label" for="auditee_remarks">Remarks</label>
            <textarea id="auditee_remarks" name="auditee_remarks" class="form-control" disabled>${data[0].auditeeremarks || ''}</textarea><br>
        </td>
    </tr>`;
            console.log(tableHTML);
            // Append the HTML to the table body
            tableBody.append(tableHTML);
            $('#details_tabletab_buttons').hide();
        }
    </script>
@endsection
