@extends('index2')
@section('content')
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
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationDefault01">Designation </label>
                                <select class="form-select mr-sm-2" id="designation">
                                    <option selected>Select Designation</option>
                                    <option value="1">Hindu Religious and Charitable Endowments Department
                                    </option>
                                    <option value="2">Local Fund Audit </option>
                                    <option value="3">State Government Audit</option>

                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationDefault02">Charge </label>
                                <select class="form-select mr-sm-2" id="charge">
                                    <option selected>Select Charge</option>
                                    <option value="1">Charge 1
                                    </option>
                                    <option value="2">Charge 2</option>
                                    <option value="3">Charge 3</option>

                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationDefaultUsername">User</label>
                                <select class="form-select mr-sm-2" id="user">
                                    <option selected>Select User</option>
                                    <option value="M">Siva</option>
                                    <option value="F">Swathi</option>
                                    <option value="T">Niji </option>

                                </select>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationDefaultUsername">Charge From Date</label>
                                <input type="date" class="form-control" id ="cod" name="cod" disabled />

                            </div>


                        </div>

                        {{-- <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="customControlAutosizing" />
                                <label class="form-check-label" for="customControlAutosizing">Agree to terms and
                                    conditions</label>
                            </div>
                        </div> --}}
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
@endsection
