<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Log;


// use App\Models\UserModel;
use App\Models\AuditModel;
// use App\Models\DesignationModel;

use App\Models\FieldAuditModel;
use App\Models\TransWorkAllocationModel;
use Illuminate\Http\Request;
use DB;
use App\Services\FileUploadService;

class FieldAuditController extends Controller
{

    protected $fileUploadService;

    // Inject the FileUploadService
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }



    // public function auditfield_dropdown($viewvalue)
    // {
    //     // Access session data
    //     $chargeData = session('charge');
    //     $session_deptcode = $chargeData->deptcode; // Accessing the department code from the session
    //     $session_usertypecode = $chargeData->usertypecode;
    //     $userData = session('user');
    //     $session_userid = $userData->userid;

    //     $get_majorobjection = DB::table('audit.mst_mainobjection as ma')
    //     ->where('ma.deptcode', $session_deptcode) // Query based on department code
    //     ->where('ma.statusflag', '=', 'Y') // Filter for active or enabled records
    //     ->select('ma.objectionename', 'ma.objectiontname', 'ma.mainobjectionid') // Select the necessary fields
    //     ->orderBy('ma.objectionename', 'asc')
    //     ->get();



    //     if($session_usertypecode == View::shared('auditorlogin'))
    //     {
    //         // Perform a database query


    //         $inst_details = DB::table('audit.inst_schteammember as sm')
    //         ->join('audit.inst_auditschedule as is', 'is.auditscheduleid', '=', 'sm.auditscheduleid')
    //         ->join('audit.auditplan as ap', 'ap.auditplanid', '=', 'is.auditplanid')
    //         ->join('audit.mst_institution as in', 'in.instid', '=', 'ap.instid')
    //         ->join('audit.mst_auditeeins_category as incat', 'incat.catcode', '=', 'in.catcode')
    //         ->join('audit.mst_typeofaudit as ta', 'ta.typeofauditcode', '=', 'ap.typeofauditcode')
    //         ->join('audit.mst_auditperiod as d', 'd.auditperiodid', '=', 'ap.auditperiodid')
    //         ->where('userid', $session_userid)
    //         ->select('is.fromdate', 'is.todate', 'is.auditscheduleid','sm.auditscheduleid','sm.auditteamhead','is.auditplanid','is.fromdate','ap.instid','in.instename','incat.catename','in.mandays','sm.auditteamhead','ta.typeofauditename','d.fromyear','d.toyear','sm.schteammemberid')
    //         ->get();
    //         $teammemdel = DB::table('audit.inst_schteammember as sm');
    //         $teamheadid = 'N';
    //         $auditscheduleid = $inst_details[0]->auditscheduleid;
    //         if($inst_details[0]->auditteamhead == 'N')
    //         {

    //             $teamheaddel = DB::table('audit.inst_schteammember as sm')
    //                 ->where('auditscheduleid', $auditscheduleid)
    //                 ->where('auditteamhead', 'Y')
    //                 ->select('sm.userid')
    //                 ->get();  // added 'get()' to fetch data
    //             $teamheadid =   $teamheaddel[0]->userid;
    //         }
    //         $teammemdel = DB::table('audit.inst_schteammember as sm')

    //         ->join('audit.userchargedetails as uc', 'sm.userid', '=', 'uc.userid')
    //         ->join('audit.deptuserdetails as du', 'uc.userid', '=', 'du.deptuserid')
    //         ->join('audit.chargedetails as cd', 'uc.chargeid', '=', 'cd.chargeid')
    //         ->join('audit.mst_designation as de', 'de.desigcode', '=', 'du.desigcode')
    //         ->where('auditscheduleid', $auditscheduleid)
    //         ->where('sm.statusflag', 'Y')
    //         ->select(
    //             'sm.schteammemberid',
    //             'sm.userid',
    //             'de.desigelname',
    //             'du.username',
    //         )
    //         ->get();
    //     $majorworkdel = DB::table('audit.mst_majorworkallocationtype')
    //         ->where('statusflag', 'Y')
    //         ->select(
    //             'mst_majorworkallocationtype.majorworkallocationtypeename',
    //             'mst_majorworkallocationtype.majorworkallocationtypeid',
    //         )
    //         ->orderBy('mst_majorworkallocationtype.orderid', 'asc')
    //         ->get();
    //         // Option 1: Returning a view with the data (pass the data to the view)

    //     }
    //     else if($session_usertypecode == View::shared('auditeelogin'))
    //     {


    //         $inst_details = DB::table('audit.sliptransactiondetail as st')
    //         ->join('audit.sliphistorytransactions as t', 'st.auditslipid', '=', 't.auditslipid')
    //         ->join('audit.trans_auditslip as ta', 'ta.auditslipid', '=', 'st.auditslipid')
    //         ->join('audit.inst_auditschedule as sm', 'sm.auditscheduleid', '=', 'ta.auditscheduleid')
    //         ->join('audit.inst_schteammember as sme', 'sme.auditscheduleid', '=', 'ta.auditscheduleid')
    //         ->join('audit.deptuserdetails as dud', 'dud.deptuserid', '=', 'sme.userid')
    //         ->where('sme.auditteamhead', 'Y') // Assuming this is part of your condition
    //         ->join('audit.auditplan as ap', 'ap.auditplanid', '=', 'sm.auditplanid')
    //         ->join('audit.mst_institution as in', 'in.instid', '=', 'ap.instid')
    //         ->join('audit.mst_auditeeins_category as incat', 'incat.catcode', '=', 'in.catcode')
    //         ->join('audit.mst_typeofaudit as tad', 'tad.typeofauditcode', '=', 'ap.typeofauditcode')
    //         ->join('audit.mst_auditperiod as d', 'd.auditperiodid', '=', 'ap.auditperiodid')

    //         // Group the conditions correctly using parentheses
    //         ->where(function ($query) use ($session_userid) {
    //             $query->where('st.forwardedto', $session_userid)
    //                   ->where('st.forwardedtousertypecode', 'I')
    //                   ->orWhere(function ($query) use ($session_userid) {
    //                       $query->where('t.forwardedby', $session_userid)
    //                             ->where('t.forwardedbyusertypecode', 'A');
    //                   });
    //         })

    //         ->select(
    //             'sm.auditscheduleid',
    //             'sme.schteammemberid',
    //             'sme.userid',
    //             'sm.auditplanid',
    //             'ap.instid',
    //             'in.instename',
    //             'incat.catename',
    //             'in.mandays',
    //             'tad.typeofauditename',
    //             'd.fromyear',
    //             'd.toyear',
    //             'dud.username'
    //         )
    //         ->get();

    //         $teammemdel='';
    //         $majorworkdel='';

    //                     $get_majorobjection = DB::table('audit.mst_mainobjection as ma')
    //             ->where('ma.deptcode', $session_deptcode) // Query based on department code
    //             ->where('ma.statusflag', '=', 'Y') // Filter for active or enabled records
    //             ->select('ma.objectionename', 'ma.objectiontname', 'ma.mainobjectionid') // Select the necessary fields
    //             ->get();

    //             $teamheadid = $inst_details[0]->userid;

    //     }
    //     return view($viewvalue, compact('get_majorobjection','inst_details','teamheadid','teammemdel', 'majorworkdel'));

    // }
    public function init_fieldaudit()
    {
        $results = DB::table('audit.inst_schteammember as scm')
            ->join('audit.inst_auditschedule as sc', 'sc.auditscheduleid', '=', 'scm.auditscheduleid')
            ->join('audit.auditplan as ap', 'ap.auditplanid', '=', 'sc.auditplanid')
            ->join('audit.mst_institution as mi', 'mi.instid', '=', 'ap.instid')
            ->where('auditeeresponse', 'A')
            ->groupBy('sc.auditscheduleid', 'ap.auditplanid', 'ap.instid', 'mi.instename','sc.fromdate',
                'sc.todate')
            ->select(
                'sc.auditscheduleid',
                'sc.fromdate',
                'sc.todate',
                'ap.auditplanid',
                'ap.instid',
                'mi.instename'
            )
        ->get();
        foreach ($results as $all) {
            $all->encrypted_auditscheduleid = Crypt::encryptString($all->auditscheduleid);
            $all->formatted_fromdate = Carbon::createFromFormat('Y-m-d', $all->fromdate)->format('d/m/Y');
            $all->formatted_todate = Carbon::createFromFormat('Y-m-d', $all->todate)->format('d/m/Y');
        }

        return view('fieldaudit.init_fieldaudit', compact('results'));

    }

    public function auditfield_dropdown($encrypted_auditscheduleid)
    {
        if($encrypted_auditscheduleid)
        {
            $auditscheduleid = Crypt::decryptString($encrypted_auditscheduleid);
        }
        // Echo the ID to verify it's being passed correctly
         // Access session data
         $chargeData = session('charge');
         $session_deptcode = $chargeData->deptcode; // Accessing the department code from the session
         $session_usertypecode = $chargeData->usertypecode;
         $userData = session('user');
         $session_userid = $userData->userid;

         $get_majorobjection = DB::table('audit.mst_mainobjection as ma')
         ->where('ma.deptcode', $session_deptcode) // Query based on department code
         ->where('ma.statusflag', '=', 'Y') // Filter for active or enabled records
         ->select('ma.objectionename', 'ma.objectiontname', 'ma.mainobjectionid') // Select the necessary fields
         ->orderBy('ma.objectionename', 'asc')
         ->get();

         $inst_details = DB::table('audit.inst_schteammember as sm')
         ->join('audit.inst_auditschedule as is', 'is.auditscheduleid', '=', 'sm.auditscheduleid')
         ->join('audit.auditplan as ap', 'ap.auditplanid', '=', 'is.auditplanid')
         ->join('audit.mst_institution as in', 'in.instid', '=', 'ap.instid')
         ->join('audit.mst_auditeeins_category as incat', 'incat.catcode', '=', 'in.catcode')
         ->join('audit.mst_typeofaudit as ta', 'ta.typeofauditcode', '=', 'ap.typeofauditcode')
        //  ->join('audit.mst_auditperiod as d', 'd.auditperiodid', '=', 'ap.auditperiodid')
         ->join('audit.yearcode_mapping as yrmap', 'yrmap.auditplanid', '=', 'ap.auditplanid')
         ->join(
            'audit.mst_auditperiod as d',
            DB::raw('CAST(yrmap.yearselected AS INTEGER)'),
            '=',
            'd.auditperiodid'
        )
         ->where('userid', $session_userid)
         ->where('is.auditscheduleid', $auditscheduleid)
         // Apply STRING_AGG to aggregate years

         ->select( 'is.auditscheduleid','sm.auditscheduleid','sm.auditteamhead','is.auditplanid','is.fromdate','is.todate','ap.instid','in.instename','incat.catename','in.mandays','sm.auditteamhead','ta.typeofauditename','sm.schteammemberid'
         ,DB::raw('STRING_AGG(DISTINCT d.fromyear || \'-\' || d.toyear, \', \') as yearname') )
         ->groupby('is.auditscheduleid','sm.auditscheduleid','sm.auditteamhead','is.auditplanid','is.fromdate','is.todate','ap.instid','in.instename','incat.catename','in.mandays','sm.auditteamhead','ta.typeofauditename','sm.schteammemberid')

         ->get();
         $teammemdel = DB::table('audit.inst_schteammember as sm');
         $teamheadid = 'N';
         if($inst_details[0]->auditteamhead == 'N')
         {

             $teamheaddel = DB::table('audit.inst_schteammember as sm')
                 ->where('auditscheduleid', $auditscheduleid)
                 ->where('auditteamhead', 'Y')
                 ->select('sm.userid')
                 ->get();  // added 'get()' to fetch data
             $teamheadid =   $teamheaddel[0]->userid;
         }
         $teammemdel = DB::table('audit.inst_schteammember as sm')

         ->join('audit.userchargedetails as uc', 'sm.userid', '=', 'uc.userid')
         ->join('audit.deptuserdetails as du', 'uc.userid', '=', 'du.deptuserid')
         ->join('audit.chargedetails as cd', 'uc.chargeid', '=', 'cd.chargeid')
         ->join('audit.mst_designation as de', 'de.desigcode', '=', 'du.desigcode')
         ->where('auditscheduleid', $auditscheduleid)
         ->where('sm.statusflag', 'Y')
         ->select(
             'sm.schteammemberid',
             'sm.userid',
             'de.desigelname',
             'du.username',
         )
         ->get();
     $majorworkdel = DB::table('audit.mst_majorworkallocationtype')
         ->where('statusflag', 'Y')
         ->select(
             'mst_majorworkallocationtype.majorworkallocationtypeename',
             'mst_majorworkallocationtype.majorworkallocationtypeid',
         )
         ->orderBy('mst_majorworkallocationtype.orderid', 'asc')
         ->get();
         // Option 1: Returning a view with the data (pass the data to the view)

        // print_r($inst_details);

        return view('fieldaudit.fieldaudit', compact('get_majorobjection','inst_details','teamheadid','teammemdel', 'majorworkdel'));


        // You can also add logic to handle the ID if needed
    }

    // public function slipdetails_dropdown($viewvalue)
    // {
    //     $chargeData = session('charge');
    //         $session_deptcode = $chargeData->deptcode; // Accessing the department code from the session
    //         $session_usertypecode = $chargeData->usertypecode;
    //         $userData = session('user');
    //         $session_userid = $userData->userid;

    //         $get_majorobjection = DB::table('audit.mst_mainobjection as ma')
    //         ->where('ma.deptcode', $session_deptcode) // Query based on department code
    //         ->where('ma.statusflag', '=', 'Y') // Filter for active or enabled records
    //         ->select('ma.objectionename', 'ma.objectiontname', 'ma.mainobjectionid') // Select the necessary fields
    //         ->orderBy('ma.objectionename', 'asc')
    //         ->get();

    //     // $inst_details = DB::table('audit.sliptransactiondetail as st')
    //     //         ->join('audit.sliphistorytransactions as t', 'st.auditslipid', '=', 't.auditslipid')
    //     //         ->join('audit.trans_auditslip as ta', 'ta.auditslipid', '=', 'st.auditslipid')
    //     //         ->join('audit.inst_auditschedule as sm', 'sm.auditscheduleid', '=', 'ta.auditscheduleid')
    //     //         ->join('audit.inst_schteammember as sme', 'sme.auditscheduleid', '=', 'ta.auditscheduleid')
    //     //         ->join('audit.deptuserdetails as dud', 'dud.deptuserid', '=', 'sme.userid')
    //     //         ->where('sme.auditteamhead', 'Y') // Assuming this is part of your condition
    //     //         ->join('audit.auditplan as ap', 'ap.auditplanid', '=', 'sm.auditplanid')
    //     //         ->join('audit.mst_institution as in', 'in.instid', '=', 'ap.instid')
    //     //         ->join('audit.mst_auditeeins_category as incat', 'incat.catcode', '=', 'in.catcode')
    //     //         ->join('audit.mst_typeofaudit as tad', 'tad.typeofauditcode', '=', 'ap.typeofauditcode')
    //     //         // ->join('audit.mst_auditperiod as d', 'd.auditperiodid', '=', 'ap.auditperiodid')
    //     //         ->join('audit.yearcode_mapping as yrmap', 'yrmap.auditplanid', '=', 'ap.auditplanid')
    //     //         ->join(
    //     //             'audit.mst_auditperiod as d',
    //     //             DB::raw('CAST(yrmap.yearselected AS INTEGER)'),
    //     //             '=',
    //     //             'd.auditperiodid'
    //     //         )

    //     //         // Group the conditions correctly using parentheses
    //     //         ->where(function ($query) use ($session_userid) {
    //     //             $query->where('st.forwardedto', $session_userid)
    //     //                   ->where('st.forwardedtousertypecode', 'I')
    //     //                   ->orWhere(function ($query) use ($session_userid) {
    //     //                       $query->where('t.forwardedby', $session_userid)
    //     //                             ->where('t.forwardedbyusertypecode', 'A');
    //     //                   });
    //     //         })

    //     //         ->select(
    //     //             'sm.auditscheduleid',
    //     //             'sme.schteammemberid',
    //     //             'sme.userid',
    //     //             'sm.auditplanid',
    //     //             'ap.instid',
    //     //             'in.instename',
    //     //             'incat.catename',
    //     //             'in.mandays',
    //     //             'tad.typeofauditename',
    //     //             'd.fromyear',
    //     //             'd.toyear',
    //     //             'dud.username',
    //     //             DB::raw('STRING_AGG(d.fromyear || \'-\' || d.toyear, \', \') as yearname'),
    //     //         )
    //     //         ->get();

    //             $inst_details = DB::table('audit.sliptransactiondetail as st')
    //         ->join('audit.sliphistorytransactions as t', 'st.auditslipid', '=', 't.auditslipid')
    //         ->join('audit.trans_auditslip as ta', 'ta.auditslipid', '=', 'st.auditslipid')
    //         ->join('audit.inst_auditschedule as sm', 'sm.auditscheduleid', '=', 'ta.auditscheduleid')
    //         ->join('audit.inst_schteammember as sme', 'sme.auditscheduleid', '=', 'ta.auditscheduleid')
    //         ->join('audit.deptuserdetails as dud', 'dud.deptuserid', '=', 'sme.userid')
    //         ->where('sme.auditteamhead', 'Y') // Assuming this is part of your condition
    //         ->join('audit.auditplan as ap', 'ap.auditplanid', '=', 'sm.auditplanid')
    //         ->join('audit.mst_institution as "in"', '"in".instid', '=', 'ap.instid') // Quote reserved keywords like 'in'
    //         ->join('audit.mst_auditeeins_category as incat', 'incat.catcode', '=', '"in".catcode')
    //         ->join('audit.mst_typeofaudit as tad', 'tad.typeofauditcode', '=', 'ap.typeofauditcode')
    //         ->join('audit.yearcode_mapping as yrmap', 'yrmap.auditplanid', '=', 'ap.auditplanid')
    //         ->join(
    //             'audit.mst_auditperiod as d',
    //             DB::raw('CAST(yrmap.yearselected AS INTEGER)'),
    //             '=',
    //             'd.auditperiodid'
    //         )
    //         ->where(function ($query) use ($session_userid) {
    //             $query->where('st.forwardedto', $session_userid)
    //                 ->where('st.forwardedtousertypecode', 'I')
    //                 ->orWhere(function ($query) use ($session_userid) {
    //                     $query->where('t.forwardedby', $session_userid)
    //                             ->where('t.forwardedbyusertypecode', 'A');
    //                 });
    //         })
    //         ->select(
    //             'sm.auditscheduleid',
    //             'sme.schteammemberid',
    //             'sme.userid',
    //             'sm.auditplanid',
    //             'ap.instid',
    //             '"in".instename',
    //             'incat.catename',
    //             '"in".mandays',
    //             'tad.typeofauditename',
    //             'dud.username',
    //             DB::raw('STRING_AGG(DISTINCT d.fromyear || \'-\' || d.toyear, \', \') as yearname') // Apply STRING_AGG to aggregate years
    //         )
    //         ->groupBy(
    //             'sm.auditscheduleid',
    //             'sme.schteammemberid',
    //             'sme.userid',
    //             'sm.auditplanid',
    //             'ap.instid',
    //             '"in".instename',
    //             'incat.catename',
    //             '"in".mandays',
    //             'tad.typeofauditename',
    //             'dud.username'
    //         )
    //         ->get();

       
    

    //             $teammemdel='';
    //             $majorworkdel='';

    //                         $get_majorobjection = DB::table('audit.mst_mainobjection as ma')
    //                 ->where('ma.deptcode', $session_deptcode) // Query based on department code
    //                 ->where('ma.statusflag', '=', 'Y') // Filter for active or enabled records
    //                 ->select('ma.objectionename', 'ma.objectiontname', 'ma.mainobjectionid') // Select the necessary fields
    //                 ->get();

    //                 $teamheadid = $inst_details[0]->userid;

    //                 //print_r($inst_details);

    //                 return view($viewvalue, compact('get_majorobjection','inst_details','teamheadid','teammemdel', 'majorworkdel'));

    // }

    
    public function slipdetails_dropdown($viewvalue)
    {
        $chargeData = session('charge');
            $session_deptcode = $chargeData->deptcode; // Accessing the department code from the session
            $session_usertypecode = $chargeData->usertypecode;
            $userData = session('user');
            $session_userid = $userData->userid;

            $get_majorobjection = DB::table('audit.mst_mainobjection as ma')
            ->where('ma.deptcode', $session_deptcode) // Query based on department code
            ->where('ma.statusflag', '=', 'Y') // Filter for active or enabled records
            ->select('ma.objectionename', 'ma.objectiontname', 'ma.mainobjectionid') // Select the necessary fields
            ->orderBy('ma.objectionename', 'asc')
            ->get();

                $inst_details = DB::table('audit.sliptransactiondetail as st')
            ->join('audit.sliphistorytransactions as t', 'st.auditslipid', '=', 't.auditslipid')
            ->join('audit.trans_auditslip as ta', 'ta.auditslipid', '=', 'st.auditslipid')
            ->join('audit.inst_auditschedule as sm', 'sm.auditscheduleid', '=', 'ta.auditscheduleid')
            ->join('audit.inst_schteammember as sme', 'sme.auditscheduleid', '=', 'ta.auditscheduleid')
            ->join('audit.deptuserdetails as dud', 'dud.deptuserid', '=', 'sme.userid')
            ->where('sme.auditteamhead', 'Y') // Assuming this is part of your condition
            ->join('audit.auditplan as ap', 'ap.auditplanid', '=', 'sm.auditplanid')
            ->join('audit.mst_institution as "in"', '"in".instid', '=', 'ap.instid') // Quote reserved keywords like 'in'
            ->join('audit.mst_auditeeins_category as incat', 'incat.catcode', '=', '"in".catcode')
            ->join('audit.mst_typeofaudit as tad', 'tad.typeofauditcode', '=', 'ap.typeofauditcode')
            ->join('audit.yearcode_mapping as yrmap', 'yrmap.auditplanid', '=', 'ap.auditplanid')
            ->join(
                'audit.mst_auditperiod as d',
                DB::raw('CAST(yrmap.yearselected AS INTEGER)'),
                '=',
                'd.auditperiodid'
            )
            ->where(function ($query) use ($session_userid) {
                $query->where('st.forwardedto', $session_userid)
                    ->where('st.forwardedtousertypecode', 'I')
                    ->orWhere(function ($query) use ($session_userid) {
                        $query->where('t.forwardedby', $session_userid)
                                ->where('t.forwardedbyusertypecode', 'A');
                    });
            })
            ->select(
                'sm.auditscheduleid',
                'sme.schteammemberid',
                'sme.userid',
                'sm.auditplanid',
                'ap.instid',
                '"in".instename',
                'incat.catename',
                '"in".mandays',
                'tad.typeofauditename',
                'dud.username',
                DB::raw('STRING_AGG(DISTINCT d.fromyear || \'-\' || d.toyear, \', \') as yearname') // Apply STRING_AGG to aggregate years
            )
            ->groupBy(
                'sm.auditscheduleid',
                'sme.schteammemberid',
                'sme.userid',
                'sm.auditplanid',
                'ap.instid',
                '"in".instename',
                'incat.catename',
                '"in".mandays',
                'tad.typeofauditename',
                'dud.username'
            )
            ->get();

       
    

                $teammemdel='';
                $majorworkdel='';

                            $get_majorobjection = DB::table('audit.mst_mainobjection as ma')
                    ->where('ma.deptcode', $session_deptcode) // Query based on department code
                    ->where('ma.statusflag', '=', 'Y') // Filter for active or enabled records
                    ->select('ma.objectionename', 'ma.objectiontname', 'ma.mainobjectionid') // Select the necessary fields
                    ->get();

                    if(count($inst_details))
                    {
                        $teamheadid = $inst_details[0]->userid;

                    }
                    else $teamheadid = '';

                    //print_r($inst_details);

                    return view($viewvalue, compact('get_majorobjection','inst_details','teamheadid','teammemdel', 'majorworkdel'));

    }
    public function getauditslip(Request $request)
    {
        // Retrieve 'charge' from session
        $chargedel = session('charge');
        $userdel = session('user');

        // Ensure that 'charge' exists in session and 'userchargeid' is available
        // if (!$chargedel || !isset($chargedel->userchargeid)) {
        //     return response()->json(['success' => false, 'message' => 'User ID not provided'], 400);
        // }

        $usertypecode = $chargedel->usertypecode;

        if($usertypecode  == View::shared('auditorlogin'))
        {
            $userchargeid = $chargedel->userchargeid;
            $auditteamhead = $chargedel->auditteamhead;
            $auditscheduleid        =   $request->input('auditscheduleid');
        }
        else if($usertypecode  == View::shared('auditeelogin'))
        {
            $userid = $userdel->userid;
        }

        // Validate auditslipid if it's provided in the request
        if ($request->input('auditslipid')) {
            try {
                // Decrypt the auditslipid
                $auditslipid = Crypt::decryptString($request->auditslipid);
                $request->merge(['auditslipid' => $auditslipid]);

                // Validate decrypted auditslipid
                $request->validate([
                    'auditslipid' => 'required|integer',
                ], [
                    'required' => 'The :attribute field is required.',
                    'integer' => 'The :attribute field must be a valid number.',
                ]);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['success' => false, 'message' => 'Invalid auditslipid.'], 400);
            }
        }
        else    $auditslipid    =   '';

        // Since 'userchargeid' is from session, no need to validate it via request
        // But ensure userchargeid exists in session


        if($usertypecode  == View::shared('auditorlogin'))
        {
            if (!$userchargeid) {
                return response()->json(['success' => false, 'message' => 'User ID not provided'], 400);
            }
            $alldetails = FieldAuditModel::fetchdata($userchargeid,$auditslipid,$auditteamhead,$auditscheduleid);

            foreach ($alldetails as $all) {
                $all->encrypted_auditslipid = Crypt::encryptString($all->auditslipid);
            }


        }
        else if($usertypecode  == View::shared('auditeelogin'))
        {
            if (!$userid) {
                return response()->json(['success' => false, 'message' => 'User ID not provided'], 400);
            }
            $alldetails = FieldAuditModel::fetchdata_auditee($userid, $auditslipid);

            // Check if 'auditDetails' is not empty
            if ($alldetails['auditDetails']->isNotEmpty()) {
                foreach ($alldetails['auditDetails'] as $all) {
                    $all->encrypted_auditslipid = Crypt::encryptString($all->auditslipid);
                }
            }


        }


        // Return response with the data
        if ($alldetails->isNotEmpty()) {
            return response()->json(['success' => true, 'data' => $alldetails]);
        } else {
           return response()->json(['success' => true, 'message' => 'No auditslips found'], 200);
        }
    }
    public function auditeereply(Request $request, $userId = null)
    {


        $action =   $request->input('action');

        // print_r($request->all());


        $auditslipid = Crypt::decryptString($request->auditslipid);  // Decrypt if ID is provided
        $request->merge(['auditslipid' => $auditslipid]);

        $fileUploadId   =   '';

        if(($action == 'insert') || (($action == 'update') && ($request->hasFile('auditee_upload') && ($request->input('fileuploadid')) && ($request->input('fileuploadstatus') == 'Y'))  ))
        {
            // echo 'hi';
            if(($action == 'update') && ($request->input('fileuploadstatus') == 'Y') && ($request->input('fileuploadid')))
            {
                $fileUploadId   =   $request->input('fileuploadid');
            }
            $file = $request->file('auditee_upload');
            $destinationPath = 'uploads/slipauditor';  // Define your destination path


            $uploadResult = $this->fileUploadService->uploadFile($file, $destinationPath,$fileUploadId);

            if (is_array($uploadResult)) {
                return response()->json(['errors' => $uploadResult], 400);
            } elseif ($uploadResult instanceof \Illuminate\Http\JsonResponse) {
                // Extract the data from the JsonResponse
                $uploadResultData = $uploadResult->getData(true); // Returns the data as an array

                // Now, you can access the array
                $fileUploadId = $uploadResultData['fileupload_id'];

            }
        }
        elseif(($action == 'update') && ($request->input('fileuploadstatus') == 'N') && ($request->input('fileuploadid')))
        {

            $fileUploadId   =   $request->input('fileuploadid');
        }

        // echo  $fileUploadId ;

        if($fileUploadId)
        {
            $request->validate([
                // 'auditee_upload' => 'required',  // Optional, max length of 255
                'auditeeremarks_append' => 'required', // Optional, max length of 255
            ], [
                'required' => 'The :attribute field is required.',
                'alpha' => 'The :attribute field must contain only letters.',
                'integer' => 'The :attribute field must be a valid number.',
                'regex' => 'The :attribute field must be a valid number.',
                'alpha_num' => 'The :attribute field must contain only letters and numbers.',
                'max' => 'The :attribute field must not exceed :max characters.',
            ]);

            // Process content for remarks
            $content = json_encode([
                'content' => $request->input('auditeeremarks_append')
            ]);

            $userdel = session('user');
            $userid = $userdel->userid;


            // Prepare the data to insert or update
            $data = [
                'auditeeremarks' => $content,
                'updatedon'         =>  now(),
                'updatedby'         =>  $userid
            ];

            try {
                // Insert or update the audit slip record
                    $auditslipdel = FieldAuditModel::createIfNotExistsOrUpdate($data, $auditslipid);

                    $auditslipnumber    =   $auditslipdel['slipnumber'];
                    $auditslipid    =   $auditslipdel['auditslipid'];
                // Proceed only if the audit slip was successfully created/updated
                if ($auditslipid) {
                    // Create a relation for the file upload
                    $data = [
                        'fileuploadid' => $fileUploadId,
                        'auditslipid' => $auditslipid,
                        'statusflag' => 'Y',
                        'updatedon'         =>  now(),
                        'updatedby'         =>  $userid
                    ];




                    $slipfileuploadid = FieldAuditModel::slipfileupload($data,$auditslipid,$fileUploadId);

                    if ($slipfileuploadid)
                    {

                        // Logic to move to the next condition, e.g., forwarding

                        if($request->input('finaliseflag') == 'Y')
                        {

                            $chargeData = session('charge');
                            $session_usertypecode = $chargeData->usertypecode; // Accessing the department code from the session


                            $teamheadids = FieldAuditModel::fetchdata_teamheaduserid($auditslipid);
                            $teamheadid  =   $teamheadids[0];


                                if ($teamheadid) {
                                    // Handle the insertion of new transaction for the auditee
                                    $insertdata = [
                                        'auditslipid' => $auditslipid,
                                        'createdby' => $userid,
                                        'createdon' =>now(),
                                        'forwardedto' => $teamheadid,
                                        'forwardedtousertypecode' => 'A',
                                        'updatedby' => $userid,
                                        'updatedbyusertypecode' => $session_usertypecode,
                                        'updatedon' => now(),
                                    ];

                                    $updatedata = [
                                        'forwardedto' => $teamheadid,
                                        'forwardedtousertypecode' => 'A',
                                        'updatedby' => $userid,
                                        'updatedbyusertypecode' => 'I',
                                        'updatedon' =>now(),
                                    ];

                                    // Insert transaction and update
                                    $transactionResult = FieldAuditModel::create_transactiondel($insertdata, $updatedata, $auditslipid);

                                    if ($transactionResult) {
                                        // Insert history transaction if transaction was successful
                                        $historyData = [
                                            'auditslipid' => $auditslipid,
                                            'forwardedby' => $userid,
                                            'forwardedbyusertypecode' => $session_usertypecode,
                                            'forwardedto' => $teamheadid,
                                            'forwardedtousertypecode' => 'A',
                                            'forwardedon' => now(),
                                            'transstatus' => 'A',
                                            'processcode' => 'R',
                                        ];

                                        $historyTransaction = FieldAuditModel::insert_historytransactiondel($historyData);

                                        if ($historyTransaction) {
                                            // Update the auditslip table after inserting history transaction
                                            $updateData = ['processcode' => 'R','auditeerepliedon' => 'now()'];
                                            $updateSlip = FieldAuditModel::update_auditsliptable($updateData, $auditslipid);

                                            if ($updateSlip) {
                                                //DB::commit();
                                                return response()->json(['success' => true, 'message' => 'Audit slip forwarded to team head successfully.','data'=> $auditslipnumber ]);
                                            } else {
                                                throw new \Exception("Failed to update the auditslip table.");
                                            }
                                        } else {
                                            throw new \Exception("Failed to insert history transaction.");
                                        }
                                    } else {
                                        throw new \Exception("Failed to insert or update transaction.");
                                    }
                                }

                        }
                        else
                        {
                            return response()->json(['success' => true, 'message' => 'Audit slip Data Saved successfully.','data'=> $auditslipnumber]);
                        }

                    } else {
                        throw new \Exception("Failed to create file upload relation.");
                    }
                } else {
                    throw new \Exception("Failed to create or update the audit slip.");
                }
            } catch (\Exception $e) {
                // Rollback the transaction on failure
                // DB::rollBack();
                return response()->json(['error' => $e->getMessage()], 400);
            }



        }
    }
    public function update_slip(Request $request)
    {

          // Retrieve 'charge' from session
          $chargedel = session('charge');



          // Ensure that 'charge' exists in session and 'userchargeid' is available
          if (!$chargedel || !isset($chargedel->userchargeid)) {
              return response()->json(['success' => false, 'message' => 'User ID not provided'], 400);
          }

          $userchargeid = $chargedel->userchargeid;

        if($request->auditslipid)
        {
            $auditslipid = Crypt::decryptString($request->auditslipid);  // Decrypt if ID is provided
            $request->merge(['auditslipid' => $auditslipid]);
        }

        $processcode    =   $request->processcode;

        $data   =   array(
            'processcode'   =>  $processcode,
            'updatedon'     =>  now(),
            'updatedby'     =>  $userchargeid,
        );

        try
        {
            $auditslipid = FieldAuditModel::createIfNotExistsOrUpdate($data, $auditslipid);
            if ($auditslipid) {
                return response()->json(['success' => true, 'message' => 'Audit Slip Process Completed successfully.']);
            } else {
                throw new \Exception("Failed to update the auditslip table.");
            }
        }
        catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['success' => false, 'message' => 'Invalid auditslipid.'], 400);
        }
    }

    public function getviewauditslip(Request $request)
    {
        // Retrieve 'charge' from session
        $chargedel = session('charge');

        // Ensure that 'charge' exists in session and 'userchargeid' is available
        if (!$chargedel || !isset($chargedel->userchargeid)) {
            return response()->json(['success' => false, 'message' => 'User ID not provided'], 400);
        }

        $usertypecode = $chargedel->usertypecode;

        if($usertypecode  == View::shared('auditorlogin'))
        {
            $userchargeid = $chargedel->userchargeid;
            $auditteamhead = $chargedel->auditteamhead;
            $auditscheduleid        =   $request->input('auditscheduleid');
        }

        // echo 'jo';

        // Validate auditslipid if it's provided in the request
        if ($request->input('auditslipid')) {
            try {
                // Decrypt the auditslipid
                $auditslipid = Crypt::decryptString($request->auditslipid);
                $request->merge(['auditslipid' => $auditslipid]);

                // Validate decrypted auditslipid
                $request->validate([
                    'auditslipid' => 'required|integer',
                ], [
                    'required' => 'The :attribute field is required.',
                    'integer' => 'The :attribute field must be a valid number.',
                ]);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['success' => false, 'message' => 'Invalid auditslipid.'], 400);
            }
        }
        else    $auditslipid    =   '';



        // Since 'userchargeid' is from session, no need to validate it via request
        // But ensure userchargeid exists in session


        if($usertypecode  == View::shared('auditorlogin'))
        {
            if (!$userchargeid) {
                return response()->json(['success' => false, 'message' => 'User ID not provided'], 400);


            }
            $alldetails = FieldAuditModel::getviewauditslip_withreply($userchargeid,$auditslipid,$auditscheduleid,$auditteamhead );

            // print_r($alldetails);
            if ($alldetails['auditDetails']->isNotEmpty()) {
                foreach ($alldetails['auditDetails'] as $all) {
                    $all->encrypted_auditslipid = Crypt::encryptString($all->auditslipid);
                }
            }

            // foreach ($alldetails as $all) {
            //     $all->encrypted_auditslipid = Crypt::encryptString($all->auditslipid);
            // }


        }




        // // Return response with the data
        if ($alldetails->isNotEmpty()) {
            return response()->json(['success' => true, 'data' => $alldetails]);
        } else {
           return response()->json(['success' => true, 'message' => 'No auditslips found'], 200);
        }
    }


    public function audislip_insert(Request $request, $userId = null)
    {
        // \Log::info($request->all());

        $action =   $request->input('action');

        if($action == 'insert') $auditslipid    =   '';
        elseif (($action == 'update') && ($request->auditslipid)) {
            $auditslipid = Crypt::decryptString($request->auditslipid);  // Decrypt if ID is provided
            $request->merge(['auditslipid' => $auditslipid]);
        }


        $fileUploadId   =   '';

        if(($action == 'insert') || (($action == 'update') && ($request->hasFile('upload_file') && ($request->input('fileuploadid')) && ($request->input('fileuploadstatus') == 'Y'))  ))
        {
            if(($action == 'update') && ($request->input('fileuploadstatus') == 'Y') && ($request->input('fileuploadid')))
            {
                $fileUploadId   =   $request->input('fileuploadid');
            }
            $file = $request->file('upload_file');
            $destinationPath = 'uploads/slipauditor';  // Define your destination path

            $uploadResult = $this->fileUploadService->uploadFile($file, $destinationPath,$fileUploadId);

            if (is_array($uploadResult)) {
                return response()->json(['errors' => $uploadResult], 400);
            } elseif ($uploadResult instanceof \Illuminate\Http\JsonResponse) {
                // Extract the data from the JsonResponse
                $uploadResultData = $uploadResult->getData(true); // Returns the data as an array

                // Now, you can access the array
                $fileUploadId = $uploadResultData['fileupload_id'];

            }
        }
        elseif(($action == 'update') && ($request->input('fileuploadstatus') == 'N') && ($request->input('fileuploadid')))
        {

            $fileUploadId   =   $request->input('fileuploadid');
        }


        if($fileUploadId)
        {
            // Validate the request inputs
            $request->validate([
                'majorobjectioncode' => ['required', 'string', 'regex:/^\d+$/'], // Ensures only digits, allows leading zeros
                'minorobjectioncode' => ['required', 'string', 'regex:/^\d+$/'], // Ensures only digits, allows leading zeros
                'amount_involved' => 'required|integer',
                'severityid' => 'required|alpha|max:1', // Alphanumeric (letters and numbers)
                'liability' => 'required|alpha|max:1',
                // 'currentslipnumber' => 'required|integer',
                'slipdetails' => 'nullable|string|max:255',  // Optional, max length of 255
                // 'auditorremarks' => 'nullable|string|max:255', // Optional, max length of 255
            ], [
                'required' => 'The :attribute field is required.',
                'alpha' => 'The :attribute field must contain only letters.',
                'integer' => 'The :attribute field must be a valid number.',
                'regex' => 'The :attribute field must be a valid number.',
                'alpha_num' => 'The :attribute field must contain only letters and numbers.',
                'max' => 'The :attribute field must not exceed :max characters.',
            ]);

            // Process content for remarks
            $content = json_encode([
                'content' => $request->input('remarks')
            ]);

            $chargedel = session('charge');
            $userchargeid = $chargedel->userchargeid;

            // Prepare the data to insert or update
            $data = [
                'auditscheduleid' => $request->input('auditscheduleid'),
                'schteammemberid' => $request->input('schteammemberid'),
                'auditplanid' =>  $request->input('auditplanid'),
                'mainobjectionid' => $request->input('majorobjectioncode'),
                'subobjectionid' => $request->input('minorobjectioncode'),
                'amtinvolved' => $request->input('amount_involved'),
                'tempslipnumber' => 1,
                'mainslipnumber' => $request->input('currentslipnumber'),
                'fileuploadid' => $fileUploadId,  // Ensure fileUploadId is set here
                'severity' => $request->input('severityid'),
                'liability' => $request->input('liability'),
                'slipdetails' => $request->input('slipdetails'),
                'auditorremarks' => $content,
                'statusflag' => 'Y',  // This is set as default, but you can change it based on conditions


            ];

            if ($request->input('liability') == 'Y') {
                $data['liabilityname'] = $request->input('liabilityname');
            }

            if($action == 'insert')
            {

                $data ['processcode'] = 'E';

                $data ['createdon'] = now();
                $data ['createdby'] = $userchargeid;
            }
            elseif($action == 'update')
            {
                $data ['updatedon'] = now();
                $data ['updatedby'] = $userchargeid;
            }


            // Start a transaction to ensure data consistency
           // DB::beginTransaction();

        try {
            // Insert or update the audit slip record

                $auditslipdel = FieldAuditModel::createIfNotExistsOrUpdate($data, $auditslipid);

                $auditslipnumber    =   $auditslipdel['slipnumber'];
                $auditslipid    =   $auditslipdel['auditslipid'];
            // Proceed only if the audit slip was successfully created/updated
            if ($auditslipid) {
                // Create a relation for the file upload
                $data = [
                    'fileuploadid' => $fileUploadId,
                    'auditslipid' => $auditslipid,
                    'statusflag' => 'Y',
                ];

                if($action == 'insert')
                {
                    $data ['createdon'] = now();
                    $data ['createdby'] = $userchargeid;
                }
                elseif($action == 'update')
                {
                    $data ['updatedon'] = now();
                    $data ['updatedby'] = $userchargeid;
                }


                $slipfileuploadid = FieldAuditModel::slipfileupload($data,$auditslipid,$fileUploadId);

                if ($slipfileuploadid)
                {
                    // Logic to move to the next condition, e.g., forwarding

                    if($request->input('finaliseflag') == 'Y')
                    {
                        $chargeData = session('charge');
                        $session_usertypecode = $chargeData->usertypecode; // Accessing the department code from the session
                        $session_userchargeid = $chargeData->userchargeid;

                        if ($chargeData->auditteamhead == 'N')
                        {
                            $teamheadid = $request->input('teamheadid');
                            $insertdata = [
                                'auditslipid' => $auditslipid,
                                'createdby' => $session_userchargeid,
                                'createdon' => now(),
                                'forwardedto' => $teamheadid,
                                'forwardedtousertypecode' => 'A',
                                'updatedby' => $session_userchargeid,
                                'updatedbyusertypecode' => $session_usertypecode,
                                'updatedon' => now(),
                            ];

                            // Insert transaction
                            $transactionResult = FieldAuditModel::create_transactiondel($insertdata, '', $auditslipid);

                            if ($transactionResult) {
                                // Insert history transaction if transaction was successful
                                $historyData = [
                                    'auditslipid' => $auditslipid,
                                    'forwardedby' => $session_userchargeid,
                                    'forwardedbyusertypecode' => $session_usertypecode,
                                    'forwardedto' => $teamheadid,
                                    'forwardedtousertypecode' => 'A',
                                    'forwardedon' => DB::raw('now()'),
                                    'transstatus' => 'A',
                                    'processcode' => 'F',
                                ];

                                $historyTransaction = FieldAuditModel::insert_historytransactiondel($historyData);

                                if ($historyTransaction) {
                                    // Update the auditslip table after inserting history transaction
                                    $updateData = ['processcode' => 'S','forwardedby'=> $session_userchargeid,'forwardedon'=>now()];

                                    $updateSlip = FieldAuditModel::update_auditsliptable($updateData, $auditslipid);

                                    if ($updateSlip) {
                                        // DB::commit();
                                        return response()->json(['success' => true, 'message' => 'Audit slip Details Forward to Team Head successfully.','data'=>$auditslipnumber]);
                                    } else {
                                        throw new \Exception("Failed to update the auditslip table.");
                                    }
                                } else {
                                    throw new \Exception("Failed to insert history transaction.");
                                }
                            } else {
                                throw new \Exception("Failed to insert or update transaction.");
                            }
                        } else {
                            // Handle the other conditions where the team head is not 'N'
                            $instid = $request->input('instid');
                            $auditeeuserids = FieldAuditModel::fetchdata_auditeeuserid($instid);
                            $auditeeuserid  =   $auditeeuserids[0];

                            if ($auditeeuserid) {
                                // Handle the insertion of new transaction for the auditee
                                $insertdata = [
                                    'auditslipid' => $auditslipid,
                                    'createdby' => $session_userchargeid,
                                    'createdon' =>now(),
                                    'forwardedto' => $auditeeuserid,
                                    'forwardedtousertypecode' => 'I',
                                    'updatedby' => $session_userchargeid,
                                    'updatedbyusertypecode' => $session_usertypecode,
                                    'updatedon' => now(),
                                ];

                                $updatedata = [
                                    'forwardedto' => $auditeeuserid,
                                    'forwardedtousertypecode' => 'I',
                                    'updatedby' => $session_userchargeid,
                                    'updatedbyusertypecode' => 'A',
                                    'updatedon' =>now(),
                                ];

                                // Insert transaction and update
                                $transactionResult = FieldAuditModel::create_transactiondel($insertdata, $updatedata, $auditslipid);

                                if ($transactionResult) {
                                    // Insert history transaction if transaction was successful
                                    $historyData = [
                                        'auditslipid' => $auditslipid,
                                        'forwardedby' => $session_userchargeid,
                                        'forwardedbyusertypecode' => $session_usertypecode,
                                        'forwardedto' => $auditeeuserid,
                                        'forwardedtousertypecode' => 'I',
                                        'forwardedon' => now(),
                                        'transstatus' => 'A',
                                        'processcode' => 'F',
                                    ];

                                    $historyTransaction = FieldAuditModel::insert_historytransactiondel($historyData);

                                    if ($historyTransaction) {
                                        // Update the auditslip table after inserting history transaction
                                        $updateData = ['processcode' => 'F','approvedon'=>now(),'approvedby'=>$session_userchargeid];
                                        $updateSlip = FieldAuditModel::update_auditsliptable($updateData, $auditslipid);

                                        if ($updateSlip) {
                                            //DB::commit();
                                            return response()->json(['success' => true, 'message' => 'Audit Slip Forwarded to Institution successfully.','data'=>$auditslipnumber]);
                                        } else {
                                            throw new \Exception("Failed to update the auditslip table.");
                                        }
                                    } else {
                                        throw new \Exception("Failed to insert history transaction.");
                                    }
                                } else {
                                    throw new \Exception("Failed to insert or update transaction.");
                                }
                            }
                        }
                    }
                    else
                    {
                        return response()->json(['success' => true, 'message' => 'Audit slip Data Saved Successfully.','data'=>$auditslipnumber]);
                    }

                } else {
                    throw new \Exception("Failed to create file upload relation.");
                }
            } else {
                throw new \Exception("Failed to create or update the audit slip.");
            }
        } catch (\Exception $e) {
            // Rollback the transaction on failure
            // DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }



        }
    }




    public function getsubobjection(Request $request)
    {
        $mainobjectioncode  =   $request->input('mainobjectioncode');
        $subobjectiondel    =   FieldAuditModel::getsubobjection($mainobjectioncode);
        // Fetch user data based on deptuserid
        // $user = UserModel::where('deptuserid', $deptuserid)->first(); // Adjust query as needed

        if ($subobjectiondel) {
            return response()->json(['success' => true, 'data' => $subobjectiondel]);
        } else {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
    }



    private function checkForDuplicates($data, $currentUserId = null)
    {
        // Check if email, mobile number, or IFHRMS number exist with a different user
        if ($currentUserId) {
            // Check if email exists with a different user
            $this->checkFieldForDuplicate('email', $data['email'], $currentUserId);
            // Check if mobile number exists with a different user
            $this->checkFieldForDuplicate('mobilenumber', $data['mobilenumber'], $currentUserId);
            // Check if IFHRMS number exists with a different user
            $this->checkFieldForDuplicate('ifhrmsno', $data['ifhrmsno'], $currentUserId);
        } else {
            // For new user, just check for individual field duplicates
            $this->checkFieldForDuplicate('email', $data['email']);
            $this->checkFieldForDuplicate('mobilenumber', $data['mobilenumber']);
            $this->checkFieldForDuplicate('ifhrmsno', $data['ifhrmsno']);
        }

        // Check the combination of all three fields for an existing record
        $existingUser = DB::table('users')
                        ->where('email', $data['email'])
                        ->where('mobilenumber', $data['mobilenumber'])
                        ->where('ifhrmsno', $data['ifhrmsno'])
                        ->first();

        if ($existingUser) {
            throw new Exception('The combination of email, mobile number, and IFHRMS number is already associated with a different user.');
        }
    }

    private function checkFieldForDuplicate($field, $value, $currentUserId = null)
    {
        // Check for duplicates in individual fields
        $query = DB::table('users')->where($field, $value);

        if ($currentUserId) {
            // Exclude the current user if updating
            $query->where('id', '!=', $currentUserId);
        }

        $exists = $query->exists();

        if ($exists) {
            throw new Exception("The $field is already associated with a different user.");
        }
    }
////////////////////////////////Work Allocation/////////////////////////////////////////////

public function insert_workAllocation(Request $request)
    {


        $request->validate([
            'finaliseflag'         => 'required', // Ensures only digits, allows leading zeros
            'auditscheduleId'      =>  'required',         // Only alphabets (no numbers or symbols)
            'team_mem'             =>  'required',             // Alphanumeric (letters and numbers)
            'majorwa'              =>  'required',
        ]);

        if ($request->work_action == 'update') {
            $workallocationid     = Crypt::decryptString($request->workallocationid);
            $request->merge(['workallocationid	' => $workallocationid]);
        }
        $data = [
            'auditscheduleid' => $request->input('auditscheduleId'),
            'schteammemberid' => $request->input('team_mem'),
            'majorwa'         => $request->input('majorwa'),
            'statusflag' => $request->input('finaliseflag'),
            'subtypecode' => $request->input('minorwa'),

        ];
        $minortypeID = $request->input('minorwa');
        if ($request->work_action == 'update') {

            $existingwork = TransWorkAllocationModel::fetchexistingwork($data);
            // foreach ($minortypeID as $subtypecode) {
            $auditscheduleid = trim($request->input('auditscheduleId'));

            if ($existingwork) {

                $existingWorkIds = $existingwork
                    ->filter(function ($work) use ($auditscheduleid) { // Pass $auditscheduleid into the callback
                        return  $work->auditscheduleid == $auditscheduleid && $work->statusflag === 'Y';
                    })
                    ->pluck('subtypecode')
                    ->toArray();

                $minortypeID  = $request->input('minorwa');
                // print_r($existingWorkIds);
                // print_r($minortypeID);
                $existingWorkIdsEqualToMinortypecode = empty(array_diff($minortypeID, $existingWorkIds)) && empty(array_diff($existingWorkIds, $minortypeID));
                $newIdsExist = array_diff($minortypeID, $existingWorkIds);
                $idsToRemove = array_diff($existingWorkIds, $minortypeID);
                // print_r($newIdsExist);
                if (!empty($newIdsExist)) {
                    foreach ($minortypeID as $subtypecodeAdd) {
                        // Check if the subtypecode exists in minortype
                        if (in_array($subtypecodeAdd, $newIdsExist)) {
                            // echo 'if';
                            // print_r($subtypecodeAdd);
                            TransWorkAllocationModel::create([
                                'auditscheduleid' => $request->input('auditscheduleId'),
                                'schteammemberid' => $request->input('team_mem'),
                                'statusflag' => $request->input('finaliseflag'),
                                'subtypecode' => $subtypecodeAdd,
                                'createdon' => now(),
                                'updatedon' => now(),
                            ]);
                        } else {
                            // echo 'else';
                            // print_r($subtypecodeAdd);
                            // Add the new subtypecode that is not in minortype
                            TransWorkAllocationModel::updatework($data, $subtypecodeAdd, $request->input('auditscheduleId'));
                        }
                    }
                }
                if (!empty($idsToRemove)) {
                    foreach ($minortypeID as $subtypecodeAdd) {
                        // Check if the current minor type is in the removal list
                        if (in_array($subtypecodeAdd, $idsToRemove)) {
                            // If it's in the removal list, update it as removed
                            // TransWorkAllocationModel::where('subtypecode', $subtypecodeAdd)
                            //     ->where('auditscheduleid', $request->input('auditscheduleId'))
                            //     ->where('schteammemberid', $request->input('team_mem'))
                            //     ->update([
                            //         'statusflag' => 'N', // Mark as removed
                            //         'updatedon' => now(), // Update timestamp
                            //     ]);
                        } else {
                            // If not in the removal list, keep it active
                            TransWorkAllocationModel::where('subtypecode', $subtypecodeAdd)
                                ->where('auditscheduleid', $request->input('auditscheduleId'))
                                ->where('schteammemberid', $request->input('team_mem'))
                                ->update([
                                    'statusflag' => $request->input('finaliseflag'), // Keep it active or finalized
                                    'updatedon' => now(), // Update timestamp
                                ]);
                        }
                    }

                    // Loop through idsToRemove to find any IDs not in minortypeID
                    foreach ($idsToRemove as $subtypecodeToRemove) {
                        if (!in_array($subtypecodeToRemove, $minortypeID)) {
                            // Update the records for IDs that are not in the minor type
                            TransWorkAllocationModel::where('subtypecode', $subtypecodeToRemove)
                                ->where('auditscheduleid', $request->input('auditscheduleId'))
                                ->where('schteammemberid', $request->input('team_mem'))
                                ->update([
                                    'statusflag' => 'N', // Mark as removed
                                    'updatedon' => now(), // Update timestamp
                                ]);
                        }
                    }
                }

                // if (!empty($idsToRemove)) {
                //     foreach ($idsToRemove as $subtypecodeAdd) {
                //         TransWorkAllocationModel::whereIn('subtypecode', $idsToRemove)
                //             ->where('auditscheduleid', $auditscheduleid)
                //             ->where('schteammemberid', $request->input('team_mem'))
                //             // ->where('subtypecode', $subtypecode)
                //             ->update(['statusflag' => 'N']);

                //         // other fields as necessary

                //     }
                // }
                if (empty($newIdsExist) && empty($idsToRemove)) {
                    // print_r($minortypeID);
                    foreach ($minortypeID as $subtypecode) {
                        TransWorkAllocationModel::updatework($data, $subtypecode, $request->input('auditscheduleId'));
                    }
                    // foreach ($idsToRemove as $subtypecodeAdd) {
                    //     TransWorkAllocationModel::updatework($data, $subtypecode, $request->input('auditscheduleId'));
                    // }
                }
            }
            // }
            // $updatework = TransWorkAllocationModel::updatework($data, $subtypecode, $request->input('auditscheduleId'));
            return response()->json(['success' => true, 'message' => 'Work Allocation Data Saved Successfully']);


            // return $workallocationid;
        } else {
            foreach ($minortypeID as $subtypecode) {
                $checkforsubtype = TransWorkAllocationModel::checkforsubtype($data, $subtypecode);
                if ($checkforsubtype) {
                    return  $checkforsubtype;
                }
            }
            foreach ($minortypeID as $subtypecode) {

                TransWorkAllocationModel::create([
                    'auditscheduleid'    =>  $request->input('auditscheduleId'),
                    'schteammemberid'    => $request->input('team_mem'),
                    'statusflag'         =>  $request->input('finaliseflag'),
                    'subtypecode'        => $subtypecode,
                    'createdon'          => now(),
                    'updatedon'          => now(),
                ]);
            }


            // print_r($request->input('team_name'),);
        }
        return response()->json(['success' => true, 'message' => 'Work Allocation Data Saved Successfully']);
    }




public function fetchAllWorkData(Request $request)
{
    $TeamHead = $request['teamhead'];
    $userid=$request['userid'];
    $auditscheduleid = $request->auditscheduleid;
    $workallDetail = TransWorkAllocationModel::fetchworkdetail($auditscheduleid,$TeamHead,$userid);
    foreach ($workallDetail as $item) {
        $item->encrypted_schteammemberid = Crypt::encryptString($item->schteammemberid);
        $item->encrypted_workallocationid = Crypt::encryptString($item->workallocationid);
    }

    return response()->json(['data' => $workallDetail]);
}

public function fetch_singleworkdet(Request $request)
{
    $schteammemberid = Crypt::decryptString($request->schteammemberid);
    $auditscheduleid     = $request->auditscheduleid;
    $major_id = $request->major_id;
    $workallDetail = TransWorkAllocationModel::fetchSingleworkdetail($schteammemberid, $auditscheduleid, $major_id);
    foreach ($workallDetail as $item) {
        $item->encrypted_workallocationid = Crypt::encryptString($item->workallocationid);
    }


    if ($workallDetail) {
        return response()->json(['success' => true, 'data' => $workallDetail]);
    } else {
        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }
}
public function pendingparra()
{
    $results = DB::table('audit.inst_schteammember as scm')
        ->join('audit.inst_auditschedule as sc', 'sc.auditscheduleid', '=', 'scm.auditscheduleid')
        ->join('audit.auditplan as ap', 'ap.auditplanid', '=', 'sc.auditplanid')
        ->join('audit.mst_institution as mi', 'mi.instid', '=', 'ap.instid')
        ->where('auditeeresponse', 'A')
        ->groupBy('sc.auditscheduleid', 'ap.auditplanid', 'ap.instid', 'mi.instename','sc.fromdate',
            'sc.todate')
        ->select(
            'sc.auditscheduleid',
            'sc.fromdate',
            'sc.todate',
            'ap.auditplanid',
            'ap.instid',
            'mi.instename'
        )
    ->get();
    foreach ($results as $all) {
        $all->encrypted_auditscheduleid = Crypt::encryptString($all->auditscheduleid);
        $all->formatted_fromdate = Carbon::createFromFormat('Y-m-d', $all->fromdate)->format('d-m-Y');
        $all->formatted_todate = Carbon::createFromFormat('Y-m-d', $all->todate)->format('d-m-Y');
    }

    return view('fieldaudit.pendingpara', compact('results'));

}
public function getpendingparadetails(Request $request)
{
    $auditscheduleid = Crypt::decryptString($request->auditscheduleid);
    // Sanitize and validate input
    // $request->validate([
    //     'auditscheduleid' => 'required|integer'
    // ]);

    
    // $auditscheduleid = $request->auditscheduleid;

    // Fetch details
    $alldetails = FieldAuditModel::getpendingparadetails($auditscheduleid);

    if ($alldetails->isNotEmpty()) {
        return response()->json(['success' => true, 'data' => $alldetails]);
    } else {
        return response()->json(['success' => true, 'message' => 'No auditslips found'], 200);
    }
}

public function fetchminorworkdel(Request $request)
{

    $majorworkid = $request->majorworkid;
    $minorworkdel = DB::table('audit.mst_subworkallocationtype')

        ->where('statusflag', 'Y')
        ->where('majorworkallocationtypeid',  $majorworkid)
        ->select(
            'mst_subworkallocationtype.subworkallocationtypeename',
            'mst_subworkallocationtype.subworkallocationtypeid',
        )
        ->orderBy('mst_subworkallocationtype.orderid', 'asc')
        ->get();
    return response()->json($minorworkdel);
}


}






