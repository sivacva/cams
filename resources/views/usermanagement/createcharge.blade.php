@section('content')
    @include('common.alert')
    @extends('index2')

    @php
        $roleTypeCode = session('roletypecode');
        $dga_roletypecode = $DGA_roletypecode;
    @endphp

    <?php echo $roleTypeCode; ?>


    <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <h4 class="card-title mb-0">Create Charge</h4>
                </div>
                <div class="card-body">
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3 hide_this" id="deptdiv">
                                <label class="form-label" for="validationDefault01">Department </label>
                                <select class="form-select mr-sm-2" id="dept">
                                    <option selected>Select Department</option>
                                    @foreach ($dept as $department)
                                        <option value="{{ $department->deptcode }}">
                                            {{ $department->deptelname }} <!-- Display any field you need -->
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationDefaultUsername">Role Type</label>
                                <select class="form-select mr-sm-2" id="role_type">
                                    <option selected>Select Role Type</option>

                                </select>
                            </div>



                            <div class="col-md-4 mb-3 hide_this" id="regiondiv">
                                <label class="form-label" for="validationDefault01">Region </label>
                                <select class="form-select mr-sm-2" id="region">
                                    <option selected>Select Region</option>

                                </select>
                            </div>
                            <div class="col-md-4 mb-3 hide_this" id="distdiv">
                                <label class="form-label" for="validationDefault01">District </label>
                                <select class="form-select mr-sm-2" id="district">
                                    <option selected>Select District</option>

                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationDefault01">Designation </label>
                                <select class="form-select mr-sm-2" id="designation">
                                    <option selected>Select Designation</option>
                                    @foreach ($designation as $department)
                                        <option value="{{ $department->desigcode }}">
                                            {{ $department->desigelname }} <!-- Display any field you need -->
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationDefault02">Charge Description</label>
                                <input type="text" class="form-control" id="charge_desc" name="charge_desc"
                                    placeholder="description" required />
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationDefaultUsername">Role Action</label>
                                <select class="form-select mr-sm-2" id="role_action">
                                    <option selected>Select Role Action</option>
                                    <option value="M">Initiator</option>
                                    <option value="F">Verifier</option>
                                    <option value="T">Approver</option>
                                </select>

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
@endsection

<script>
    function settingform() {

    }
</script>
