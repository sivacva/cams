@extends('index2')
@section('content')
    <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">

    {{-- <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Calendar</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Calendar</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="../assets/images/breadcrumb/ChatBc.png" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card">
        <div class="card-body calender-sidebar app-calendar">
            <div id="calendar"></div>
        </div>
    </div>
    <!-- BEGIN MODAL -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">
                        Add / Edit Event
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <label class="form-label">Event Title</label>
                                <input id="event-title" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-12 mt-6">
                            <div>
                                <label class="form-label">Event Color</label>
                            </div>
                            <div class="d-flex">
                                <div class="n-chk">
                                    <div class="form-check form-check-primary form-check-inline">
                                        <input class="form-check-input" type="radio" name="event-level" value="Danger"
                                            id="modalDanger" />
                                        <label class="form-check-label" for="modalDanger">Danger</label>
                                    </div>
                                </div>
                                <div class="n-chk">
                                    <div class="form-check form-check-warning form-check-inline">
                                        <input class="form-check-input" type="radio" name="event-level" value="Success"
                                            id="modalSuccess" />
                                        <label class="form-check-label" for="modalSuccess">Success</label>
                                    </div>
                                </div>
                                <div class="n-chk">
                                    <div class="form-check form-check-success form-check-inline">
                                        <input class="form-check-input" type="radio" name="event-level" value="Primary"
                                            id="modalPrimary" />
                                        <label class="form-check-label" for="modalPrimary">Primary</label>
                                    </div>
                                </div>
                                <div class="n-chk">
                                    <div class="form-check form-check-danger form-check-inline">
                                        <input class="form-check-input" type="radio" name="event-level" value="Warning"
                                            id="modalWarning" />
                                        <label class="form-check-label" for="modalWarning">Warning</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-6">
                            <div>
                                <label class="form-label">Enter Start Date</label>
                                <input id="event-start-date" type="date" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-12 mt-6">
                            <div>
                                <label class="form-label">Enter End Date</label>
                                <input id="event-end-date" type="date" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">
                        Update changes
                    </button>
                    <button type="button" class="btn btn-primary btn-add-event">
                        Add Event
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->


    <script src="../assets/libs/fullcalendar/index.global.min.js"></script>
    <script src="../assets/js/apps/calendar-init.js"></script>
    <script src="../assets/js/vendor.min.js"></script>

@endsection
