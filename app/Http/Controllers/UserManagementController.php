<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

use App\Models\UserManagementModel;


use App\Models\Charge;
use App\Models\AssignCharge;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\View;

class UserManagementController extends Controller
{
    public function creatuser_dropdownvalues($viewname)
    {
        $roleaction     =   UserManagementModel::roleactiondetail('audit.mst_roleaction');
        $dept           =   UserManagementModel::deptdetail($viewname);
        $designation    =   UserManagementModel::designationdetail();

        $chargeData = session('charge');
        $session_deptcode = $chargeData->deptcode;
        $session_roletypecode = $chargeData->roletypecode;

        if($chargeData->regioncode)
        {
            $regiondetails  =   array(
                'regioncode'    =>  $chargeData->regioncode,
                'regionename'   =>  $chargeData->regionename
            );
        }
        else
        {
            $regiondetails  ='';
        }

        if($chargeData->distcode)
        {
            $distdetails  =   array(
                'distcode'    =>  $chargeData->distcode,
                'distename'   =>  $chargeData->distename
            );
        }
        else
        {
            $distdetails  ='';
        }
       

        if($session_deptcode)
        {
            $roletype       =   UserManagementModel::roletypebasedon_sessionroletype('audit.roletypemapping',$session_deptcode, $session_roletypecode,'createcharge');
        }
        else    $roletype   =   '';



        return view($viewname, compact('dept','designation','roleaction','roletype','regiondetails','distdetails'));
    }

    /******************************************** User Details - Form **************************************************/

        public function storeOrUpdate(Request $request, $userId = null)
        {
            // print_r($_POST);
            //dd($request->all());
            // Validation for user input

            // $data = $request->all();

            // // Add new fields to the data array
            // $data['created_at'] = now();  // Set the current timestamp for created_at
            // $data['updated_at'] = now();  // Set the current timestamp for updated_at

            if($request->action == 'update')
            {
                $deptuserid = Crypt::decryptString($request->userid);
                $request->merge(['userid' => $deptuserid]);
            }


            $dob = Carbon::createFromFormat('d/m/Y', $request->input('dob'))->format('Y-m-d');
            $dor = Carbon::createFromFormat('d/m/Y', $request->input('dor'))->format('Y-m-d');
            $doj = Carbon::createFromFormat('d/m/Y', $request->input('doj'))->format('Y-m-d');

            // Manually inject the formatted date back into the request so that it gets validated properly
            $request->merge(['dob' => $dob]);
            $request->merge(['dor' => $dor]);
            $request->merge(['doj' => $doj]);



            $request->validate([
                'deptcode'      => ['required', 'string', 'regex:/^\d+$/'], // Ensures only digits, allows leading zeros
                'username'      =>  'required|alpha|max:100',         // Only alphabets (no numbers or symbols)
                'ifhrmsno'      =>  'required|alpha_num|max:20',             // Alphanumeric (letters and numbers)
                'gendercode'    =>  'required|alpha|max:1',
                'dob'           =>  'required|date|date_format:Y-m-d|before_or_equal:today|before:18 years ago',     //date_format:Y-m-d //'after:today' // after:start_date'
                'email'         =>  'required|email|max:100',                    // Valid email format
                'desigid'       =>  ['required', 'string', 'regex:/^\d+$/'], // Ensures only digits, allows leading zeros
                'doj'           =>  'required|date|before_or_equal:today|after:dob|date_format:Y-m-d',
                'dor'           =>  'required|date|after_or_equal:today|after:doj|after:dob|date_format:Y-m-d',
                'auditorflag'   =>  'required|alpha|max:1',
                'mobilenumber'  =>  'required|integer'
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
                'deptcode' => $request->input('deptcode'),
                'username' => $request->input('username'),
                'ifhrmsno' => $request->input('ifhrmsno'),
                'gendercode' => $request->input('gendercode'),
                'dob' => $request->input('dob'),
                'email' => $request->input('email'),
                'desigcode' => $request->input('desigid'),
                'doj' => $request->input('doj'),
                'dor' => $request->input('dor'),
                'auditorflag' => $request->input('auditorflag'),
                'mobilenumber' => $request->input('mobilenumber'),
                'statusflag' => 'Y',
                'createdon' => now(),  // Current timestamp for created_at
                'updatedon' => now(),  // Current timestamp for updated_at
            ];

            if($request->action == 'update')
                $userId =   $request->input('userid');
            else
                $userId =   null;


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
                $user = UserModel::createIfNotExistsOrUpdate($data, $userId);

                // If no user is returned, it means a conflict occurred and an exception was thrown
                return response()->json(['success' => 'User created/updated successfully', 'user' => $user]);
            } catch (\Exception $e) {
                // Catch the exception thrown by the model and return the error message
                return response()->json(['error' => $e->getMessage()], 400);
            }

        }

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

        public function fetchAllData()
        {
            // Fetch all users
            // $users = UserModel::all(); // Or any other query to fetch users

            $users = UserModel::query() // Start the query builder
            ->join('audit.mst_dept as dept', 'deptuserdetails.deptcode', '=', 'dept.deptcode') // INNER JOIN with alias 'dept'
            ->join('audit.mst_designation as desig', 'deptuserdetails.desigcode', '=', 'desig.desigcode') // INNER JOIN with alias 'desig'
            ->select(
                'desig.desigesname',
                'desig.desigelname',
                'desig.desigtsname',
                'desig.desigtlname',
                'dept.deptesname',
                'dept.deptelname',
                'dept.depttsname',
                'dept.depttlname',
                'deptuserdetails.deptuserid',
                'deptuserdetails.deptcode',
                'deptuserdetails.username',
                'deptuserdetails.ifhrmsno',
                'deptuserdetails.gendercode',
                'deptuserdetails.dob',
                'deptuserdetails.email',
                'deptuserdetails.doj',
                'deptuserdetails.dor',
                'deptuserdetails.auditorflag',
                'deptuserdetails.mobilenumber'
            )
            ->where('deptuserdetails.statusflag', '=', 'Y') // Filter records where statusflag is 'Y'
            ->orderBy('deptuserdetails.createdon', 'desc') // Order results by createdon in descending order
            ->get(); // Execute and get the results as a collection



            foreach ($users as $user) {
                $user->encrypted_deptuserid = Crypt::encryptString($user->deptuserid);
            }



            // Return data in JSON format
            return response()->json(['data' => $users]); // Ensure the data is wrapped under "data"
        }


    /******************************************** User Details - Form **************************************************/



    /******************************************** Charge Details - Form **************************************************/


        public function charge_insertupdate(Request $request)
        {
            $chargedel = session('charge');
            if (!$chargedel || !isset($chargedel->userchargeid)) {
                return response()->json(['success' => false, 'message' => 'Charge session not found or invalid.'], 400);
            }
        
            $userchargeid = $chargedel->userchargeid;
            $chargeid = $request->input('action') === 'update' ? Crypt::decryptString($request->input('chargeid')) : null;
        
            // Validate request data
            $validatedData = $request->validate([
                'chargedescription' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:100'],
                'roletypecode'      => 'required|string|regex:/^\d+$/',
                'roleactioncode'    => 'required|string|regex:/^\d+$/',
                'desigcode'         => 'required|string|regex:/^\d+$/',
            ]);

            $deptcode   =   $request->deptcode;
            $regioncode =   $request->regioncode;
            $distcode   =   $request->distcode;
            $instmappingcode    =   $request->instmappingcode;

            

            if( in_array($chargedel->roletypecode, [View::shared('Re_roletypecode'),View::shared('Ho_roletypecode'), View::shared('Dist_roletypecode')])) 
            {
                $deptcode   =   $chargedel->deptcode;
                if(in_array($chargedel->roletypecode, [View::shared('Re_roletypecode'),View::shared('Dist_roletypecode')])) 
                    $regioncode =   $chargedel->regioncode;
                if($chargedel->roletypecode == View::shared('Dist_roletypecode'))
                    $distcode =   $chargedel->distcode;
            }


        
            // Prepare data for insertion or update
            $data = array_merge($validatedData, [
                'statusflag' => 'Y',
                'deptcode'   => $deptcode ?? null,
                'regioncode' => $regioncode ?? null,
                'distcode'   => $distcode ?? null,
                'instmappingcode' => $instmappingcode ?? null,
            ]);
        
            if ($request->input('action') === 'insert') {
                $data['createdon'] = now();
                $data['createdby'] = $userchargeid;
            }
            // print_r($data);
        
            try {
                $result = UserManagementModel::createcharge_insertupdate($data, $chargeid, 'audit.chargedetails');
                return response()->json(['success' => true, 'message' => 'Charge Created / Updated Successfully', 'data' => $result]);
            } catch (\Exception $e) {
                // Return 422 for 'record already exists' and 500 for others
                return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getMessage() === 'Record already exists with the provided conditions.' ? 422 : 500);
            }
        }
        
        public function getroletypecode_basedondept(Request $request)
        {
            $deptcode   =   $_REQUEST['deptcode'];
            $page       =   $_REQUEST['page']; 

            $request->validate([
                'deptcode'  =>  ['required', 'string', 'regex:/^\d+$/'],
            ], [
                'required' => 'The :attribute field is required.',
                'regex'     =>  'The :attribute field must be a valid number.',
            ]);

            // Fetch user data based on deptuserid
            $roletypedel = UserManagementModel::roletypebasedon_sessionroletype('audit.roletypemapping',$deptcode,'',$page); // Adjust query as needed

            if ($roletypedel) {
                return response()->json(['success' => true, 'data' => $roletypedel]);
            } else {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }
        }

        public function getRegionDistInstBasedOnDept(Request $request)
        {
            $page = $request->input('page');
            // Validate incoming request
            $validatedData = $request->validate([
                'deptcode'      => ['required', 'string', 'regex:/^\d+$/'],
                'roletypecode'  => ['required', 'string', 'regex:/^\d+$/'],
                'regioncode'    => ['nullable', 'string', 'regex:/^\d+$/'], 
                'distcode'      => ['nullable', 'string', 'regex:/^\d+$/'], 
                'valuefor'      => ['required', 'string', 'in:region,district,institution'], // Include "region"
            ], [
                'required' => 'The :attribute field is required.',
                'regex'    => 'The :attribute field must be a valid number.',
                'in'       => 'The :attribute field must be one of: region, district, institution.',
            ]);
        
            // Extract validated data
            $deptcode = $validatedData['deptcode'];
            $regioncode = $validatedData['regioncode'] ?? null;
            $distcode = $validatedData['distcode'] ?? null;
            $roletypecode = $validatedData['roletypecode'];
            $valuefor = $validatedData['valuefor'];
        
            // Additional validation for 'region'
            if ($valuefor === 'region' && !$deptcode) {
                return response()->json(['success' => false, 'message' => 'Department code is required for region.'], 422);
            }
        
            // Additional validation for 'district'
            if ($valuefor === 'district' && !$regioncode) {
                return response()->json(['success' => false, 'message' => 'Region code is required for district.'], 422);
            }
        
            // Additional validation for 'institution'
            if ($valuefor === 'institution' && in_array($roletypecode, [View::shared('Re_roletypecode'), View::shared('Dist_roletypecode')])) {
                if (!$regioncode) {
                    return response()->json(['success' => false, 'message' => 'Region code is required for institution.'], 422);
                }
                if ($roletypecode === View::shared('Dist_roletypecode') && !$distcode) {
                    return response()->json(['success' => false, 'message' => 'District code is required for this role type.'], 422);
                }
            }
        
            // Fetch data from the model
            try {
                $roletypedel = UserManagementModel::getRegionDistrictInstDelBasedOnDept(
                    'audit.auditor_instmapping',
                    $deptcode,
                    $regioncode,
                    $distcode,
                    $valuefor,
                    $roletypecode,
                    $page
                );
        
                if ($roletypedel) {
                    return response()->json(['success' => true, 'data' => $roletypedel]);
                }
        
                return response()->json(['success' => false, 'message' => 'Data not found'], 404);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function fetchchargeData(Request $request)
        {
            
            // Decrypt chargeid if provided, otherwise set to null
            $chargeid = $request->has('chargeid') ? Crypt::decryptString($request->chargeid) : null;
        
            // Fetch data using the model
            $chargedel = UserManagementModel::fetchchargeData($chargeid, 'audit.chargedetails');

              foreach ($chargedel as $all) {
                $all->encrypted_chargeid = Crypt::encryptString($all->chargeid);
            }
        
            // Return response with fetched data or error message
            return response()->json([
                'success' => !$chargedel->isEmpty(),
                'message' => $chargedel->isEmpty() ? 'User not found' : '',
                'data' => $chargedel->isEmpty() ? null : $chargedel
            ], $chargedel->isEmpty() ? 404 : 200);
        
        
        }
        
        
    /******************************************** Charge Details - Form **************************************************/


        public function getdesignation_fromchargedet(Request $request)
        {
            $request->validate([
                'deptcode'  =>  ['required', 'string', 'regex:/^\d+$/'],
                'roletypecode'  =>  ['required', 'string', 'regex:/^\d+$/'],
            ], [
                'required' => 'The :attribute field is required.',
                'regex'     =>  'The :attribute field must be a valid number.',
            ]);

            $data   =   array(
                'deptcode'  =>     $_REQUEST['deptcode'],
                'roletypecode'  =>     $_REQUEST['roletypecode'],
                'regioncode'  =>     $_REQUEST['regioncode'],
                'distcode'  =>     $_REQUEST['distcode'],
                'instmappingcode'  =>     $_REQUEST['instmappingcode']
            );


            // Fetch user data based on deptuserid
            $roletypedel = UserManagementModel::getDesignationFromChargeDetails('audit.mst_designation',$data); // Adjust query as needed

            if ($roletypedel) {
                return response()->json(['success' => true, 'data' => $roletypedel]);
            } else {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }
        }


        public function getchargedescription(Request $request)
        {
            $request->validate([
                'deptcode'  =>  ['required', 'string', 'regex:/^\d+$/'],
                'roletypecode'  =>  ['required', 'string', 'regex:/^\d+$/'],
                'desigcode'     =>  ['required', 'string', 'regex:/^\d+$/']
            ], [
                'required' => 'The :attribute field is required.',
                'regex'     =>  'The :attribute field must be a valid number.',
            ]);

            $data   =   array(
                'deptcode'  =>     $_REQUEST['deptcode'],
                'roletypecode'  =>     $_REQUEST['roletypecode'],
                'regioncode'  =>     $_REQUEST['regioncode'],
                'distcode'  =>     $_REQUEST['distcode'],
                'instmappingcode'  =>     $_REQUEST['instmappingcode'],
                'desigcode'         =>  $_REQUEST['desigcode']
            );

            $roletypedel = UserManagementModel::getchargedescription('audit.mst_charge',$data); // Adjust query as needed

            if ($roletypedel) {
                return response()->json(['success' => true, 'data' => $roletypedel]);
            } else {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }
        }


        public function getuserbasedonroletype(Request $request)
        {
            $request->validate([
                'roletypecode'  =>  ['required', 'string', 'regex:/^\d+$/'],
            ], [
                'required' => 'The :attribute field is required.',
                'regex'     =>  'The :attribute field must be a valid number.',
            ]);

            $data   =   array(
                'roletypecode'  =>     $_REQUEST['roletypecode'],
            );

            $roletypedel = UserManagementModel::getuserbasedonroletype('audit.deptuserdetails',$data); // Adjust query as needed

            if ($roletypedel) {
                return response()->json(['success' => true, 'data' => $roletypedel]);
            } else {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }
        }


}
