<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use App\Models\AuditModel;
use App\Models\DeptModel;
use App\Models\RegionModel;
use App\Models\DistrictModel;
use App\Models\AuditTeamModel;
use App\Models\DeptMapModel;
use App\Models\InstituteCategoryModel;
use App\Models\TypeofAuditModel;
use App\Models\AuditQuarterModel;
use App\Models\AuditPeriodModel;
use App\Models\AuditSubcategoryModel;
use App\Models\YearcodeMapping;


use Illuminate\Http\Request;
use DataTables;

class AuditManagementController extends Controller
{

    public function storeOrUpdateAudit(Request $request,$userId = null)
    {
        \Log::info($request->all());

        // Check if the statusflag is 'delete'
        $isDelete = $request->has('statusflag') && $request->statusflag === 'Y';
        $yeararr=[];

        // Conditional validation: Only validate required fields if not deleting
        if ($isDelete == 1)
        {
            $request->validate([
                'statusflag' => 'required|string',
                'auditplanid' => 'nullable|int',
            ]);

        }else{

            $request->validate([
                'deptcode' => 'required|string|max:2',
                'regioncode' => 'required|string|max:2',
                'distcode' => 'required|string|max:3',
                'instcatcode' => 'required|string|max:2',
                'instcode' => 'required|string|max:4',
                'auditteamcode' => 'required|string|max:2',
                'yearcode' => 'required|string|max:2',
                'auditcode' => 'required|string|max:2',
                'periodcode' => 'required|string|max:2',
                'statusflag' => 'nullable|string|max:2',
            ]);

            $isFinalize = $request->has('finalize') && $request->finalize === 'F';

            if($isFinalize)
            {

                $FinalizedStsFlag=$request->finalize;
            }else
            {
                $FinalizedStsFlag='Y';
            }
            /**YearMultiple Array */
            $yeararr=$request->input('yearselected');

            $auditplanData = ['instid' => $request->instcode,
                              'auditteamid' => $request->auditteamcode,
                              'typeofauditcode' => $request->auditcode,
                              'auditperiodid' => $request->yearcode,  // Insert the generated yearcodemapping_id here
                              'auditquartercode' => $request->periodcode,
                              'statusflag' => $FinalizedStsFlag
                            ];


            if((isset($_POST['auditplanid']) && $_POST['auditplanid'] != '') || $isFinalize == 'F')
                $userId =   $request->input('auditplanid');
            else
                $userId =   null;



        }


        try {
            if ($request->has('statusflag') && $request->statusflag === 'Y')
            {
                $auditplanid = Crypt::decryptString($request->auditencryptedplanid);
                $request->merge(['auditplanid' => $auditplanid]);
                $auditId=$request->auditplanid;
                $Audit = AuditModel::find($auditId);
                $auditplanData['statusflag']=$request->statusflag;

                if ($Audit) {
                    // If the user exists, delete the record
                    $Audit = AuditModel::createIfNotExistsOrUpdate($auditplanData,$auditId,$yeararr,'Delete');
                    return response()->json(['success' => 'Details deleted successfully.']);
                } else {
                    // If no such record exists to delete
                    return response()->json(['error' => 'Details not found.'], 404);
                }

            }else
            {
                // Pass the current user ID (if available) for the update or create logic
                $user = AuditModel::createIfNotExistsOrUpdate($auditplanData, $userId,$yeararr);
                if (!$user) {
                    // If user already exists (based on conditions), return an error
                    return response()->json(['error' => 'Details already exists'], 400);
                }

                // Return success message
                return response()->json(['success' => 'Audit Plan Data Saved successfully', 'user' => $user]);


            }
        } catch (QueryException $e) {
            // Handle database exceptions (e.g., duplicate entry)
            return response()->json(['error' => 'Database error occurred: ' . $e->getMessage()], 500);
        } catch (Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Fetch user data for editing.
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchUserDataAudit(Request $request)
    {
        // Retrieve deptuserid from the request
        $auditplanid = Crypt::decryptString($request->auditplanid);
        $request->merge(['auditplanid' => $auditplanid]);

        $request->validate([
            'auditplanid'  =>  'required|integer'
        ], [
            'required' => 'The :attribute field is required.',
            'integer' => 'The :attribute field must be a valid number.'
        ]);

         // Ensure deptuserid is provided
        if (!$auditplanid) {
            return response()->json(['success' => false, 'message' => 'Audit ID not provided'], 400);
        }

        // Fetch user data based on deptuserid
        $auditplanNew = AuditModel::where('auditplanid', $auditplanid)->first(); // Adjust query as needed

         //Get Institute Name
        /*$GetInstitute = DeptMapModel::where('statusflag', '=', 'Y')
                                     ->where('instid', $auditplan->instid)
                                     ->first();*/

        $auditplan = AuditModel::query()
                                ->join('audit.mst_institution as inst', 'auditplan.instid', '=', 'inst.instid')
                                ->where('inst.statusflag', '=', 'Y')
                                ->where('inst.instid', '=', $auditplanNew->instid)
                                ->where('auditplan.auditplanid', '=', $auditplanid)
                                ->first();
        $auditplan->typeofauditcode=$auditplanNew->typeofauditcode;
        $Yearmapping = YearcodeMapping::fetchYearmapById($auditplanid);
        foreach($Yearmapping as $yeararr => $yearval)
        {
           $yearsGet[$yeararr]= $yearval->yearselected;
        }
        $auditplan['yearcode']=$yearsGet;
        //$auditplan['yearcode']='2024 -2025';
        if ($auditplan) {
            return response()->json(['success' => true, 'data' => $auditplan]);
        } else {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }
    }


    public function auditfetchAllData()
    {
        // Fetch all users
        $audits = AuditModel::fetchAllusers();

        $Slno=1;
        foreach ($audits as $audit)
        {

            //Get Institute Name
            $GetInstitute = DeptMapModel::where('statusflag', '=', 'Y')
                                        ->where('instid', $audit->instid)
                                        ->first();
            //Get DepartmentName
            $dept   = DeptModel::where('statusflag', '=', 'Y')
                                ->where('deptcode', $GetInstitute->deptcode)
                                ->orderBy('orderid', 'asc')
                                ->first();

            //Get RegionName
            $region   = RegionModel::where('statusflag', '=', 'Y')
                                    ->where('regioncode', $GetInstitute->regioncode)
                                    ->first();
            $Arr['RegionName']=$region->regionename;


            //Get DistrictName
            $Dist   = DistrictModel::where('statusflag', '=', 'Y')
                                    ->where('distcode', $GetInstitute->distcode)
                                    ->first();
            $Arr['DistName']=$Dist->distename;


            //Get Institute Category Name
            $InstCategory = InstituteCategoryModel::where('statusflag', '=', 'Y')
                                                  //->where('deptcode', $audit->deptcode)
                                                  ->where('catcode', $GetInstitute->catcode)
                                                  ->first();


            //Get AuditTeam
            $auditteammodalget = AuditTeamModel::where('statusflag', '=', 'F')
                                               ->where('auditplanteamid', $audit->auditteamid)
                                               ->first();


            $TypeofAudit11 = TypeofAuditModel::where('statusflag', '=', 'Y')
                                             ->where('typeofauditcode', $audit->typeofauditcode)
                                             ->first();

            $AuditQuarter = AuditQuarterModel::where('statusflag', '=', 'Y')
                                             ->where('deptcode', $GetInstitute->deptcode)
                                             ->where('auditquartercode', $audit->auditquartercode)
                                             ->first();

            $ImplodeReg_Dist=implode('<br>',$Arr);

            $audit->Reg_Dist = $ImplodeReg_Dist;
            $audit->deptname = $dept->deptesname;
            $audit->instcatname=$InstCategory->catename;
            $audit->instname=$GetInstitute->instename;
            $audit->auditteamname=$auditteammodalget->teamname;
            $audit->typeofaudit=$TypeofAudit11->typeofauditename;



            $audit->encrypted_auditid = Crypt::encryptString($audit->auditplanid);

            /*$AuditPeriod=AuditPeriodModel::where('statusflag', '=', 'Y')
                                         ->first();

            $auditfromperiod=$AuditPeriod->fromyear;
            $audittoperiod=$AuditPeriod->toyear;

            $audit->auditperiod = $auditfromperiod.' - '.$audittoperiod;*/

            $Yearmapping = YearcodeMapping::fetchYearmapById($audit->auditplanid);
            $YearMasterArr=[1=>'2023-2024', 2=>'2022-2023', 3=>'2021-2022'];
            foreach($Yearmapping as $yeararr => $yearval)
            {
               $yearsGet[$yeararr]= $YearMasterArr[$yearval->yearselected];
            }
            $implodeArrYrs=implode('<br>',$yearsGet);
            $audit->auditperiod = $implodeArrYrs;

            $audit->auditquarter = $AuditQuarter->auditquarter;

            $audit->Slno = $Slno;
            $Slno++;
        }
        // Return data in JSON format
        return response()->json(['data' => $audits]); // Ensure the data is wrapped under "data"
    }


    public function FilterByDept(Request $request)
    {

        $DeptMapping = DeptMapModel::where('statusflag', '=', 'Y')
                                   ->where('deptcode', $request->deptcode);

        if ($request->regioncode)
        {
            $DeptMapping->where('regioncode', $request->regioncode);
        }

        if ($request->distcode)
        {
            $DeptMapping->where('distcode', $request->distcode);
        }

        if ($request->instcatcode)
        {
            $DeptMapping->where('catcode', $request->instcatcode);
        }

        if ($request->instsubcatcode)
        {
            $DeptMapping->where('subcatid', $request->instsubcatcode);
        }

        $DeptMapping = $DeptMapping->get();


        $regioncode=[];
        $districtCode=[];
        $InstcatCode=[];
        //print_r($DeptMapping);
        foreach($DeptMapping as $Deptkey => $DeptVal)
        {
            $regioncode[] = $DeptVal->regioncode;
            $districtCode[] = $DeptVal->distcode;
            $InstcatCode[] = $DeptVal->catcode;

        }
        if(sizeof($regioncode)>0)
        {
            $regioncode=array_unique($regioncode);
        }


        if ($request->regioncode)
        {
           $districtCode=array_unique($districtCode);

        }

        if ($request->distcode)
        {
           $InstcatCode=array_unique($InstcatCode);

           $auditteammodalget = AuditTeamModel::where('statusflag', '=', 'F')
                                              ->where('deptcode', $request->deptcode)
                                              ->whereIn('distcode',[$request->distcode,'A'])
                                              ->get();
        }

        $RegionFinal   ='';
        $DistrictFinal ='';
        $InstCategoryFinal='';
        $InstNameFinal='';
        $TypeofAuditFinal='';
        $AuditQuarterFinal='';
        $AuditPeriodFinal='';


        if($DeptMapping)
        {
            if($request->instsubcatcode)
            {
                $InstNameFinal=self::ArrayCombineFunction($DeptMapping,'instid','instename');
                return $InstNameFinal;

            }

            if($request->instcatcode)
            {
                $DeptMappingfetch = DeptMapModel::where('statusflag', '=', 'Y')
                                           ->where('deptcode', $request->deptcode)
                                           ->where('catcode', $request->instcatcode)
                                           ->first();


                if($DeptMappingfetch->subcatid!='')
                {
                    $AuditSubcategoryModel = AuditSubcategoryModel::where('statusflag', '=', 'Y')
                                                                  ->where('catcode', $request->instcatcode)
                                                                  ->where('auditeeins_subcategoryid', $DeptMappingfetch->subcatid)
                                                                  ->get();
                    $DynField='subcategory';
                    $InstSubCategoryFinal=self::ArrayCombineFunction($AuditSubcategoryModel,'auditeeins_subcategoryid','subcatename');
                    $response=$DynField.'~~'.$InstSubCategoryFinal;
                    return $response;
                }else
                {
                    $InstNameFinal=self::ArrayCombineFunction($DeptMapping,'instid','instename');

                    $DynField='institutename';
                    $response=$DynField.'~~'.$InstNameFinal;
                    return $response;
                }

            }

            if($request->distcode)
            {
                $InstCategory = InstituteCategoryModel::where('statusflag', '=', 'Y')
                                                      ->whereIn('catcode', $InstcatCode)
                                                      ->get();

                $InstCategoryFinal=self::ArrayCombineFunction($InstCategory,'catcode','catename');
                $AuditTeam=self::ArrayCombineFunction($auditteammodalget,'auditplanteamid','teamname');

                return $InstCategoryFinal.'~'.$AuditTeam;

            }

            if($request->regioncode)
            {
                $district = DistrictModel::where('statusflag', '=', 'Y')
                                         ->whereIn('distcode', $districtCode)
                                         ->get();
                $DistrictFinal=self::ArrayCombineFunction($district,'distcode','distename');
                return $DistrictFinal;

            }

            $region = RegionModel::where('statusflag', '=', 'Y')
                                  ->whereIn('regioncode', $regioncode)
                                  ->get();
            $RegionFinal=self::ArrayCombineFunction($region,'regioncode','regionename');

            $AuditQuarter = AuditQuarterModel::where('statusflag', '=', 'Y')
                                             ->where('deptcode', $request->deptcode)
                                             ->get();

            $AuditPeriod=AuditPeriodModel::where('statusflag', '=', 'Y')
                                         ->first();

            $TypeofAudit = TypeofAuditModel::where('statusflag', '=', 'Y')
                                         ->where('deptcode', $request->deptcode)
                                         ->get();

            $auditteammodalget = AuditTeamModel::where('statusflag', '=', 'F')
                                              ->where('deptcode', $request->deptcode)
                                              ->get();


            $auditfromperiod=$AuditPeriod->fromyear;
            $audittoperiod=$AuditPeriod->toyear;

            $AuditPeriodFinal=$auditfromperiod.' - '.$audittoperiod;
            $AuditQuarterFinal=self::ArrayCombineFunction($AuditQuarter,'auditquartercode','auditquarter');
            $TypeofAuditFinal=self::ArrayCombineFunction($TypeofAudit,'typeofauditcode','typeofauditename');


            return $RegionFinal.'~'.$AuditPeriodFinal.'~'.$AuditQuarterFinal.'~'.$TypeofAuditFinal;


        }



    }

    public function ArrayCombineFunction($ARR,$aaa,$bbb)
    {

        $Final =[];
        $Id =[];
        $Name=[];

        if($ARR)
        {
            foreach($ARR as $ArrVal)
            {
                $Id[]   = $ArrVal->$aaa;
                $Name[] = $ArrVal->$bbb;
            }

            if(sizeof($Id)> 0 && sizeof($Name)> 0)
            {
                $Final=array_combine($Id,$Name);

            }

        }

        return json_encode($Final);

    }

    public function creatuser_dropdownvalues($view)
    {
        $dept = DeptModel::where('statusflag', '=', 'Y')
        ->orderBy('orderid', 'asc')
        ->get();

        $district = DistrictModel::where('statusflag', '=', 'Y')
                                 ->get();

        $region = RegionModel::where('statusflag', '=', 'Y')
                             ->get();


        return view($view, compact('dept','district','region'));  // Using 'district' to pass it to the view
    }

    public function audit_plandetails(Request $request)
    {
        $session = $request->session();
        if ($session->has('user')) {
            $user = $session->get('user');
            $userid = $user->userid ?? null;
        } else {
            return "No user found in session.";
        }
        $audit_plandetail = AuditModel::fetch_auditplandetails($userid);
        foreach ($audit_plandetail as $item) {
            $item->encrypted_auditplanid = Crypt::encryptString($item->auditplanid);
        }
        return response()->json(['data' => $audit_plandetail]); // Ensure the data is wrapped under "data"
        // print_r($audit_plandetail);
    }


}
