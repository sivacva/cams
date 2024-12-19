<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use App\Models\AuditDiaryModel;

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

}
