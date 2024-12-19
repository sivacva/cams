<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

use Exception;

class UserManagementModel extends Model
{
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }


    public static function roleactiondetail($tablename = Null)
    {
        return DB::table($tablename)
        ->where('statusflag', '=', 'Y')
        ->orderBy('roleactionid', 'asc')
        ->get();
    }

    public static function deptdetail($tablename = Null)
    {
        return DeptModel::where('statusflag', '=', 'Y')
        ->orderBy('orderid', 'asc')
        ->get();
    }

    public static function designationdetail($tablename = Null)
    {
        return DesignationModel::where('statusflag', '=', 'Y')
        ->orderBy('desigelname', 'asc')
        ->get();
    }

    public static function roletypebasedon_sessionroletype($tablename = null, $deptcode, $roletypecode)
    {
        $query = DB::table($tablename)
            ->join('audit.mst_roletype as r', 'r.roletypecode', '=', 'audit.roletypemapping.roletypecode')
            ->join('audit.mst_dept as d', 'd.deptcode', '=', 'audit.roletypemapping.deptcode')
            ->select('audit.roletypemapping.roletypecode','r.roletypeelname')
            ->where( 'r.statusflag','Y');

        if ($roletypecode) {
            $query->where('roletypemapping.roletypecode', '<=', $roletypecode);
        }

        if ($deptcode) {
            $query->where('roletypemapping.deptcode', '=', $deptcode);
        }

        return $query
            ->orderBy('audit.roletypemapping.orderid', 'DESC') // Order by ID descending
            ->get(); // Fetch all records
    }


    public static function getRegionDistrictInstDelBasedOnDept(
        string $tablename,
        string $deptcode,
        ?string $regioncode = null,
        ?string $distcode = null,
        string $getval,
        string $roletypecode
    ) {
        // Validate required parameters
        if (empty($tablename) || empty($deptcode) || empty($getval)) {
            throw new InvalidArgumentException("Invalid arguments provided.");
        }

        // Initialize base query
        $query = DB::table($tablename)
            ->where("$tablename.statusflag", 'Y')
            ->where("$tablename.deptcode", $deptcode);

        // Process based on the value of $getval
        switch ($getval) {
            case 'region':
                $query->join('audit.mst_region as re', 're.regioncode', '=', "$tablename.regioncode")
                      ->select("$tablename.regioncode", 're.regionename')
                      ->distinct()
                      ->orderBy("re.regionename", 'ASC');
                break;

            case 'district':
                $query->join('audit.mst_region as re', 're.regioncode', '=', "$tablename.regioncode")
                      ->join('audit.mst_district as d', 'd.distcode', '=', "$tablename.distcode")
                      ->where("$tablename.regioncode", $regioncode)
                      ->select("$tablename.distcode", 'd.distename')
                      ->distinct()
                      ->orderBy("d.distename", 'ASC');
                break;

            case 'institution':
                $query->join('audit.mst_region as re', 're.regioncode', '=', "$tablename.regioncode")
                      ->select("$tablename.instmappingid", "$tablename.instename","$tablename.instmappingcode")
                      ->where("$tablename.roletypecode", $roletypecode);

                // Apply additional filters for institution
                if ($regioncode) {
                    $query->where("$tablename.regioncode", $regioncode);
                }
                if ($distcode) {
                    $query->join('audit.mst_district as d', 'd.distcode', '=', "$tablename.distcode")
                          ->where("$tablename.distcode", $distcode);
                }
                $query->orderBy("$tablename.instename", 'ASC');
                break;

            default:
                throw new InvalidArgumentException("Invalid 'getval' provided. Allowed values are 'region', 'district', or 'institution'.");
        }

        // Order results and execute the query
        return

        $query->get();
    }


    public static function createcharge_insertupdate(array $data, $chargeid = null, $table)
	{
		try {
			//Check if the role mapping exists and get the ID
			$rolemappingid = DB::table('audit.rolemapping')
				->join('audit.roletypemapping as rm', 'rm.roletypemappingcode', '=', 'audit.rolemapping.roletypemappingcode')
				->where('rm.roletypecode', $data['roletypecode'])
				->where('rolemapping.roleactioncode', $data['roleactioncode'])
				->where('rm.deptcode', $data['deptcode'])
				->value('rolemappingid');

			

			if (!$rolemappingid) {
				throw new \Exception('Role mapping does not exist.');
			}

			// Build where conditions dynamically
			$wherecondition = [
				'rolemappingid' => $rolemappingid,
				'desigcode'     => $data['desigcode'],
			];
			
			// Start building the query
			$query = DB::table($table)->where($wherecondition);
			
			// Exclude the current chargeid if updating
			if ($chargeid) {
				$query->where('chargeid', '<>', $chargeid);
			}
			
			// Check if the record already exists
			if ($query->exists()) {
				throw new \Exception('Charge already exists');
			}
			

			// Remove unwanted fields and add rolemappingid
			unset($data['roleactioncode'], $data['roletypecode'], $data['deptcode']);
			$data['rolemappingid'] = $rolemappingid;

			// Insert or update the record based on chargeid
			if ($chargeid) {
				$affectedRows = DB::table($table)->where('chargeid', $chargeid)->update($data);
				if ($affectedRows === 0) {
					throw new \Exception('Failed to update the record.');
				}
			} else {
				$newRecordId = DB::table($table)->insertGetId($data);
				if (!$newRecordId) {
					throw new \Exception('Failed to insert the new record.');
				}
				return $newRecordId;
			}

		} catch (\Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}



	public static function fetchchargeData($chargeid = null, $table)
	{
		// Build the query and apply the 'chargeid' condition if it's provided
		return DB::table($table)
			->join("audit.rolemapping as rm", "rm.rolemappingid", '=', "$table.rolemappingid")
			->join("audit.mst_roleaction as ra", "rm.roleactioncode", '=', "ra.roleactioncode")
			->join("audit.roletypemapping as rtm", "rtm.roletypemappingcode", '=', "rm.roletypemappingcode")
			->join("audit.mst_roletype as rt", "rt.roletypecode", '=', "rtm.roletypecode")
			->join("audit.mst_dept as d", "d.deptcode", '=', "$table.deptcode")
			->leftjoin("audit.mst_region as r", "r.regioncode", '=', "$table.regioncode")
			->leftjoin("audit.mst_district as di", "di.distcode", '=', "$table.distcode")
			->leftjoin("audit.auditor_instmapping as ins", "ins.instmappingcode", '=', "$table.instmappingcode")
			->join("audit.mst_designation as des", "des.desigcode", '=', "$table.desigcode")
			
			->select("rt.roletypecode",'rt.roletypeelname',"ra.roleactioncode",'ra.roleactionelname',
			'r.regionename',"$table.regioncode","$table.distcode",'di.distename',"$table.instmappingcode",'ins.instename',
			'd.deptesname',"$table.deptcode","$table.desigcode",'des.desigesname',"$table.chargedescription","$table.chargeid")
			
			->when($chargeid, function ($query) use ($chargeid) {
				$query->where('chargeid', $chargeid);
			})
			->get(); // Return the results directly
	}


    public static function bindwherecondition_basedon_roletypecode($data)
    {
        $where = [];
        if (in_array($data['roletypecode'], [
            View::shared('Ho_roletypecode'),
            View::shared('Re_roletypecode'),
            View::shared('Dist_roletypecode')
        ])) {
            $where['deptcode'] = $data['deptcode'];

            if (in_array($data['roletypecode'], [View::shared('Re_roletypecode'), View::shared('Dist_roletypecode')])) {
                $where['instmappingid'] = $data['instid'];

                if ($data['roletypecode'] == View::shared('Re_roletypecode')) {
                    $where['regioncode'] = $data['regioncode'];
                }

                if ($data['roletypecode'] == View::shared('Dist_roletypecode')) {
                    $where['distcode'] = $data['distcode'];
                }
            }
        }
        return $where; // Ensure the condition is returned
    }
}
