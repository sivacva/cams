@section('content')
    @extends('index2')
    @include('common.alert')
    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">



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
            <div class="card" style="border-color: #7198b9">
                <div class="card-header card_header_color">Field Audit Details</div>
                <div class="card-body"><br>
                    <div class="datatables <?php echo $datashow; ?>">
                        <div class="table-responsive " id="tableshow">
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
                                                <a class="btn btn-sm btn-success"
                                                    href="{{ route('audit_slip', ['id' => $item['encrypted_auditscheduleid']]) }}">
                                                    Add Audit Slip</a>
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('field_audit', ['id' => $item['encrypted_auditscheduleid']]) }}">View
                                                    Field Audit</a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id='no_data' class='<?php echo $nodatashow; ?>'>
                        <center>No Data Available</center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
<!-- <script src="../assets/js/vendor.min.js"></script>  -->

<script src="../assets/js/jquery_3.7.1.js"></script>
<script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>

<script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>

<script src="../assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
