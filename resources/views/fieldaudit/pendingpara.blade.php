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

        #auditteamtable_wrapper {
            overflow: visible;
            /* Ensure the wrapper does not force scrolling */
        }

        #auditteamtable {
            width: 100%;
            /* Ensure the table takes full width of its container */
            table-layout: auto;
            /* Allow automatic adjustment of table layout */
            overflow: visible;
            /* Prevent overflow */
        }

        .largemodal td {
            padding: 12px;
            /* Adds 10px of padding on all sides of each cell */
            border: 1px solid #ddd;
            /* Optional: Add a border for visibility */
        }
    </style>
    <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">



    <?php
    $instdel = json_decode($results, true);

    if ($instdel) {
        $datashow = '';
        $nodatashow = 'hide_this';
    } else {
        $datashow = 'hide_this';
        $nodatashow = '';
    }

    ?>



    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header card_header_color">Pending Paras Details</div>
                <div class="card-body"><br>
                    <div class="datatables <?php echo $datashow; ?>">
                        <div class="table-responsive " >
                            <table id="usertable"
                                class="table w-100 table-striped table-bordered display text-nowrap datatables-basic">
                                <thead>
                                    <tr>
                                        <th class="lang" key="s_no">S.No</th>
                                        <th>Institution Name</th>
                                        <th>From date</th>
                                        <th>To date</th>
                                        <th class="all">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($instdel as $index => $item)
                                        <tr>
                                            <td class="text-end">{{ $index + 1 }}</td> <!-- S.No -->
                                            <td>{{ $item['instename'] }}</td>
                                            <td>{{ $item['formatted_fromdate'] }}</td>
                                            <td>{{ $item['formatted_todate'] }}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button class="btn btn-sm btn-primary" onclick="getpendingparadel('{{ $item['encrypted_auditscheduleid'] }}')">View Field Audit</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <div id='no_data' class='<?php echo $nodatashow; ?>'>
                        <center>No Data Available</center>
                    </div> -->
                </div>
            </div>


            
            <div class="card hide_this" id="view_Details">
                <div class="card-header card_header_color">View Pending Para Details</div>
                <div class="card-body"><br>
                    <div class="datatables">
                        <div class="table-responsive hide_this" id="tableshow">
                            <table id="usertable_detail"
                                class="table w-100 table-striped table-bordered display text-nowrap datatables-basic">
                                <thead>
                                    <tr>
                                        <th class="lang" key="s_no">S.No</th>
                                        <th>Slip No</th>
                                        <th>Main Objection</th>
                                        <th>Sub Objection</th>
                                        <th>Ammount involved</th>
                                        <th>Slip Details</th>
                                        <th>Liability</th>
                                        <th>Auditor Remarks</th>
                                        <th>status</th>
                                       
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div id='no_data_details' class='hide_this'>
                        <center>No Data Available</center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="../assets/js/jquery_3.7.1.js"></script>
    <script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
   @endsection

   <!-- <script>
    function getpendingparadel(auditschedulingid) {
        // Hide previous data table if it exists
        $('#view_Details').removeClass('hide_this');

        // Clear previous DataTable if it exists
        // if ($.fn.DataTable.isDataTable('#usertable_details')) {
        //     $('#usertable_details').DataTable().clear().destroy();
        // }


        alert(auditschedulingid);
        //Initialize DataTable with new data
        var table = $('#usertable_details').DataTable({
            "processing": true,
            "serverSide": false,
            "lengthChange": false,
            "ajax": {
                "url": "/getpendingparadetails", // Your API route for fetching data
                "type": "POST",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Pass CSRF token in headers
                },
                "data": {
                    auditschedulingid: auditschedulingid
                },
                "dataSrc": function(json) {
                    if (json.data && json.data.length > 0) {
                        $('#no_data_details').hide(); // Hide custom "No Data" message
                        return json.data;
                    } else {
                        $('#no_data_details').show(); // Show custom "No Data" message
                        return [];
                    }
                }
            },
            "columns": [
                {
                    "data": null, // Serial number column
                    "render": function(data, type, row, meta) {
                        return meta.row + 1; // Serial number starts from 1
                    }
                },
                {
                    "data": "objectionename"
                },
                {
                    "data": "subobjectionename"
                },
                {
                    "data": "amtinvolved"
                },
                {
                    "data": "slipdetails"
                },
                {
                    "data": "liability"
                },
                {
                    "data": "auditorremarks"
                },
                {
                    "data": "status"
                }
            ]
        });
     
    }
</script> -->


<script>
    function getpendingparadel(auditscheduleid) {
        // Show the detailed audit view section
         $('#view_Details').removeClass('hide_this');

        // // Clear previous DataTable if it exists
        // if ($.fn.DataTable.isDataTable('#usertable')) {
        //     $('#usertable').DataTable().clear().destroy();
        // }

          // To confirm the correct audit scheduling ID is passed

        // // Initialize DataTable with new data
        // var table = $('#usertable').DataTable({
        //     "processing": true,
        //     "serverSide": false,
        //     "lengthChange": false,
        //     "ajax": {
        //         "url": "/getpendingparadetails", // Your API route for fetching data
        //         "type": "POST",
        //         "headers": {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Pass CSRF token in headers
        //         },
        //         "data": {
        //             auditscheduleid: auditscheduleid // Ensure this matches the PHP parameter name
        //         },
        //         "dataSrc": function(json) {
        //             if (json.data && json.data.length > 0) {
        //                 $('#no_data_details').hide(); // Hide custom "No Data" message
        //                 return json.data;
        //             } else {
        //                 $('#no_data_details').show(); // Show custom "No Data" message
        //                 return [];
        //             }
        //         }
        //     },
        //     "columns": [
        //         {
        //             "data": null, // Serial number column
        //             "render": function(data, type, row, meta) {
        //                 return meta.row + 1; // Serial number starts from 1
        //             }
        //         },
        //         {
        //             "data": "objectionename"
        //         },
        //         {
        //             "data": "subobjectionename"
        //         },
        //         {
        //             "data": "amtinvolved"
        //         },
        //         {
        //             "data": "slipdetails"
        //         },
        //         {
        //             "data": "liability"
        //         },
        //         {
        //             "data": "auditorremarks"
        //         },
        //         {
        //             "data": "status"
        //         }
        //     ]
        // });

        // $.ajax({
		// 		url: "/getpendingparadetails",
		// 		type: "POST",
        //     data  :  {
        //         auditscheduleid : auditscheduleid
        //     },
        //     "headers": {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Pass CSRF token in headers
        //         },
		// 		success: function(data, textStatus, jqXHR) 
		// 		{
		// 			if(jqXHR.status=='200')
		// 			{


        //             }
        //         }
        //     });
        $.ajax({
    url: "/getpendingparadetails",
    type: "POST",
    data: {
        auditscheduleid: auditscheduleid
    },
    "headers": {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Pass CSRF token in headers
    },
    success: function(data, textStatus, jqXHR) {
        if (jqXHR.status == '200' && data.success) {
            // Clear existing table rows before populating
            $('#usertable_detail tbody').empty();

            if (data.data.length > 0) {
                // Loop through the data array and append rows to the table
                $.each(data.data, function(index, item) {
                    var auditorRemarks = JSON.parse(item.auditorremarks).content; // Parse the auditor remarks
                    var row = '<tr>';
                    row += '<td>' + (index + 1) + '</td>';
                    row += '<td>' + item.mainslipnumber + '</td>';
                    row += '<td>' + item.objectionename + '</td>';
                    row += '<td>' + item.subobjectionename + '</td>';
                    row += '<td>' + item.amtinvolved + '</td>';
                    row += '<td>' + item.slipdetails + '</td>';
                    if(item.liability == 'Y')
                    {
                        row += '<td>YES<br>'+ item.liabilityname +'</td>';
                    }
                    else
                    {
                        row += '<td>No</td>';
                    }
                    row += '<td>' + auditorRemarks + '</td>';
                    if((item.processcode == 'A') || (item.processcode == 'X'))
                    row += '<td>'+item.processelname +'</td>'
                    else

                    row += '<td>Pending</td>'; // You can replace "Pending" with the actual status if available
                    row += '</tr>';

                    // Append the row to the table
                    $('#usertable_detail tbody').append(row);
                });

                // Show the table if there is data
                $('#tableshow').removeClass('hide_this');
                $('#no_data_details').addClass('hide_this'); // Hide the "no data" section if data is present
            } else {
                // If no data is returned, show the "no data" message and hide the table
                $('#no_data_details').removeClass('hide_this');
                $('#tableshow').addClass('hide_this');
            }
        }
    }
});


    }
</script>
