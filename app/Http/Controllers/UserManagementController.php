<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

use App\Models\UserModel;
use App\Models\DeptModel;
use App\Models\DesignationModel;

use App\Models\Charge;
use App\Models\AssignCharge;
use Illuminate\Http\Request;
use DataTables;

class UserManagementController extends Controller
{

    public function storeOrUpdate(Request $request, $userId = null)
    {
        \Log::info($request->all());
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


    public function creatuser_dropdownvalues()
    {
        $dept = DeptModel::where('statusflag', '=', 'Y')
        ->orderBy('orderid', 'asc')
        ->get();

        $designation = DesignationModel::where('statusflag', '=', 'Y')
                ->orderBy('desigelname', 'asc')
                ->get();
        return view('usermanagement.createuser', compact('dept','designation'));
    }

 




}
