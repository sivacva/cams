<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

use App\Models\UserModel;
use App\Models\DeptModel;
use App\Models\UserChargeDetailsModel;
use App\Models\AuditMemberModel;
use App\Models\DistrictModel;
use App\Models\DesignationModel;
use App\Models\AuditModel;
use App\Models\InstAuditscheduleModel;
use App\Models\InstSchteamMemberModel;
use App\Models\AuditPlanModel;
use App\Models\Charge;
use App\Models\AssignCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MajorWorkAllocationtypeModel;
use App\Models\AccountParticularsModel;

use DataTables;

class AuditSchedule extends Controller
{

    public function storeOrUpdate(Request $request, $userId = null)
    {
        // Log::info($request->all());

        //dd($request->all());
        // Validation for user input

        $data = $request->all();

        // // Add new fields to the data array
        // $data['created_at'] = now();  // Set the current timestamp for created_at
        // $data['updated_at'] = now();  // Set the current timestamp for updated_at

        if ($request->action == 'update') {
            $as_code = Crypt::decryptString($request->as_code);
            $request->merge(['as_code' => $as_code]);
        }


        $from_date = Carbon::createFromFormat('d/m/Y', $request->input('from_date'))->format('Y-m-d');
        $to_date = Carbon::createFromFormat('d/m/Y', $request->input('to_date'))->format('Y-m-d');
        $request->merge(['from_date' => $from_date]);
        $request->merge(['to_date' => $to_date]);

        // Manually inject the formatted date back into the request so that it gets validated properly
        // $request->merge(['from_date' => $from_date]);
        // $request->merge(['to_date' => $to_date]);


        $tm_uid = $request->input('tm_uid');

        $json_tm_uid = json_encode($tm_uid);

        $request->merge(['tm_uid' =>  $json_tm_uid]);

        $request->validate([
            'ap_code'       => 'required', // Ensures only digits, allows leading zeros
            'from_date'     =>  'required|date|date_format:Y-m-d|',        // Only alphabets (no numbers or symbols)
            'to_date'       =>  'required|date|date_format:Y-m-d|',             // Alphanumeric (letters and numbers)
            'rc_no'         =>  'required',
            'tm_uid'        =>  'required|json',     //date_format:Y-m-d //'after:today' // after:start_date'
            'th_uid'        =>  'required',                    // Valid email format

        ], [
            'required' => 'The :attribute field is required.',
            'alpha' => 'The :attribute field must contain only letters.',
            'integer' => 'The :attribute field must be a valid number.',
            'regex'     =>  'The :attribute field must be a valid number.',
            'alpha_num' => 'The :attribute field must contain only letters and numbers.',
            'email' => 'The :attribute field must be a valid email address.',
            'date' => 'The :attribute field must be a valid date.',
            'max' => 'The :attribute field must not exceed :max characters.',
            'before_or_equal' => 'The :attribute field must be before or equal to today.',
            'after_or_equal' => 'The :attribute field must be on or after :date.',
            'dob.before' => 'The date of birth (DOB) must be before 18 years ago.',
            'dob.after_or_equal' => 'The date of birth (DOB) must be today or in the future.',
            'doj.after:dob' => 'The date of joining must be greater than Date of birth.',
            'dor.after:doj' => 'The date of reliveing must be greater than Date of birth.',
            'dor.after:dob' => 'The date of reliveing  must be greater than date of joining.',
        ]);

        $data = [
            'auditplanid' => $request->input('ap_code'),
            'fromdate' => $request->input('from_date'),
            'todate' =>   $request->input('to_date'),
            'rcno' => $request->input('rc_no'),
            'statusflag' =>  $request->input('finaliseflag'),
            'createdon' => now(),  // Current timestamp for created_at
            'updatedon' => now(),  // Current timestamp for updated_at
        ];

        if ($request->action == 'update') {
            $audit_scheduleid =    $request->input('as_code');
        } else
            $audit_scheduleid =   null;


        // try {
        //     // Pass the current user ID (if available) for the update or create logic
        //     $user = UserModel::createIfNotExistsOrUpdate($data, $userId);

        //     if (!$user) {
        //         // If user already exists (based on conditions), return an error
        //         return response()->json(['error' => 'A user with the same email, phone, name, and address already exists.'], 400);
        //     }

        //     // Return success message
        //     return response()->json(['success' => 'User created/updated successfully', 'user' => $user]);
        // } catch (QueryException $e) {
        //     // Handle database exceptions (e.g., duplicate entry)
        //     return response()->json(['error' => 'Database error occurred: ' . $e->getMessage()], 500);
        // } catch (Exception $e) {
        //     // Handle other exceptions
        //     return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        // }
        try {


            // Call the model method for create or update
            $audit_schedule = InstAuditscheduleModel::createIfNotExistsOrUpdate($data, $audit_scheduleid);

            if ($audit_schedule) {

                if ($request->action == 'update') {
                    $membersexist = InstSchteamMemberModel::fetchteamMembers($audit_scheduleid);
                    if ($membersexist->isNotEmpty()) {
                        // Extract the array of member IDs from the existing records
                        $existingMemberIds = $membersexist
                            ->filter(function ($member) {
                                return $member->auditteamhead === 'N' && $member->statusflag === 'Y'; // Apply both conditions
                            })
                            ->pluck('userid')
                            ->toArray();


                        // Assuming $newMemberIds is the array of new members you want to compare
                        $newMemberIds = is_string($tm_uid) ? json_decode($tm_uid, true) : $tm_uid;

                        // Find the difference between the existing members and new members
                        $membersToRemove = array_diff($existingMemberIds, $newMemberIds);
                        $membersToAdd = array_diff($newMemberIds, $existingMemberIds);



                        // Optionally, you can perform actions with $membersToRemove and $membersToAdd
                        // For example, delete members to remove
                        if (!empty($membersToRemove)) {
                            foreach ($membersToRemove as $memberId) {
                                InstSchteamMemberModel::whereIn('userid', $membersToRemove)
                                    ->where('auditscheduleid', $audit_scheduleid)
                                    ->where('userid', $memberId)
                                    ->where('auditteamhead', 'N')
                                    ->update(['statusflag' => 'N']);
                            }
                        }
                        if (!empty($membersToAdd)) {

                            foreach ($membersToAdd as $memberId) {
                                InstSchteamMemberModel::create([
                                    'auditscheduleid' => $audit_scheduleid,
                                    'userid' => $memberId,
                                    'auditteamhead' => 'N',
                                    'auditfromdate' => $request->input('from_date'),
                                    'audittodate'   => $request->input('to_date'),
                                    'statusflag'   => 'Y',
                                    'createdon'          => now(),
                                    'updatedon'          => now(),
                                    // other fields as necessary
                                ]);
                            }
                        }
                        if (empty($membersToAdd) && empty($membersToRemove)) {
                            $statusflag = 'Y';
                            $audit_schedule_member = InstSchteamMemberModel::update_teamstatus($statusflag, $audit_scheduleid);
                        }
                        // Add new members (if necessary)

                    }
                    // self::updateTeammembermapping($memarr, $audit_scheduleid);
                } else {
                    $max_audit_scheduleid = InstAuditscheduleModel::query()
                        ->where(function ($query) {
                            $query->where('statusflag', '=', 'Y')
                                ->orWhere('statusflag', '=', 'F');
                        })
                        ->max('auditscheduleid');


                    $teamMemberIds = json_decode($request->input('tm_uid'), true);
                    if (!is_array($teamMemberIds)) {
                        return response()->json(['error' => 'Invalid JSON format for team members.'], 400);
                    }
                    // $request->merge(['auditscheduleid' =>  $new_auditschedule_id]);
                    // Insert each team member using the TeamMember model
                    InstSchteamMemberModel::create([
                        'auditscheduleid'    => $max_audit_scheduleid,
                        'userid'        => $request->input('th_uid'),
                        'auditteamhead' => 'Y',
                        'auditfromdate' => $request->input('from_date'),
                        'audittodate'   => $request->input('to_date'),
                        'statusflag'         =>  'Y',
                        'createdon'          => now(),
                        'updatedon'          => now(),
                    ]);
                    foreach ($teamMemberIds as $memberId) {
                        InstSchteamMemberModel::create([
                            'auditscheduleid'    => $max_audit_scheduleid,
                            'userid' => $memberId,
                            'auditteamhead' => 'N',
                            'auditfromdate' => $request->input('from_date'),
                            'audittodate'   => $request->input('to_date'),
                            'statusflag'         => 'Y',
                            'createdon'          => now(),
                            'updatedon'          => now(),
                        ]);
                        // print_r($request->input('team_name'),);
                    }
                }

                $status = $request->input('finaliseflag');
                if ($status == 'Y') {
                    return response()->json(['success' => 'Audit Schedule Data Saved Successfully', 'audit_schedule' => $audit_schedule]);
                } else {
                    return response()->json(['success' => 'Audit Schedule Data has been finalized Successfully', 'audit_schedule' => $audit_schedule]);
                }

                // Format the new team code (if needed, e.g., with leading zeros)

            }
            // If no user is returned, it means a conflict occurred and an exception was thrown
            // return response()->json(['success' => 'User created/updated successfully', 'user' => $user]);
        } catch (\Exception $e) {
            // Catch the exception thrown by the model and return the error message
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    /**
     * Fetch user data for editing.
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchUserData(Request $request)
    {
        // Retrieve deptuserid from the request

        $deptuserid = Crypt::decryptString($request->deptuserid);

        $request->merge(['deptuserid' => $deptuserid]);

        $request->validate([
            'deptuserid'  =>  'required|integer'
        ], [
            'required' => 'The :attribute field is required.',
            'integer' => 'The :attribute field must be a valid number.'
        ]);


        // Ensure deptuserid is provided
        if (!$deptuserid) {
            return response()->json(['success' => false, 'message' => 'User ID not provided'], 400);
        }

        // Fetch user data based on deptuserid
        $user = UserModel::where('deptuserid', $deptuserid)->first(); // Adjust query as needed

        if ($user) {
            return response()->json(['success' => true, 'data' => $user]);
        } else {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
    }
    public function fetchschedule_data(Request $request)
    {
        $auditscheduleid = Crypt::decryptString($request->auditscheduleid);
        $inst = InstAuditscheduleModel::query()
            ->join('audit.auditplan as ap', 'inst_auditschedule.auditplanid', '=', 'ap.auditplanid')
            ->join('audit.mst_institution as mi', 'mi.instid', '=', 'ap.instid')
            ->join('audit.inst_schteammember as at', function ($join) {
                $join->on('at.auditscheduleid', '=', 'inst_auditschedule.auditscheduleid')
                    ->where('at.auditteamhead', '=', 'Y');
            })
            ->join('audit.userchargedetails as uc', 'uc.userchargeid', '=', 'at.userid')
            ->join('audit.deptuserdetails as du', 'at.userid', '=', 'du.deptuserid')
            ->join('audit.mst_designation as de', 'de.desigcode', '=', 'du.desigcode')
            ->join('audit.chargedetails as cd', 'uc.chargeid', '=', 'cd.chargeid')
            ->leftJoin('audit.inst_schteammember as sub_atm', function ($join) {
                $join->on('sub_atm.auditscheduleid', '=', 'inst_auditschedule.auditscheduleid')
                    ->where('sub_atm.auditteamhead', '=', 'N');
            })
            ->leftJoin('audit.deptuserdetails as sub_du', 'sub_atm.userid', '=', 'sub_du.deptuserid')
            ->select(
                'inst_auditschedule.auditscheduleid',
                'inst_auditschedule.fromdate',
                'inst_auditschedule.todate',
                'inst_auditschedule.rcno',
                'mi.instename',
                'mi.instid',
                'mi.mandays',
                'at.auditscheduleid',
                'at.userid as team_head_userid',
                'du.username as team_head_name',
                'cd.chargedescription',
                'teammembers.userid as team_member_userid',
                'teammembers.username as team_member_name',
                'cd.chargedescription',
                'de.desigelname',
                DB::raw('(
                SELECT COUNT(*)
                FROM audit.auditplanteammember as sub_atm
                WHERE sub_atm.auditplanteamid = ap.auditteamid

            ) as total_team_count')
            )
            ->leftJoin(
                DB::raw('(SELECT sub_atm.auditscheduleid, sub_atm.userid, sub_du.username
                            FROM audit.inst_schteammember as sub_atm
                            JOIN audit.deptuserdetails as sub_du
                                ON sub_atm.userid = sub_du.deptuserid
                            WHERE sub_atm.auditteamhead =\'N\'
                             AND (sub_atm.statusflag =  \'Y\' )) as teammembers'),
                'teammembers.auditscheduleid',
                '=',
                'inst_auditschedule.auditscheduleid'
            )
            ->where(function ($query) {
                $query->where('inst_auditschedule.statusflag', '=', 'Y');
                // ->orWhere('inst_auditschedule.statusflag', '=', 'N');
            })
            ->where('inst_auditschedule.auditscheduleid', '=', $auditscheduleid)
            ->get();

        foreach ($inst as $item) {
            $item->encrypted_auditscheduleid = Crypt::encryptString($item->auditscheduleid);
        }


        if ($inst) {
            return response()->json(['success' => true, 'data' => $inst]);
        } else {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
    }
    public function fetchAllScheduleData(Request $request)
    {

        $inst = InstAuditscheduleModel::query()
            ->join('audit.auditplan as ap', 'inst_auditschedule.auditplanid', '=', 'ap.auditplanid')
            ->join('audit.mst_institution as mi', 'mi.instid', '=', 'ap.instid')
            // ->join('audit.inst_schteammember as at', 'at.auditscheduleid', '=', 'inst_auditschedule.auditscheduleid')
            ->join('audit.inst_schteammember as at', function ($join) {
                $join->on('at.auditscheduleid', '=', 'inst_auditschedule.auditscheduleid')
                    ->where('at.statusflag', '=', 'Y');
            })
            ->join('audit.userchargedetails as uc', 'uc.userchargeid', '=', 'at.userid')
            ->join('audit.deptuserdetails as du', 'at.userid', '=', 'du.deptuserid')
            ->join('audit.chargedetails as cd', 'uc.chargeid', '=', 'cd.chargeid')
            ->join('audit.mst_designation as de', 'de.desigcode', '=', 'du.desigcode')
            ->select(
                'inst_auditschedule.auditscheduleid',
                'inst_auditschedule.fromdate',
                'inst_auditschedule.todate',
                'inst_auditschedule.rcno',
                'inst_auditschedule.statusflag',
                'mi.instename',
                'mi.mandays',
                // 'cd.chargedescription',
                // 'de.desigelname',
                DB::raw('STRING_AGG(du.username, \', \') as teammembers'), // Group usernames into one field
                DB::raw('(
                    SELECT COUNT(*)
                    FROM audit.inst_schteammember as sub_atm
                    WHERE sub_atm.auditscheduleid = inst_auditschedule.auditscheduleid
                    AND (sub_atm.statusflag =  \'Y\' )
                ) AS team_member_count')
            )
            ->where(function ($query) {
                $query->where('inst_auditschedule.statusflag', '=', 'Y')
                    ->orWhere('inst_auditschedule.statusflag', '=', 'F');
            })
            ->where('at.statusflag', '=', 'Y')
            ->groupBy(
                'inst_auditschedule.auditscheduleid',
                'inst_auditschedule.fromdate',
                'inst_auditschedule.todate',
                'inst_auditschedule.rcno',
                'inst_auditschedule.statusflag',
                'mi.instename',
                'mi.mandays',
                // 'cd.chargedescription',
                // 'de.desigelname'
            )
            ->get();


        foreach ($inst as $item) {
            $item->encrypted_auditscheduleid = Crypt::encryptString($item->auditscheduleid);
        }




        // Return data in JSON format
        return response()->json(['data' => $inst]); // Ensure the data is wrapped under "data"

    }


    public function audit_particulars()
    {
        $audit_particulars = MajorWorkAllocationtypeModel::audit_particulars();
        $account_particulars = AccountParticularsModel::where('statusflag', '=', 'Y')
            ->orderBy('accountparticularsename', 'asc')
            ->get();
        if ($audit_particulars) {
            return response()->json([
                'data' => $audit_particulars,
                'account_particulars' => $account_particulars
            ]);
        }
    }

    public function creatauditschedule_dropdownvalues(Request $request)
    {
        // $auditplanid = $request->query('auditplanid'); // Default to '1' if no value is provided.
        if ($request->auditplanid) {
            $auditplanid = Crypt::decryptString($request->auditplanid);
            $userid = $request->userid;
        } else {
            // print_r($auditplanid);
            $session = $request->session();
            if ($session->has('user')) {
                $user = $session->get('user');
                $userid = $user->userid ?? null;

            } else {
                return "No user found in session.";
            }
        }

        // Fetch the data based on the provided auditplanid
        $inst = AuditModel::query()
            ->join('audit.mst_institution as ai', 'ai.instid', '=', 'auditplan.instid')
            ->join('audit.auditplanteam as at', 'at.auditplanteamid', '=', 'auditplan.auditteamid')
            ->join('audit.auditplanteammember as atm', 'atm.auditplanteamid', '=', 'auditplan.auditteamid')
            ->join('audit.userchargedetails as uc', 'uc.userchargeid', '=', 'atm.userid')
            ->join('audit.deptuserdetails as du', 'atm.userid', '=', 'du.deptuserid')
            ->join('audit.chargedetails as cd', 'uc.chargeid', '=', 'cd.chargeid')
            ->join('audit.mst_designation as de','de.desigcode', '=', 'du.desigcode')
            ->select(
                'ai.instename',
                'ai.mandays',
                'ai.instid',
                'de.desigelname',
                'auditplan.auditteamid',
                'auditplan.auditplanid',
                'at.auditplanteamid',
                'atm.userid',
                'uc.userchargeid',
                'du.username',
                'cd.chargedescription',
                DB::raw('(
                    SELECT COUNT(*)
                    FROM audit.auditplanteammember AS sub_atm
                    WHERE sub_atm.auditplanteamid = auditplan.auditteamid
                ) AS team_member_count')
            )
            ->where('auditplan.auditplanid', '=', $auditplanid) // Use the decrypted or plain auditplanid
            ->where('atm.userid', '=', $userid)
            ->where('auditplan.statusflag', '=', 'F')
            ->get();

        $Accountparticulars = self::audit_particulars();


        // print_r($inst);
        // Redirect to the view and pass the data using compact
        return view('audit.auditdatefixing', compact('inst','Accountparticulars'));
    }

    public function audit_members(Request $request)
    {
        $planid = $request->input('planid');

        $inst = AuditModel::query()
        ->join('audit.auditplanteam as at', 'at.auditplanteamid', '=', 'auditplan.auditteamid')
        ->join('audit.auditplanteammember as atm', 'atm.auditplanteamid', '=', 'auditplan.auditteamid')
        ->join('audit.userchargedetails as uc', function ($join) {
            $join->on('uc.userchargeid', '=', 'atm.userid')
                ->where('atm.teamhead', '=', 'N'); // Filter for team members
        })
        ->join('audit.deptuserdetails as du', 'uc.userid', '=', 'du.deptuserid')
        ->join('audit.chargedetails as cd', 'uc.chargeid', '=', 'cd.chargeid')
        ->join('audit.mst_designation as de','de.desigcode', '=', 'du.desigcode')
        ->where('auditplan.statusflag', '=', 'F')
        ->where('auditplan.auditplanid', '=', $planid)
        ->where('auditplan.auditteamid', function ($query) {
            $query->select('auditteamid')
                ->from('audit.auditplan')
                ->whereColumn('auditteamid', 'auditplan.auditteamid')
                ->where('statusflag', 'F')
                ->limit(1); // Ensure only one value is returned
        })
        ->select(
            'auditplan.auditteamid',
            'uc.userchargeid',
            'auditplan.auditplanid',
            'cd.chargedescription',
            'de.desigelname',
            'du.username',
            'du.deptuserid',
            'atm.teamhead',
            'atm.userid'
        )
        ->get();
    return response()->json($inst);

    }




    public function auditee_intimation(Request $request)
    {
        $session = $request->session();
        if ($session->has('user')) {
            $user = $session->get('user');
            $userid = $user->userid ?? null;
        } else {
            return "No user found in session.";
        }

        $audit_plandetail = InstAuditscheduleModel::fetch_auditplandetails($userid);
        foreach ($audit_plandetail as $item) {
            $item->encrypted_auditplanid = Crypt::encryptString($item->auditplanid);
            $nodalname = $item->nodalname;
            $nodaldesig=$item->nodaldesignation;
            $item->nodalperson_details =$nodalname.'<br>'.$nodaldesig;

            $nodalemail = $item->nodalemail;
            $nodalmobile=$item->nodalmobile;
            $item->nodalperson_contact =$nodalmobile.'<br>'.$nodalemail;
        }

        return response()->json(['data' => $audit_plandetail]); // Ensure the data is wrapped under "data"

        // print_r($audit_plandetail);
    }
}
