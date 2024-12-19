<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Import Hash facade
use DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate user input
        $request->validate([
            'username' => 'required|email',  // Assuming username is an email
            'password' => 'required|min:6',  // Minimum password length
        ]);

        $username = $request->username;

        // Fetch user from the database (replace with your actual DB query)
        $user = DB::table('audit.deptuserdetails')->where('email', $username)->first();

        // Check if user exists and password is correct
        // if ($user && Hash::check($request->password, $user->password)) {  // Compare hashed password'
        if ($user && $request->password === $user->pwd)
        {  // Compare hashed password

            $lastlogin_userdel = DB::table('audit.userlogindetails')
            ->where('userid', $user->deptuserid)
            ->orderByDesc('loginid')  // Order by ID in descending order
            ->limit(1)           // Limit to 1 record
            ->first();


            $lastlogin_time =   '';
            $deptuserid =   $user->deptuserid;

            if($lastlogin_userdel)
            {
                $lastlogin_time =   $lastlogin_userdel->logintime;
                DB::table('audit.userlogindetails')
                    ->where('userid', $user->deptuserid)// Condition to identify the record
                    ->update([
                        'activestatus' => 'N',  // Field and new value
                    ]);
            }






            $insertedId = DB::table('audit.userlogindetails')->insertGetId([
                'userid' => $user->deptuserid,
                'ipadd' => getHostByName(gethostname()),  // Get the server's IP address
                'browser' => $request->userAgent(),      // Get the user's browser information
                'machinename' => gethostname(),           // Get the server's hostname
                'logintime' => now(),                     // Current timestamp using Laravel's `now()` helper
                'activestatus' => 'Y'                    // Active status set to 'Y'
            ], 'loginid');  // Specify 'loginid' as the primary key column




            // echo $user->deptuserid;


            if($lastlogin_time)
            {
               DB::table('audit.deptuserdetails')
               ->where('deptuserid', $deptuserid)// Condition to identify the record
               ->update([
                   'lastlogin' => $lastlogin_time,  // Field and new value
               ]);
            }

            // $charge = DB::table('audit.userchargedetails as uc')
            //     ->join('audit.deptuserdetails as du', 'uc.userid', '=', 'du.deptuserid') // Adjust the columns as needed
            //     ->join('audit.chargedetails as c', 'c.chargeid', '=', 'uc.chargeid')
            //     ->join('audit.rolemapping as rm', 'rm.rolemappingid', '=', 'c.rolemappingid')
            //     ->leftJoin('audit.roletypemapping as rtm', 'rtm.roletypemappingcode', '=', 'rm.roletypemappingcode')
            //     ->leftJoin('audit.mst_dept as de', 'de.deptcode', '=', 'c.deptcode')
            //     ->leftJoin('audit.mst_district as di', 'di.distcode', '=', 'c.distcode')
            //     ->leftJoin('audit.mst_region as r', 'r.regioncode', '=', 'c.regioncode')
            //     ->leftJoin('audit.auditor_instmapping as i', 'i.instmappingcode', '=', 'c.instmappingcode')
            //     ->leftJoin('audit.auditplanteammember as at', 'at.userid', '=', 'du.deptuserid')
            //     ->join('audit.mst_designation as d', 'd.desigcode', '=', 'c.desigcode')
            //     ->where('du.deptuserid', $deptuserid)
            //     // ->where('uc.statusflag','=','Y' )
            //     ->select('uc.chargeid','uc.userid','c.chargedescription','c.deptcode','c.regioncode','rtm.usertypecode',
            //     'c.distcode','c.desigcode','d.desigelname','de.deptesname','d.desigesname','di.distsname','r.regionename',
            //     'du.username','du.email','at.auditplanteamid','rtm.roletypecode','du.lastlogin','rm.rolemappingid','uc.userchargeid') // Select all columns from both tables
            //     ->first();

            $charge = DB::table('audit.userchargedetails as uc')
            ->join('audit.deptuserdetails as du', 'uc.userid', '=', 'du.deptuserid') // Adjust the columns as needed
            ->join('audit.chargedetails as c', 'c.chargeid', '=', 'uc.chargeid')
            ->join('audit.rolemapping as rm', 'rm.rolemappingid', '=', 'c.rolemappingid')
            ->leftJoin('audit.roletypemapping as rtm', 'rtm.roletypemappingcode', '=', 'rm.roletypemappingcode')
            ->leftJoin('audit.mst_dept as de', 'de.deptcode', '=', 'c.deptcode')
            ->leftJoin('audit.mst_district as di', 'di.distcode', '=', 'c.distcode')
            ->leftJoin('audit.mst_region as r', 'r.regioncode', '=', 'c.regioncode')
            ->leftJoin('audit.auditor_instmapping as i', 'i.instmappingcode', '=', 'c.instmappingcode')
            ->leftJoin('audit.auditplanteammember as at', 'at.userid', '=', 'du.deptuserid')
            ->join('audit.mst_designation as d', 'd.desigcode', '=', 'du.desigcode')
            ->where('du.deptuserid', $deptuserid)
            // ->where('uc.statusflag','=','Y' )
            ->select('uc.chargeid','uc.userid','c.chargedescription','c.deptcode','c.regioncode','rtm.usertypecode',
            'c.distcode','c.desigcode','d.desigelname','de.deptesname','d.desigesname','di.distsname','r.regionename','di.distename','d.desigelname',
            'du.username','du.email','rtm.roletypecode','du.lastlogin','rm.rolemappingid','uc.userchargeid','at.teamhead as auditteamhead') // Select all columns from both tables
            ->first();


            $user = new \stdClass();  // Create a new instance of stdClass
            $user->userid =   $charge->userid;
            $user->username =   $charge->username;
            $user->lastlogin =   $charge->lastlogin;
            $user->email =   $charge->email;

            unset($charge->userid);
            unset($charge->username);
            unset($charge->lastlogin);
            unset($charge->email);


            $results = DB::table('audit.rolemapping')
                ->select(DB::raw("jsonb_array_elements_text(menuid->'1') as value"))  // Extract values from the JSON array at key '1'
                ->where('rolemappingid', '=', $charge->rolemappingid)  // Add your condition here
                ->get();

                if ($charge->auditteamhead != 'Y') {
                    $results = $results->reject(function ($item) {
                        return in_array($item->value, [5, 12, 16]);
                    });
                }
                // Menu
                $control_menu = $results->pluck('value')->toArray(); // Plucks out the values as an array


            $user->loginid    =   $insertedId;
            $charge->menu    =   $control_menu;



            session(['user' => $user]);
            session(['charge' => $charge]);


            // Return success response with redirect URL
            return response()->json([
                'success' => true,
                'redirect_url' => url('/dashboard'),   // Redirect to dashboard after successful login
            ]);
        }
        else
        {
            echo 'e;s';
        }

        // If credentials are invalid, return error response
        // return response()->json([
        //     'success' => false,
        //     'message' => 'Invalid credentials, please try again.',
        //     // 'redirect_url' => url('/')  // Redirect back to login page
        // ], 401);
    }


    public function logout(Request $request)
    {
        $userData = session('user');
        $loginid   =    $userData->loginid;

        DB::table('audit.userlogindetails')
            ->where('loginid', $loginid)// Condition to identify the record
            ->update([
                'activestatus' => 'N',  // Field and new value
                'logouttime'    =>  'now()'
            ]);


        // Check if the user is authenticated
        if (Auth::check()) {

            // // Log out the user
            Auth::logout();


        }

        // Clear all session data
        session()->flush();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token to prevent session fixation
        $request->session()->regenerateToken();

        // Redirect to the login page with a logout success message
        return redirect()->route('login')->with('message', 'You have been logged out successfully.');
    }



    public function auditee_validatelogin(Request $request)
    {
        // Validate user input
        $request->validate([
            'username' => 'required|email',  // Assuming username is an email
            'password' => 'required|min:6',  // Minimum password length
        ]);

        $username = $request->username;

        // Fetch user from the database (replace with your actual DB query)
        $user = DB::table('audit.audtieeuserdetails')->where('email', $username)->first();

        // Check if user exists and password is correct
        // if ($user && Hash::check($request->password, $user->password)) {  // Compare hashed password'
        if ($user && $request->password === $user->pwd)
        {  // Compare hashed password

            $lastlogin_userdel = DB::table('audit.userlogindetails')
            ->where('userid', operator: $user->auditeeuserid)
            ->where('usertypecode', operator: 'I')
            ->orderByDesc('loginid')  // Order by ID in descending order
            ->limit(1)           // Limit to 1 record
            ->first();


            $lastlogin_time =   '';
            $auditeeuserid =   $user->auditeeuserid;

            if($lastlogin_userdel)
            {
                $lastlogin_time =   $lastlogin_userdel->logintime;
                DB::table('audit.userlogindetails')
                    ->where( 'userid', $auditeeuserid)// Condition to identify the record
                    ->where('usertypecode', operator: 'I')
                    ->update([
                        'activestatus' => 'N',  // Field and new value
                    ]);
            }

            $insertedId = DB::table('audit.userlogindetails')->insertGetId([
                'userid' => $auditeeuserid,
                'ipadd' => getHostByName(gethostname()),  // Get the server's IP address
                'browser' => $request->userAgent(),      // Get the user's browser information
                'machinename' => gethostname(),           // Get the server's hostname
                'logintime' => now(),                     // Current timestamp using Laravel's `now()` helper
                'activestatus' => 'Y',
                'usertypecode' => 'I'                    // Active status set to 'Y'
            ], 'loginid');  // Specify 'loginid' as the primary key column




            // echo $user->deptuserid;


            if($lastlogin_time)
            {
                DB::table('audit.audtieeuserdetails')
                ->where('auditeeuserid', $auditeeuserid)// Condition to identify the record
                ->update([
                    'lastlogin' => $lastlogin_time,  // Field and new value
                ]);
            }


            $charge = DB::table('audit.audtieeuserdetails as au')
                ->join('audit.mst_institution as in', 'in.instid', '=', 'au.instid') // Adjust the columns as needed
                ->join('audit.chargedetails as c', 'c.chargeid', '=', 'au.chargeid')
                ->join('audit.rolemapping as rm', 'rm.rolemappingid', '=', 'c.rolemappingid')
                ->leftJoin('audit.roletypemapping as rtm', 'rtm.roletypemappingcode', '=', 'rm.roletypemappingcode')
                ->leftJoin('audit.mst_dept as de', 'de.deptcode', '=', 'in.deptcode')
                ->leftJoin('audit.mst_district as di', 'di.distcode', '=', 'in.distcode')
                ->leftJoin('audit.mst_region as r', 'r.regioncode', '=', 'in.regioncode')
                // ->join('audit.mst_designation as d', 'd.desigcode', '=', 'c.desigcode')
                ->where('au.auditeeuserid', $auditeeuserid)
                // ->where('uc.statusflag','=','Y' )
                ->select('*')
                ->select('c.chargeid','au.auditeeuserid','c.chargedescription','in.deptcode','in.regioncode',
                'in.distcode','de.deptesname','di.distsname','r.regionename','di.distename','in.instename',
                'au.username','au.email','rtm.roletypecode','au.lastlogin','rm.rolemappingid','rtm.usertypecode') // Select all columns from both tables
                ->first();

            $user = new \stdClass();  // Create a new instance of stdClass
            $user->userid =   $charge->auditeeuserid;
            $user->username =   $charge->username;
            $user->lastlogin =   $charge->lastlogin;
            $user->email =   $charge->email;

            unset($charge->userid);
            unset($charge->username);
            unset($charge->lastlogin);
            unset($charge->email);


            $results = DB::table('audit.rolemapping')
                ->select(DB::raw("jsonb_array_elements_text(menuid->'1') as value"))  // Extract values from the JSON array at key '1'
                ->where('rolemappingid', '=', $charge->rolemappingid)  // Add your condition here
                ->get();



                // Menu
                $control_menu = $results->pluck('value')->toArray(); // Plucks out the values as an array


            $user->loginid    =   $insertedId;
            $charge->menu    =   $control_menu;



            session(['user' => $user]);
            session(['charge' => $charge]);


            // Return success response with redirect URL
            return response()->json([
                'success' => true,
                'redirect_url' => url('/auditeedashboard'),   // Redirect to dashboard after successful login
            ]);
        }
        else
        {
            echo 'e;s';
        }
    }
}
