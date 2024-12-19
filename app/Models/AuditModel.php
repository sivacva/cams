<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class YearcodeMapping extends Model
{
    protected $connection = 'pgsql'; // Default is 'mysql', use 'pgsql' for PostgreSQL

    const CREATED_AT = 'createdon'; // Custom column name for `created_at`
    const UPDATED_AT = 'updatedon'; // Custom column name for `updated_at` (if you have it)

    // Define the table associated with this model
    protected $table = 'audit.yearcode_mapping';

    // Set primary key if it differs from the default 'id'
    protected $primaryKey = 'yearcodemappingid';  // Assuming `yearcodemapping_id` is the primary key

    // Set the primary key type if it's not an auto-incrementing integer
    protected $keyType = 'int';  // If `userid` is an integer

    // Disable auto-incrementing if necessary
    public $incrementing = true;  // If true, it will be treated as an auto-incrementing column

    // Set the fillable fields
    protected $fillable = ['auditplanid','yearselected','createdby', 'createdon', 'updatedon'];

    public static function fetchYearmapById($AuditId)
    {
        $AllData = self::where('auditplanid', $AuditId)->get();

        return $AllData;  // Eloquent collection

    }

}



class AuditModel extends Model
{
    protected $connection = 'pgsql'; // Default is 'mysql', use 'pgsql' for PostgreSQL

    const CREATED_AT = 'createdon'; // Custom column name for `created_at`
    const UPDATED_AT = 'updatedon'; // Custom column name for `updated_at` (if you have it)

    // Specify that the primary key is `userid` instead of `id`
    protected $primaryKey = 'auditplanid';

    // Specify the table name
    protected $table = 'audit.auditplan';

    // Set the primary key type if it's not an auto-incrementing integer
    protected $keyType = 'int';  // If `userid` is an integer

    // If your primary key is not auto-incrementing, set `incrementing` to false
    public $incrementing = true; // Set to `false` if `userid` is not auto-incrementing

    // Define the fillable fields
    protected $fillable = [
       'instid',  'auditteamid', 'typeofauditcode', 'auditperiodid', 'auditquartercode','statusflag'
    ];


    /**
     * Create a new user if it doesn't already exist based on email, phone, name, and address.
     * Otherwise, update the user if it already exists, based on email, phone, and name (excluding current id).
     *
     * @param array $data
     * @param int|null $currentUserId (optional: pass the current user's id for updates)
     * @return User|false
     */
    public static function createIfNotExistsOrUpdate(array $data, $currentUserId = null,array $yeararr,$VarDel=null)
    {
        $YearcodeMapArr=[];
        $data['statusflag'] = $data['statusflag'];
        //$data['yearcode'] = '0';


        try {
            // If currentUserId is provided, we are doing an update operation
            if ($currentUserId) {


                //for delete particular record
                if (isset($data['statusflag']) && $VarDel=='Delete')
                {
                    // Set the new status flag value
                    $data['statusflag'] = 'N';

                    DB::enableQueryLog();

                    // Search for the record with statusflag = 1 and matching auditplanid
                    $existingRecord = self::where('statusflag', 'Y')
                                           ->where('auditplanid', $currentUserId)
                                           ->first();


                    // Check if the record exists
                    if ($existingRecord) {
                        // Update the record with the new statusflag value
                        //$existingRecord->update(['statusflag' => $data['statusflag']]);

                        // Manually perform the update using the Query Builder
                        $connection = 'pgsql'; // Name of the database connection
                        $table = 'audit.auditplan'; // Full table name (including schema)

                        $UpdateAuditDelete=DB::connection($connection)
                                            ->table($table)
                                            ->where('auditplanid', $currentUserId)
                                            ->update(['statusflag' => $data['statusflag']]);

                        // Return the updated record
                        return $UpdateAuditDelete;
                    }
                }

                $existingUser = self::query()
                                    ->whereIn('statusflag', ['Y','F'])
                                    //->where('statusflag', '=', 'Y')
                                    ->where('auditteamid', '=', $data['auditteamid'])
                                    ->where('instid', '=', $data['instid'])
                                    ->where('auditplanid', '!=', $currentUserId)
                                    ->first();

                if ($existingUser) {
                    // If a user exists, return false or throw an exception (depending on your need)
                    return false;
                }

                // If no such user exists, update the existing record with the provided data
                $existingUser = self::find($currentUserId);
                $existingUser->update($data);

                $existingUser = self::find($currentUserId);
                $existingUser->update($data);


                $existingMappingarr = YearcodeMapping::fetchYearmapById($currentUserId);
                if ($existingMappingarr->isNotEmpty()) {
                    foreach ($existingMappingarr as $existingMapping)
                    {
                            $years_Fetch=$existingMapping->yearselected;
                            $yeararr = array_diff($yeararr, [$years_Fetch]);

                    }
                }

                self::updateyearcodemapping($yeararr,$currentUserId);

                return $existingUser;
            } else {
                // Check if a data with the same institute, auditteamcode, year already exists for insertion
                $existingUser = self::query()
                                    ->whereIn('statusflag', ['Y','F'])
                                    //->where('statusflag', '=', 'Y')
                                    ->where('auditteamid', '=', $data['auditteamid'])
                                    ->where('instid', '=', $data['instid'])
                                    ->first();

                if ($existingUser) {
                    // If data exists, return false or handle it as needed
                    return false;
                }
                // Otherwise, create and return the new user

                $CreateAuditPlanid=self::create($data);
                $GetAuditPlanId=$CreateAuditPlanid->auditplanid;
                self::updateyearcodemapping($yeararr,$GetAuditPlanId);
                return $GetAuditPlanId;
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

    public static function updateyearcodemapping(array $data, $currentUserId)
    {
        foreach($data as $YearVal)
        {
            // Check if the mapping already exists
            $yearmapping = YearcodeMapping::where('auditplanid', $currentUserId)
                                        ->where('yearselected', $YearVal)
                                        ->first();

            if ($yearmapping) {
                // If it exists, update the record
                $yearmapping->update(['yearselected' => $YearVal]);
            } else {
                // If it doesn't exist, create a new mapping
                YearcodeMapping::create([
                    'auditplanid' => $currentUserId,
                    'yearselected' => $YearVal,
                    'createdby'=>$currentUserId
                ]);
            }
        }
    }


    public static function fetchAllusers()
    {
        // Fetch all records where statusflag is 1
        $AllData = self::whereIn('statusflag', ['Y','F'])->get();

        // Log the result for debugging (better than using print_r)
        \Log::info('Fetched Audit Records:', $AllData->toArray()); // Logs as array for better readability

        // Return the data (can be used in a controller to return the response)
        return $AllData;  // Eloquent collection
    }



     /**
     * Insert the yearcode mapping into the yearcode_mapping table and return the generated yearmapping_id.
     *
     * @param string $yearcodes (comma-separated string of year codes)
     * @return int $yearmappingId (the primary key of the inserted record)
     */

    public static function fetchUserById($userId)
    {
        return self::find($userId);
    }

    public static function  fetch_auditplandetails($userid)
    {

        return self::query()
            ->join('audit.mst_institution as ai', 'ai.instid', '=', 'auditplan.instid')
            ->join('audit.auditplanteam as at', 'at.auditplanteamid', '=', 'auditplan.auditteamid')
            ->join('audit.auditplanteammember as atm', 'atm.auditplanteamid', '=', 'auditplan.auditteamid')
            ->join('audit.mst_typeofaudit as mst', 'mst.typeofauditcode', '=', 'auditplan.typeofauditcode')
            // ->join('audit.mst_auditperiod as map', 'map.auditperiodid', '=', 'auditplan.auditperiodid')
            ->join('audit.mst_dept as msd', 'msd.deptcode', '=', 'ai.deptcode')
            ->join('audit.mst_auditeeins_category as mac', 'mac.catcode', '=', 'ai.catcode')
            ->join('audit.mst_auditquarter as maq', 'maq.auditquartercode', '=', 'auditplan.auditquartercode')
            ->select(
                'ai.instename',
                'ai.deptcode',
                'ai.instid',
                'auditplan.auditteamid',
                'auditplan.auditplanid',
                'at.auditplanteamid',
                'atm.userid',
                'at.teamname',
                'mst.typeofauditename',
                // 'map.fromyear',
                // 'map.toyear',
                'msd.deptesname',
                'mac.catename',
                'maq.auditquarter',
                'auditplan.statusflag',
                DB::raw('(
        SELECT COUNT(*)
        FROM audit.auditplanteammember AS sub_atm
        WHERE sub_atm.auditplanteamid = auditplan.auditteamid
        AND sub_atm.teamhead = \'N\'
    ) AS team_member_count')
            )
            ->where('atm.userid', '=', $userid)
            ->where('atm.statusflag', '=', 'Y')
            ->where('atm.teamhead', '=', 'Y')
            ->where('auditplan.statusflag', '=', 'F')
            ->get();
    }

    // public static function fetch_plandetail()
    // {
    //     return self::query()
    //         ->join('audit.mst_institution as ai', 'ai.instid', '=', 'auditplan.instid')
    //         ->join('audit.mst_dept as dept', 'dept.deptcode', '=', 'ai.deptcode')
    //         ->select(
    //             'dept.deptelname',
    //             // Subquery for total_team_count
    //             DB::raw('(SELECT COUNT( auditplanid) FROM audit.auditplan WHERE statusflag = \'F\') AS total_plan_count'),
    //             // DB::raw('(SELECT COUNT( auditplanid) FROM audit.auditplan WHERE statusflag = \'F\' and ) AS dept_plan_count'),
    //             // Subquery for team_member_count
    //             // DB::raw('(SELECT COUNT(DISTINCT at.planteammemberid) FROM audit.auditplanteammember as at WHERE at.statusflag = \'Y\' AND at.auditplanteamid = auditplanteam.auditplanteamid) AS team_member_count')
    //         )
    //         ->where('auditplan.statusflag', 'F')
    //         ->get();
    // }

    public static function fetch_plandetail()
    {
        return DB::table('audit.mst_dept AS dept')
            ->leftJoin('audit.mst_institution AS ai', 'ai.deptcode', '=', 'dept.deptcode')
            ->leftJoin('audit.auditplan AS auditplan', function ($join) {
                $join->on('auditplan.instid', '=', 'ai.instid')
                    ->where('auditplan.statusflag', '=', 'F');
            })
            ->select(
                'dept.deptelname',
                DB::raw('(SELECT COUNT(DISTINCT auditplanid) FROM audit.auditplan WHERE statusflag =  \'F\'  ) AS total_auditplan_count'),
                DB::raw('COUNT(DISTINCT auditplan.auditplanid) AS dept_plan_count')
            )
            ->groupBy('dept.deptelname')
            ->get();
    }
}
