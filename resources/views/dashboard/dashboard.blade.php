@extends('index2')
@section('content')

<div class="row mt-4">
    <?php
    $sessionchargedel = session('charge');
    $sessionuserdel = session('user');
    $session_chargid = $sessionchargedel->chargeid;
    // if ($session_chargid == '1') {

    // }
    // print_r($sessionchargedel->chargeid);

    ?>
    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    {{-- <div class="col-12">
            <div class="card">
                <div class="border-bottom title-part-padding bg-card">
                    <h4 class="card-title mb-0">Dashboard</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-3 d-flex align-items-stretch">
                                <a href="javascript:void(0)" class="card text-bg-success text-white w-100 card-hover">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-sitemap display-6"></i>
                                            <div class="ms-auto">
                                                <i class="ti ti-arrow-right fs-8"></i>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <h4 class="card-title mb-1 text-white">Test 1</h4>
                                            <p class="card-text fw-normal text-white opacity-75">
                                                34
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 d-flex align-items-stretch">
                                <a href="javascript:void(0)" class="card text-bg-warning text-white w-100 card-hover">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-timeline-event display-6"></i>
                                            <div class="ms-auto">
                                                <i class="ti ti-arrow-right fs-8"></i>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <h4 class="card-title mb-1 text-white">Test 2</h4>
                                            <p class="card-text fw-normal text-white opacity-75">
                                                45
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 d-flex align-items-stretch">
                                <a href="javascript:void(0)" class="card text-bg-danger text-white w-100 card-hover">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-file-invoice display-6"></i>
                                            <div class="ms-auto">
                                                <i class="ti ti-arrow-right fs-8"></i>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <h4 class="card-title mb-1 text-white">Test 3</h4>
                                            <p class="card-text fw-normal text-white opacity-75">
                                                55
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 d-flex align-items-stretch">
                                <a href="javascript:void(0)" class="card text-bg-secondary text-white w-100 card-hover">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-brand-gmail display-6"></i>
                                            <div class="ms-auto">
                                                <i class="ti ti-arrow-right fs-8"></i>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <h4 class="card-title mb-1 text-white">Test 4</h4>
                                            <p class="card-text fw-normal text-white opacity-75">
                                                12
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>


                        </div>



                    </form>
                </div>
            </div>

        </div> --}}
    <center>
        <h3> Welcome to CAMS </h3>
    </center>

    @php if ($session_chargid == '1') {
    @endphp
    @csrf
    <div class=" mt-5 " id="dash_state">
        <div class="row  justify-content-center">

            <div class="col-md-4 d-flex align-items-stretch" id="team_dash" onclick="show_table('team')">
                <a href="javascript:void(0)" class="card text-bg-success text-white w-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="display-6" id="team_count"></div>
                            <div class="ms-auto">
                                <i class="ti ti-sitemap fs-8"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h4 class="card-title mb-1 text-white">Total Audit Team</h4>
                            <!-- <p class="card-text fw-normal text-white opacity-75">
                                Black Bean and Corn Jalapeño Poppers
                            </p> -->
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 d-flex align-items-stretch" id="plan_dash" onclick="show_table('plan')">
                <a href="javascript:void(0)" class="card text-bg-warning text-white w-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="display-6" id="plan_count"></div>
                            <div class="ms-auto">
                                <i class="ti ti-calendar fs-8"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h4 class="card-title mb-1 text-white">Total Audit Plan</h4>
                            <!-- <p class="card-text fw-normal text-white opacity-75">
                                Black Bean and Corn Jalapeño Poppers
                            </p> -->
                        </div>
                    </div>
                </a>
            </div>


        </div>
    </div>
    <div class="col-12">
        <div class="card hide_this" style="border-color: #7198b9" id="team_table_details">
            <div class="card-header card_header_color">Team Details</div>
            <div class="card-body">
                <div class="datatables">
                    <div class="table-responsive hide_this" id="tableshow">
                        <table id="scheduletable"
                            class="table w-100 table-striped table-bordered display text-nowrap datatables-basic">
                            <thead>
                                <tr>
                                    <th class="lang" key="s_no">S.No</th>
                                    <th>Team Name</th>
                                    <th>Team Member Size</th>

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
        <div class="card hide_this" style="border-color: #7198b9" id="plan_table_details">
            <div class="card-header card_header_color">Plan Details</div>
            <div class="card-body">
                <div class="datatables">
                    <div class="table-responsive hide_this" id="plantableshow">
                        <table id="plantable"
                            class="table w-100 table-striped table-bordered display text-nowrap datatables-basic">
                            <thead>
                                <tr>
                                    <th class="lang" key="s_no">S.No</th>
                                    <th>Departname Name</th>
                                    <th>Plans</th>

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

    @php } @endphp

</div>
{{-- <script src="../assets/js/vendor.min.js"></script>
    <!-- Import Js Files -->
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="../assets/js/theme/app.init.js"></script>
    <script src="../assets/js/theme/theme.js"></script>
    <script src="../assets/js/theme/app.min.js"></script>
    <script src="../assets/js/theme/sidebarmenu.js"></script> --}}
<script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="../assets/js/datatable/datatable-advanced.init.js"></script>
<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<!-- This Page JS -->

<script>
    function show_table(param) 
    {
        if (param == 'team') 
        {
            if($('#team_count').html() > 0)
            {
                $('#team_table_details').show();
                $('#plan_table_details').hide();
            }
            else
            {
                $('#team_table_details').hide();
                $('#plan_table_details').hide();
            }
   
          
        } else {
            if($('#plan_count').html() > 0)
            {
                $('#team_table_details').hide();
                $('#plan_table_details').show();
            }
            else
            {
                $('#team_table_details').hide();
                $('#plan_table_details').hide();
            }
           
        }
    }
    $(document).ready(function() {

        $session = <?php echo $session_chargid; ?>;
        if ($session == '1') {
            // alert($session);

            $.ajax({
                url: '/dashboard_detail', // The route to call your controller method
                method: 'GET',
                // data: {
                //     auditscheduleid: auditscheduleid // Passing the auditplanid from the button's id
                // },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure the CSRF token is correct
                },
                success: function(response) {
                    const teamdetails = response.teamdetail;
                    const plandetail = response.plandetail;

                    if (teamdetails.length > 0) {
                        team_count = teamdetails[0].total_team_count;
                        
                    }
                    else team_count = 0;
                    
                    $('#team_count').text(team_count);
                    var plan_count = plandetail[0].total_auditplan_count;
                    $('#plan_count').text(plan_count);

                    if (teamdetails.length > 0) {
                        // Make the table visible
                        $('#tableshow').removeClass('hide_this');
                        $('#no_data').addClass('hide_this');

                        // Initialize DataTable if not initialized yet
                        var table = $('#scheduletable').DataTable();

                        // Clear existing table rows (if any)
                        table.clear();

                        // Loop through teamdetails and add each row to the table
                        teamdetails.forEach(function(team, index) {
                            table.row.add([
                                index + 1, // S.No (serial number)
                                team.teamname, // Team Name
                                team.team_member_count // Team Member Size
                            ]).draw(false);
                        });
                    } else {
                        // Show "No Data Available" if there are no team details
                        $('#no_data').removeClass('hide_this');
                        $('#tableshow').addClass('hide_this');
                    }
                    if (plandetail.length > 0) {
                        // Make the table visible
                        $('#plantableshow').removeClass('hide_this');
                        $('#no_data').addClass('hide_this');

                        // Initialize DataTable if not initialized yet
                        var table = $('#plantable').DataTable();

                        // Clear existing table rows (if any)
                        table.clear();

                        // Loop through teamdetails and add each row to the table
                        plandetail.forEach(function(plan, index) {
                            table.row.add([
                                index + 1, // S.No (serial number)
                                plan.deptelname, // Team Name
                                plan.dept_plan_count // Team Member Size
                            ]).draw(false);
                        });
                    } else {
                        // Show "No Data Available" if there are no team details
                        $('#no_data').removeClass('hide_this');
                        $('#tableshow').addClass('hide_this');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.log("AJAX error: " + error);
                }
            });
        }
    });
</script>
@endsection