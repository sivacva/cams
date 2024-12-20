<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use App\Models\AuditDiaryModel;
use App\Exports\AuditorDiaryExport;
use App\Models\InstAuditscheduleModel;
use Maatwebsite\Excel\Facades\Excel; // Correct import for the Excel facade

use Illuminate\Http\Request;
use DataTables;

class AuditDiaryController extends Controller
{
    public function storeOrUpdateAuditDiary(Request $request)
    {
        $request->validate([
            'workallocationid' => 'required|array',
            'fromdate' => 'required|array',
            //'todate' => 'required|array',
            'remarks' => 'required|array',
            'percentage' =>'required|array',
            //'noofdays' =>'required|array',
        ]);

        foreach($request->workallocationid as $key => $val)
        {
            $auditDiaryData = ['workallocationid' => $request->workallocationid[$key],
                               'percentofcompletion' => $request->percentage[$key],
                               'fromdate' => $request->fromdate[$key],
                               //'todate' => $request->todate[$key],  // Insert the generated yearcodemapping_id here
                               'remarks' => $request->remarks[$key],
                               //'noofdays' => $request->noofdays[$key],
                               'statusflag' => 'Y'
                              ];


            if($_POST['actiontype'] =='Update')
            {
                $auditdiaryid =   $request->auditdiaryid[$key];
            }else
            {
                 $auditdiaryid=null;
            }


            try
            {
                // Pass the current user ID (if available) for the update or create logic
                $AuditDiaryModel = AuditDiaryModel::createIfNotExistsOrUpdate($auditDiaryData,$auditdiaryid);
                // You can store results or status here if you want to track success for each iteration
                $successResults[] = $AuditDiaryModel;  // Collecting successful updates (optional)
            } catch (QueryException $e)
            {
                // Handle database exceptions (e.g., duplicate entry)
                $errorResults[] = 'Database error: ' . $e->getMessage();  // Collecting errors (optional)
            } catch (Exception $e)
            {
                // Handle other exceptions
                $errorResults[] = 'Error: ' . $e->getMessage();  // Collecting errors (optional)
            }
        }

        // After the loop completes, return the final response
        if (isset($errorResults) && !empty($errorResults)) {
            // If there are any errors, return them
            return response()->json(['error' => $errorResults], 500);
        } else {
            // If everything is successful, return success
            return response()->json(['success' => 'Details created/updated successfully', 'data' => $successResults ?? []]);
        }

    }


    public function FetchworkallocationDetailsdropdown()
    {
        $workAllocation = AuditDiaryModel::Fetch_Cat_subCat();
        $Workallocated_Category=[];
        $Workallocated_SubCategory=[];
        $WorkAllocationId=[];
        $DiaryData='nodata';
        if($workAllocation)
        {
            $DiaryData = AuditDiaryModel::DiaryFetchData();

            foreach($workAllocation as $workkey => $workval)
            {
                $Workallocated_Category[$workval->majorworkallocationtypeid]=$workval->majorworkallocationtypeename;
                $Workallocated_SubCategory[$workval->majorworkallocationtypeid][$workval->subworkallocationtypeid]=$workval->subworkallocationtypeename;
                $WorkAllocationId[$workval->majorworkallocationtypeid][$workval->subworkallocationtypeid]=$workval->workallocationid;
            }
        }

            if($DiaryData!=='nodata')
            {
                if(sizeof($DiaryData) >0)
                {
                    foreach($DiaryData as $KeyDiary => $ValDiary)
                {
                    if($ValDiary->fromdate)
                    {
                        $FromDate[$ValDiary->workallocationid]=date('d-m-Y',strtotime($ValDiary->fromdate));
                    }



                    $Remarks[$ValDiary->workallocationid]=$ValDiary->remarks;
                    $Percent[$ValDiary->workallocationid]=$ValDiary->percentofcompletion;
                    //$NoofDays[$ValDiary->workallocationid]=$ValDiary->noofdays;
                    $AuditDiaryId[$ValDiary->workallocationid]=$ValDiary->diaryid;
                    $actiontype='Update';
                }

                }

                return view('audit.auditdiary', compact('Workallocated_Category','Workallocated_SubCategory','WorkAllocationId','FromDate','Remarks','Percent','AuditDiaryId','actiontype'));

            }else
            {
                $actiontype='Insert';
                return view('audit.auditdiary', compact('Workallocated_Category','Workallocated_SubCategory','WorkAllocationId','actiontype'));
            }



    }

    public static function FetchDiarydetails()
    {
        $audits = AuditDiaryModel::fetchAllusers();
        return response()->json(['data' => $audits]); // Ensure the data is wrapped under "data"


    }

    public function downloadDiary()
    {
        $chargeData = session('charge');
        $userData = session('user');
        $session_userid = $userData->userid;
        //$workAllocation = AuditDiaryModel::Fetch_Cat_subCat();
        $workAllocation = AuditDiaryModel::DiaryFetchData();
        $fromdates = $workAllocation->pluck('fromdate');
        $subworkname=$workAllocation->pluck('subworkallocationtypeename');
        $combined = $fromdates->combine($subworkname);

        $lowestDate = $fromdates->min();
        $highestDate = $fromdates->max();

        $auditscheduleid = $workAllocation->first()->auditscheduleid;

        $WorkingOfficeGet=AuditDiaryModel::GetInstituteDetails($session_userid,$auditscheduleid);
        // Fetch metadata
        $metaData = [
            'name' => $userData->username,  // Example dynamic name
            'designation' =>$chargeData->desigelname,  // Example dynamic designation
            'working_office' =>$WorkingOfficeGet->instename, 
        ];

        // Generate calendar data for December 2024
        $calendarData = [];
        $start_date = new \DateTime($lowestDate);
        $end_date = new \DateTime($highestDate);

        while ($start_date <= $end_date) {
            $current_date = $start_date->format('Y-m-d');
            $day = $start_date->format('l');
            $details = '';
        
            // Check if the current date exists in the $combined array
            if (array_key_exists($current_date, $combined->toArray())) {
                $details = $combined[$current_date]; // Get subwork name for the date
            } elseif (in_array($day, ['Sunday', 'Saturday'])) {
                $details = 'Government Holiday';
            }
        
            // Add to calendar data
            $calendarData[] = [
                'date' => $start_date->format('d-m-Y'),
                'day' => $day,
                'details' => $details,
            ];
        
            // Increment the date
            $start_date->modify('+1 day');
        }

        // Get unique catworkname values
        $uniqueCatworkname = $workAllocation->pluck('majorworkallocationtypeename')->unique()->values()->all();

        // Initialize summaryData array
        $summaryData = [];

        // Loop through unique catworkname values to create 'Category Audit Duty' rows
        foreach ($uniqueCatworkname as $index => $name) {
            $summaryData[] = [
                'gist' => 'Category' . ($index + 1) . ' (' . $name . ') *',
                'total_days' => $fromdates->count(),
            ];
        }

        // Add fixed rows to the summaryData
        $fixedRows = [
            ['gist' => 'Staff Meeting', 'total_days' => ''],
            ['gist' => 'Casual Leave', 'total_days' => ''],
            ['gist' => 'Government Holidays', 'total_days' => ''],
            ['gist' => 'Loss of Pay', 'total_days' => ''],
            ['gist' => 'Total', 'total_days' => ''],
        ];

        $summaryData = array_merge($summaryData, $fixedRows);

        // Pass data to the export class and download
        return Excel::download(
            new AuditorDiaryExport($metaData, $calendarData, $summaryData),
            'Auditor_Diary_December_2024.xlsx'
        );
    }


}
