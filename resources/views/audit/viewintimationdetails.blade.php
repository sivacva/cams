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


    <div class="card " style="border-color: #7198b9">
        <div class="card-header card_header_color">Auditee Status Details</div>
        <div class="card-body">
            <div class="datatables">
                <div class="table-responsive hide_this" id="tableshow">
                    <table id="audit_plandetails"
                        class="table w-100 table-striped table-bordered display text-nowrap datatables-basic">
                        <thead>
                            @csrf
                            <tr>
                                <th class="lang" key="s_no">S.No</th>
                                <th>Institute</th>
                                <th> Date</th>

                                <th>Audit Team</th>
                                <th>Audit Year</th>

                                <th>Nodel Person Details</th>
                                <th>Nodel Person Contact Details</th>
                                <th class="all">Status</th>
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
    <div id="date-changed" class="modal fade" tabindex="-1" aria-labelledby="date-changed modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-success text-white">
                    <h4 class="modal-title text-white" id="success-header-modalLabel">
                        Auditee Reply For Intimation
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="validationDefault02">Date</label>
                                <div class="input-group" onclick="datepicker('change_date','')">
                                    <input type="text" class="form-control datepicker" id="change_date"
                                        name="change_date" placeholder="dd/mm/yyyy" disabled />
                                    <span class="input-group-text">
                                        <i class="ti ti-calendar fs-5"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8">

                                <div class="mb-3">
                                    <label for="message-text" class="">Remarks</label>
                                    <textarea class="form-control" id="part_remarks" name="part_remarks" disabled>The audit planning has not be scheduled according to the Government Order</textarea>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        Edit
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Close
                    </button>
                    {{-- <button type="button" class="btn bg-success-subtle text-success ">
                                    Save changes
                                </button> --}}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>








    <div id="accepted" class="modal fade" tabindex="-1" aria-labelledby="accepted modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-success text-white">
                    <h4 class="modal-title text-white" id="success-header-modalLabel">
                        Auditee Reply For Intimation
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <h5 class="mt-2">Audit Particulars</h5>
                        <div class="table-responsive rounded-4">
                            <table class="table table-bordered border-dark">
                                <tbody id="part_details"></tbody>
                            </table>

                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        Edit
                    </button> --}}
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Close
                    </button>
                    {{-- <button type="button" class="btn bg-success-subtle text-success ">
                                    Save changes
                                </button> --}}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    </div>
    <script src="../assets/js/vendor.min.js"></script>
    <script src="../assets/js/jquery_3.7.1.js"></script>
    <script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="../assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    {{-- data table --}}
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>


    <script src="../assets/js/datatable/datatable-advanced.init.js"></script>
    <script>
        function datepicker(value, setdate) {
            var today = new Date();
            if (value == 'change_date') {
                // Calculate the minimum date (18 years ago)
                var maxDate = new Date(today);
                maxDate.setMonth(today.getMonth() + 4);

                // Calculate the maximum date (60 years ago)
                var minDate = today;
            }

            var minDateString = formatDate(minDate); // Format date to dd/mm/yyyy
            var maxDateString = formatDate(maxDate); // Format date to dd/mm/yyyy

            init_datepicker(value, minDateString, maxDateString, setdate)
        }
        $(document).ready(function() {
            if ($.fn.dataTable.isDataTable('#audit_plandetails')) {
                $('#audit_plandetails').DataTable().clear().destroy();
            }
            var table = $('#audit_plandetails').DataTable({
                "processing": true,
                "serverSide": false,
                "lengthChange": false,
                "scrollX": true,
                "ajax": {
                    "url": "/audit/auditee_intimation", // Your API route for fetching data
                    "type": "POST",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Pass CSRF token in headers
                    },
                    "dataSrc": function(json) {

                        if (json.data && json.data.length > 0) {

                            $('#tableshow').show();
                            $('#saudit_plandetails_wrapper').show();
                            $('#no_data').hide(); // Hide custom "No Data" message
                            return json.data;
                        } else {

                            $('#tableshow').hide();
                            $('#audit_plandetails_wrapper').hide();
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
                        "data": "teamname",

                    },
                    {
                    "data": "yearname",

                },
                    {
                        "data": "nodalperson_details",

                    },
                    {
                        "data": "nodalperson_contact",

                    },
                    {
                        "data": "rcno",
                        "render": function(data, type, row) {
                            let userid = row.userid
                            if (row.auditeeresponse === 'A') {
                                return `<center>
                        <button type="button " class="btn btn-success ">
                                                   Accepted
                                                </button>
                    </center>`;
                            } else {
                                return `<center>
                        <button type="button " class="btn btn-primary ">
                                                    Partially Changed
                                                </button>
                    </center>`;
                            }


                        }
                    },
                    {
                        "data": "encrypted_auditplanid", // Use the encrypted deptuserid
                        "render": function(data, type, row) {
                            let userid = row.userid
                            if (row.auditeeresponse === 'A') {
                                return `<center>
                         <button type="button"
                                                        class="justify-content-center w-100 btn mb-1 btn-rounded btn-outline-primary d-flex align-items-center"
                                                        onclick='acceptstatus(${JSON.stringify(row)})'>
                                                        <i class="ti ti-inbox fs-4 me-2"></i>
                                                        View Status
                                                    </button>
                    </center>`;
                            } else {
                                return `<center>
                         <button type="button"
                                                        class="justify-content-center w-100 btn mb-1 btn-rounded btn-outline-primary d-flex align-items-center"
                                                        data-bs-toggle="modal" data-bs-target="#date-changed" onclick='viewStatus(${JSON.stringify(row)})'>
                                                        <i class="ti ti-inbox fs-4 me-2"></i>
                                                        View Status
                                                    </button>
                    </center>`;
                            }


                        }
                    }
                ]
            });
        });

        function viewStatus(rowData) {
            $('#part_remarks').val(rowData.auditeeremarks);

            datepicker('change_date', convertDateFormatYmd_ddmmyy(rowData.auditeeproposeddate));

        }

        function acceptstatus(rowData) {
            var auditscheduleid = rowData.auditscheduleid;
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
                    populateTable(response)
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

        function populateTable(response) {
            const tableBody = $('#part_details'); // Select the table's tbody
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

            // Account Particulars Section
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
                            `<div class=" overflow-hidden mb-3" id="file-card-${file.id}">
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



            for (const [majorWork, subWorks] of Object.entries(callForRecords)) {
                const majorWorkRowspan = subWorks.length;
                subWorks.forEach((subWork, index) => {
                    const isReplyPending = subWork.replystatus !== 'Y';

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

            // Append the HTML to the table body
            tableBody.append(tableHTML);
            $('#accepted').modal('show');
        }
    </script>
@endsection
