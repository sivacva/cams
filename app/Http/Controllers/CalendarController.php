<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; // Assuming you have an Event model
use App\Models\InstAuditscheduleModel;
//use Carbon\Carbon;


class CalendarController extends Controller
{
    // Fetch events for the calendar
    public function getEvents(Request $request)
    {
        $userData = session('user');
        $session_userid = $userData->userid;
        $audit_scheduledetail = InstAuditscheduleModel::fetchAuditScheduleDetailsDeptUsers($session_userid);

        $formattedEvents = $audit_scheduledetail->map(function($event) {
            //$event->todate = Carbon::parse($event->todate)->addDay()->format('Y-m-d');

            return [
                'id' => $event->auditscheduleid,
                'title' =>$event->instename,
                'start' => $event->fromdate, // Make sure start_date is in a format FullCalendar can parse, e.g., 'Y-m-d H:i:s'
                'end' => $event->todate, // Optional if your events have end times
                'extendedProps' => [
                    'calendar' =>'Primary', // You can customize this field
                ],
            ];
        });
    
        // Return as JSON
        return response()->json($formattedEvents);
    }

    public function getEventsDetails(Request $request)
    {
        $audit_scheduledetail = InstAuditscheduleModel::GetSchedultedEventDetails($request->auditscheduleid);
        $audit_scheduledetail['fromdate_format'] = date('d-m-Y',strtotime($audit_scheduledetail->fromdate));
        $audit_scheduledetail['todate_format'] = date('d-m-Y',strtotime($audit_scheduledetail->todate));
        return $audit_scheduledetail;

    }
}

?>
