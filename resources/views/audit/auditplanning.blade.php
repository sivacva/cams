@extends('index2')
@section('content')
    {{-- <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css"> --}}
    <style>
        .hiddenbtns {
            display: none;
        }

        .card-body {
            padding: 15px 10px;
        }

        .card {
            margin-bottom: 10px;
        }

        .largemodal td {
            padding: 12px;
            /* Adds 10px of padding on all sides of each cell */
            border: 1px solid #ddd;
            /* Optional: Add a border for visibility */
        }



        /*.audittable {
                                                                                                                                                                                                                                                                            overflow: visible;
                                                                                                                                                                                                                                                                        }



                                                                                                                                                                                                                                                                        .audittable {
                                                                                                                                                                                                                                                                            width: 100%;
                                                                                                                                                                                                                                                                            table-layout: auto;
                                                                                                                                                                                                                                                                            overflow: visible;
                                                                                                                                                                                                                                                                        }*/
    </style>

    @include('common.alert')



    <div class="col-12 align-items-center">
        <div class="card card_border">
            <div class="card-header card_header_color">Audit Plan </div>
            <div class="card-body min-vh-50 align-items-center">
                <div class="col-md-2 mx-auto d-flex ">
                    <button type="button" id="plan_btn"
                        class="justify-content-center w-100 btn mb-1 btn-rounded btn-warning d-flex align-items-center">
                        <i class="ti ti-settings-automation fs-4 me-2 "></i>
                        Automate Planning
                    </button>
                </div>


                {{-- <button type="button" class="btn btn-success me-1 mb-1 px-2" onclick="importData()">
                    <i class="ti ti-paperclip fs-7"></i>
                </button> --}}



            </div>
        </div>
    </div>


    {{-- </script>
        <script src="../assets/js/datatable/datatable-advanced.init.js"></script> --}}
    <script src="../assets/js/jquery_3.7.1.js"></script>
    <script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
    {{-- <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/select2/dist/js/select2.full.min.js"></script>
        <script src="../assets/libs/select2/dist/js/select2.min.js"></script> --}}
    <!-- <script src="../assets/js/forms/select2.init.js"></script>-->
    <script>
        $('#plan_btn').on("click", function() {
            // alert();
            datacontent = "choose the parameters";
            passing_alert_value('Confirmation', datacontent, 'confirmation_alert', 'alert_header',
                'alert_body', 'forward_alert');
        });
    </script>
@endsection
