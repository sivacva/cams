<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuditDiaryHistoryModel extends Model
{
    protected $connection = 'pgsql'; // Default is 'mysql', use 'pgsql' for PostgreSQL

    const CREATED_AT = 'createdon'; // Custom column name for `created_at`
    const UPDATED_AT = 'updatedon'; // Custom column name for `updated_at` (if you have it)

    // Specify that the primary key is `userid` instead of `id`
    protected $primaryKey = 'audithistoryid';

    // Specify the table name
    protected $table = 'audit.auditdiary_history';

    // Set the primary key type if it's not an auto-incrementing integer
    protected $keyType = 'int';  // If `userid` is an integer

    // If your primary key is not auto-incrementing, set `incrementing` to false
    public $incrementing = true; // Set to `false` if `userid` is not auto-incrementing

    // Define the fillable fields
    protected $fillable = [
        'diaryid','workallocationid',  'percentofcompletion', 'fromdate',  'remarks','statusflag'
    ];
}

class AuditDiaryModel extends Model
{
    protected $connection = 'pgsql'; // Default is 'mysql', use 'pgsql' for PostgreSQL

    const CREATED_AT = 'createdon'; // Custom column name for `created_at`
    const UPDATED_AT = 'updatedon'; // Custom column name for `updated_at` (if you have it)

    // Specify that the primary key is `userid` instead of `id`
    protected $primaryKey = 'diaryid';

    // Specify the table name
    protected $table = 'audit.auditdiary';

    // Set the primary key type if it's not an auto-incrementing integer
    protected $keyType = 'int';  // If `userid` is an integer

    // If your primary key is not auto-incrementing, set `incrementing` to false
    public $incrementing = true; // Set to `false` if `userid` is not auto-incrementing

    // Define the fillable fields
    protected $fillable = [
      'workallocationid',  'percentofcompletion', 'fromdate','remarks','statusflag'
    ];

    public static function createIfNotExistsOrUpdate(array $data,$auditdiaryid='')
    {

        $data['statusflag'] = $data['statusflag'];

        if($data['fromdate'])
        {
            $data['fromdate'] = date('Y-m-d',strtotime($data['fromdate']));
        }



        try
        {
            if ($auditdiaryid)
            {
                // Fetch the record from the main table (AuditDiary)
                $UpdateDiary = self::find($auditdiaryid);
                if ($UpdateDiary)
                {
                    $hasChanges = false;

                    foreach ($data as $key => $value)
                    {
                        // Compare original value with new value
                        if ($UpdateDiary->$key != $value)
                        {
                            $hasChanges =true;
                            break; // Exit loop once we detect a change
                        }
                    }

                    if ($hasChanges)
                    {
                        $UpdateDiary['diaryid']=$auditdiaryid;
                        $CreateAuditDiaryid = AuditDiaryHistoryModel::create($UpdateDiary->toArray());

                    }

                    $UpdateDiary->update($data); // $data should contain the new values to update

                    return $UpdateDiary;

                } else {
                    // Handle the case when the original record is not found
                    return null; // Or handle accordingly (e.g., throw an exception, return a message)
                }


            } else
            {
                $CreateAuditDiaryid=self::create($data);
                $GetAuditDiaryId=$CreateAuditDiaryid->diaryid;
                return $GetAuditDiaryId;
            }
        } catch (QueryException $e) {
            // Handle any database-specific exceptions (e.g., duplicate entry)
            Log::error("Database error: " . $e->getMessage());
            throw new Exception("Database error occurred. Please try again later.");
        } catch (Exception $e) {
            // Handle any other general exceptions
            Log::error("General error: " . $e->getMessage());
            throw new Exception("Something went wrong: " . $e->getMessage());
        }
    }


    public static function Fetch_Cat_subCat()
    {
        // Manually perform the update using the Query Builder
        $connection = 'pgsql'; // Name of the database connection
        $table = 'audit.trans_workallocation'; // Full table name (including schema)

        $userdetails=self::userdetails_fetch();
        if($userdetails)
        {
            $auditscheduleid = $userdetails->auditscheduleid;
            $schteammemberid = $userdetails->schteammemberid;

            $AllData =  DB::connection($connection)
                            ->table($table)
                            ->join('audit.mst_subworkallocationtype as b', 'audit.trans_workallocation.subtypecode', '=', 'b.subworkallocationtypeid')
                            ->join('audit.mst_majorworkallocationtype as c', 'b.majorworkallocationtypeid', '=', 'c.majorworkallocationtypeid')
                            ->where('audit.trans_workallocation.statusflag', '=', 'F')
                            ->where('b.statusflag', '=', 'Y')
                            ->where('c.statusflag', '=', 'Y')
                            ->where('audit.trans_workallocation.auditscheduleid', '=', $auditscheduleid)
                            ->where('audit.trans_workallocation.schteammemberid', '=', $schteammemberid)
                            ->orderBy('b.subworkallocationtypeename', 'asc')
                            ->select('audit.trans_workallocation.workallocationid',
                                    'c.majorworkallocationtypeename',
                                    'c.majorworkallocationtypeid',
                                    'b.subworkallocationtypeid',
                                    'b.subworkallocationtypeename')
                            ->get();
        // Log the result for debugging (better than using print_r)
        \Log::info('Fetched Audit Records:', $AllData->toArray()); // Logs as array for better readability

        return $AllData;

        }


    }

    public static function DiaryFetchData()
    {
        // Manually perform the update using the Query Builder
        $connection = 'pgsql'; // Name of the database connection
        $table = 'audit.trans_workallocation'; // Full table name (including schema)

        $userdetails=self::userdetails_fetch();
        if($userdetails)
        {
            $auditscheduleid = $userdetails->auditscheduleid;
            $schteammemberid = $userdetails->schteammemberid;

            $AuditDiaryDataFetch = DB::connection($connection)
                                        ->table($table)
                                        ->join('audit.auditdiary as audiary', 'audit.trans_workallocation.workallocationid', '=', 'audiary.workallocationid')
                                        ->where('audit.trans_workallocation.statusflag', '=', 'F')
                                        ->where('audiary.statusflag', '=', 'Y')
                                        ->where('audit.trans_workallocation.auditscheduleid', '=', $auditscheduleid)
                                        ->where('audit.trans_workallocation.schteammemberid', '=', $schteammemberid)
                                        ->first();


            if($AuditDiaryDataFetch)
            {
                $AuditDiaryDataFetch = DB::connection($connection)
                                        ->table($table)
                                        ->join('audit.mst_subworkallocationtype as b', 'audit.trans_workallocation.subtypecode', '=', 'b.subworkallocationtypeid')
                                        ->join('audit.mst_majorworkallocationtype as c', 'b.majorworkallocationtypeid', '=', 'c.majorworkallocationtypeid')
                                        ->join('audit.auditdiary as audiary', 'audit.trans_workallocation.workallocationid', '=', 'audiary.workallocationid')
                                        ->where('audit.trans_workallocation.statusflag', '=', 'F')
                                        ->where('audiary.statusflag', '=', 'Y')
                                        ->where('b.statusflag', '=', 'Y')
                                        ->where('c.statusflag', '=', 'Y')
                                        ->where('audit.trans_workallocation.auditscheduleid', '=', $auditscheduleid)
                                        ->where('audit.trans_workallocation.schteammemberid', '=', $schteammemberid)
                                        ->get();

                \Log::info('Fetched Audit Records:', $AuditDiaryDataFetch->toArray()); // Logs as array for better readability

            }else
            {
                $AuditDiaryDataFetch='nodata';
            }
            // Log the result for debugging (better than using print_r)

            return $AuditDiaryDataFetch;

        }

    }

    public static function fetchAllusers()
    {
        $connection = 'pgsql'; // Name of the database connection
        $table = 'audit.trans_workallocation'; // Full table name (including schema)

        $userdetails=self::userdetails_fetch();
        if($userdetails)
        {
            $auditscheduleid = $userdetails->auditscheduleid;
            $schteammemberid = $userdetails->schteammemberid;

            $AuditDiaryDataFetch = DB::connection($connection)
                                        ->table($table)
                                        ->join('audit.mst_subworkallocationtype as b', 'audit.trans_workallocation.subtypecode', '=', 'b.subworkallocationtypeid')
                                        ->join('audit.mst_majorworkallocationtype as c', 'b.majorworkallocationtypeid', '=', 'c.majorworkallocationtypeid')
                                        ->join('audit.auditdiary as audiary', 'audit.trans_workallocation.workallocationid', '=', 'audiary.workallocationid')
                                        ->where('audit.trans_workallocation.statusflag', '=', 'F')
                                        ->where('audiary.statusflag', '=', 'Y')
                                        ->where('b.statusflag', '=', 'Y')
                                        ->where('c.statusflag', '=', 'Y')
                                        ->where('audit.trans_workallocation.auditscheduleid', '=', $auditscheduleid)
                                        ->where('audit.trans_workallocation.schteammemberid', '=', $schteammemberid)
                                        ->get();

        }

                                        
        return $AuditDiaryDataFetch;

    }

    public static function userdetails_fetch()
    {
            $chargeData = session('charge');
            $session_deptcode = $chargeData->deptcode; // Accessing the department code from the session
            $session_usertypecode = $chargeData->usertypecode;
            $userData = session('user');
            $session_userid = $userData->userid;


            // Perform a database quer
            $inst_details = DB::table('audit.inst_schteammember as sm')
                                ->join('audit.inst_auditschedule as is', 'is.auditscheduleid', '=', 'sm.auditscheduleid')
                                ->join('audit.auditplan as ap', 'ap.auditplanid', '=', 'is.auditplanid')
                                ->join('audit.mst_institution as in', 'in.instid', '=', 'ap.instid')
                                ->join('audit.mst_auditeeins_category as incat', 'incat.catcode', '=', 'in.catcode')
                                ->join('audit.mst_typeofaudit as ta', 'ta.typeofauditcode', '=', 'ap.typeofauditcode')
                                ->join('audit.mst_auditperiod as d', 'd.auditperiodid', '=', 'ap.auditperiodid')
                                ->where('userid', $session_userid)
                                ->select('is.fromdate', 'is.todate', 'is.auditscheduleid','sm.auditscheduleid','sm.auditteamhead','is.auditplanid','is.fromdate','ap.instid','in.instename','incat.catename','in.mandays','sm.auditteamhead','ta.typeofauditename','d.fromyear','d.toyear','sm.schteammemberid')
                                ->orderBy('is.fromdate', 'desc') // Sort by `fromdate` in descending order
                                ->first();

            if($inst_details)
            {
                return $inst_details;

            }else{
                return false;
            }

    }


    public static function GetInstituteDetails($session_userid,$auditscheduleid)
    {       
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

                            ->first();

        return $inst_details;

    }



}
