@extends('index2')
@section('content')
    <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">
    <style>
        #calendar {
            height: 500px !important; /* Adjust the height to make it smaller */
            font-size: 12px; /* Optional: Adjust font size to fit the smaller space */
        }
        .fc-toolbar-title
        {
            color:#3782ce !important;
        }

        .fc-view-harness, .fc-header-toolbar
        {
            width:50% !important;
        }

        #eventModal td {
            padding: 12px;
            /* Adds 10px of padding on all sides of each cell */
            border: 1px solid #ddd;
            /* Optional: Add a border for visibility */
        }
        .fc-daygrid-day-frame
        {
            background-color:#ffffff !important;
        }

        .fc-daygrid-day-number
        {
            font-weight:400 !important;
            font-size:12px !important;
            color:#222 !important;
        }

        .app-calendar .event-fc-color {
            font-size: 11px !important;
            border-width: 0 0 0 3px  !important;
            padding: 3px 5px  !important;
        }

        .fc-event-time
        {
            display:none !important;
        }

       
    </style>

    <div class="card" style="border-color: #7198b9">
    <div class="card-header card_header_color" style="padding:10px;">AUDIT CALENDAR</div>
        <div class="card-body calender-sidebar app-calendar">
            <div id="calendar"></div>
        </div>
        <br>
    </div>
    <!-- BEGIN MODAL -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-md">
            <div class="modal-content">
               <div class="modal-header" >
                    <button type="button" id="large_confirmation_button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size:12px;">
                <div class="card" style="border-color: #7198b9"><div class="card-header card_header_color">Audit Details</div><div class="card-body">
                    <table style="width:100%;" class="table  table-hover w-100 table-bordered display largemodal">
                        <tbody class="eventDetailsTable">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
              
    </div>
        </div>
    </div>
    <!-- END MODAL -->


    <script src="../assets/libs/fullcalendar/index.global.min.js"></script>
    <script src="../assets/js/vendor.min.js"></script>
    
    <script>       
      document.addEventListener("DOMContentLoaded", function () 
      {
        var newDate = new Date();
        function getDynamicMonth() {
            getMonthValue = newDate.getMonth();
            _getUpdatedMonthValue = getMonthValue + 1;
            if (_getUpdatedMonthValue < 10) {
                return `0${_getUpdatedMonthValue}`;
            } else {
                return `${_getUpdatedMonthValue}`;
            }
        }

        var getModalTitleEl = document.querySelector("#event-title");
        var getModalStartDateEl = document.querySelector("#event-start-date");
        var getModalEndDateEl = document.querySelector("#event-end-date");
        var calendarsEvents = {
            Danger: "danger",
            Success: "success",
            Primary: "primary",
            Warning: "warning",
        };

        var calendarEl = document.querySelector("#calendar");
        var checkWidowWidth = function () {
            return window.innerWidth <= 1199;
        };

        var calendarHeaderToolbar = {
            left: "",
            center: "title",
            right: "prev next",
        };

        // Fetch events from the backend via AJAX
        function fetchEvents() {
            return fetch('/events')  // Use backticks for template literal (optional here)
                .then(response => response.json())  // Parse the JSON response
                .then(data => {
                    console.log(data);  // Check the data structure in the console
                    return data.map(event => {
                        // Correct the mapping of event properties
                        let endDate = new Date(event.end);
                        let adjustedEndDate = endDate.toISOString();

                        return {
                            id: event.id,
                            title: event.title,
                            start: event.start,  // Start date/time
                            end: adjustedEndDate, // Adjusted end date/time
                            extendedProps: {
                                calendar: event.extendedProps.calendar, // The custom calendar type
                            },
                        };
                    });
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
                });
        }



       
        var calendarEventClick = function (info) 
        {
            var auditscheduleid = info.event.id; // Get the auditscheduleid for the clicked event

            // Now fetch the event details based on the auditscheduleid
            $.ajax({
                url: '/event-details',  // URL to fetch event details by auditscheduleid
                method:'GET',
                data: {auditscheduleid:auditscheduleid},
                success: function(data) {
                   // Create the HTML table rows to append
                   $('.eventDetailsTable').empty();
                    var appenddata = '<tr><td><b>Institution Name</b></td><td>'+data.instename+'</td></tr>' +
                                    '<tr><td><b>Department</b></td><td>'+data.deptesname+'</td></tr>' +
                                    '<tr><td><b>Category</b></td><td>'+data.catename+'</td></tr>' +
                                    '<tr><td><b>From Date</b></td><td>'+data.fromdate_format+'</td></tr>' +
                                    '<tr><td><b>To Date</b></td><td>'+data.todate_format+'</td></tr>' +
                                    '<tr><td><b>Audit Team</b></td><td>'+data.teamname+'</td></tr>' +
                                    '<tr><td><b>Type Of Audit</b></td><td>'+data.typeofauditename+'</td></tr>' +
                                    '<tr><td><b>Financial Year</b></td><td>'+data.yearname+'</td></tr>' +
                                    '<tr><td><b>Audit Quarter</b></td><td>'+data.auditquarter+'</td></tr>';

                    // Append the HTML content to a table with id 'eventDetailsTable'
                    $('.eventDetailsTable').append(appenddata);

                }
            });
                myModal.show();
      
        };

        var calendar = new FullCalendar.Calendar(calendarEl, {
            selectable: true,
            height: checkWidowWidth() ? 900 : 1052,
            initialView: checkWidowWidth() ? "listWeek" : "dayGridMonth",
            initialDate: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
            headerToolbar: calendarHeaderToolbar,
            events: function (info, successCallback, failureCallback) {
                fetchEvents().then(events => {
                    successCallback(events);
                }).catch(failureCallback);
            },
            eventClassNames: function ({ event: calendarEvent }) {
                const getColorValue = calendarsEvents[calendarEvent._def.extendedProps.calendar];
                return ["event-fc-color fc-bg-" + getColorValue];
            },
            eventClick: calendarEventClick,
            windowResize: function () {
                if (checkWidowWidth()) {
                    calendar.changeView("listWeek");
                    calendar.setOption("height", 900);
                } else {
                    calendar.changeView("dayGridMonth");
                    calendar.setOption("height", 1052);
                }
            },
        });

        calendar.render();

        var myModal = new bootstrap.Modal(document.getElementById("eventModal"));
       
      });

    </script>

@endsection
