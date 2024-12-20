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

    public static function deptdetail($viewname = Null)
    {
        if(($viewname == 'createcharge')|| ($viewname == 'createuser'))
        {
            return DeptModel::where('statusflag', '=', 'Y')
            ->orderBy('orderid', 'asc')
            ->get();
        }
        else
        {
            $chargeData = session('charge');
            $session_deptcode = $chargeData->deptcode;

            // return DeptModel::where('statusflag', '=', 'Y')
            // ->orderBy('orderid', 'asc')
            // ->get();

            $query = DB::table('audit.chargedetails as c')
            ->distinct()
            ->select('d.deptcode', 'd.deptelname')
            ->join('audit.mst_dept as d', 'd.deptcode', '=', 'c.deptcode')
            ->whereNotNull('c.deptcode')
            ->whereNotIn('c.chargeid', function ($query) {
                $query->select('chargeid')->from('audit.userchargedetails')
                ->where('statusflag','Y');
            });

            if($session_deptcode)
            {
                $query->where('c.deptcode', $session_deptcode);
            }
            $results = $query->get();

            return $results;

        }
        
    }

    public static function designationdetail($tablename = Null)
    {
        return DesignationModel::where('statusflag', '=', 'Y')
        ->orderBy('desigelname', 'asc')
        ->get();
    }

    public static function roletypebasedon_sessionroletype($tablename = null, $deptcode, $roletypecode, $page)
    {
        if ($page === 'createcharge') {
            $query = DB::table($tablename)
                ->join('audit.mst_roletype as r', 'r.roletypecode', '=', 'audit.roletypemapping.roletypecode')
                ->join('audit.mst_dept as d', 'd.deptcode', '=', 'audit.roletypemapping.deptcode')
                ->select('audit.roletypemapping.roletypecode', 'r.roletypeelname')
                ->where('r.statusflag', 'Y');
    
            if ($roletypecode) {
                $query->where('audit.roletypemapping.roletypecode', '<=', $roletypecode);
            }
    
            if ($deptcode) {
                $query->where('audit.roletypemapping.deptcode', '=', $deptcode);
            }
    
            return $query
                ->orderBy('audit.roletypemapping.orderid', 'DESC')
                ->get();
        }
    
        if ($page === 'assigncharge') {
            return DB::table('audit.chargedetails as c')
                ->distinct()
                ->select('r.roletypecode', 'r.roletypeelname')
                ->join('audit.rolemapping as ro', 'ro.rolemappingid', '=', 'c.rolemappingid')
                ->join('audit.roletypemapping as rm', 'rm.roletypemappingcode', '=', 'ro.roletypemappingcode')
                ->join('audit.mst_roletype as r', 'r.roletypecode', '=', 'rm.roletypecode')
                ->where('r.statusflag', 'Y')
                ->where('c.deptcode', '=', $deptcode)
                ->whereNotIn('c.chargeid', function ($query) {
                    $query->select('chargeid')
                        ->from('audit.userchargedetails')
                        ->where('statusflag', 'Y');
                })
                ->get();
        }
    
        // Default return if no page matches
        return collect(); // Empty collection
    }
    


    public static function getRegionDistrictInstDelBasedOnDept(
        string $tablename,
        string $deptcode,
        ?string $regioncode = null,
        ?string $distcode = null,
        string $getval,
        string $roletypecode,
        string $page
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
                      ->distinct();
            
                if ($page === 'assigncharge') {
                    $query->join('audit.chargedetails as c', 'c.regioncode', '=', 're.regioncode')
                          ->whereNotIn('c.chargeid', function ($subQuery) {
                              $subQuery->select('chargeid')
                                       ->from('audit.userchargedetails')
                                       ->where('statusflag', 'Y');
                          });
                }
            
                $query->orderBy('re.regionename', 'ASC');
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
			unset($data['roleactioncode'], $data['roletypecode']);
			$data['rolemappingid'] = $rolemappingid;

			// Insert or update the record based on chargeid
			if ($chargeid) {
				$affectedRows = DB::table($table)->where('chargeid', $chargeid)->update($data);
				if ($affectedRows === 0) {
					throw new \Exception('Failed to update the record.');
				}
			} else {
				$newRecordId = DB::table($table)->insertGetId($data, 'chargeid');

				if (!$newRecordId) {
					throw new \Exception('Failed to insert the new record.');
				}
				return $newRecordId;
			}

		} catch (\Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}

    public static function getDesignationFromChargeDetails($table, $data)
    {
        $query = DB::table('audit.chargedetails as c')
            ->distinct()
            ->select('d.desigcode', 'd.desigelname')
            ->join("$table as d", 'd.desigcode', '=', 'c.desigcode')
            ->where('c.statusflag', 'Y');
    
        // Apply role type-based filtering
        $hoRoleTypeCode = View::shared('Ho_roletypecode');
        $reRoleTypeCode = View::shared('Re_roletypecode');
        $distRoleTypeCode = View::shared('Dist_roletypecode');
    
        if (in_array($data['roletypecode'], [$hoRoleTypeCode, $reRoleTypeCode, $distRoleTypeCode])) {
            $query->where('c.deptcode', $data['deptcode']);
    
            if (in_array($data['roletypecode'], [$reRoleTypeCode, $distRoleTypeCode])) {
                $query->where('c.regioncode', $data['regioncode']);
    
                if ($data['roletypecode'] === $distRoleTypeCode) {
                    $query->where('c.distcode', $data['distcode']);
                }
            }
        }
    
        // Exclude records that are already in userchargedetails
        $query->whereNotIn('c.chargeid', function ($subQuery) {
            $subQuery->select('chargeid')
                ->from('audit.userchargedetails')
                ->where('statusflag', 'Y');
        });
    
        return $query->get();
    }

    public static function getchargedescription($table, $data)
    {
        $query = DB::table('audit.chargedetails as c')
        ->select('c.chargeid', 'c.chargedescription')
        ->where('c.statusflag', 'Y');

        // Apply role type-based filtering
        $hoRoleTypeCode = View::shared('Ho_roletypecode');
        $reRoleTypeCode = View::shared('Re_roletypecode');
        $distRoleTypeCode = View::shared('Dist_roletypecode');

        $query->where('c.desigcode', $data['desigcode']);

        if (in_array($data['roletypecode'], [$hoRoleTypeCode, $reRoleTypeCode, $distRoleTypeCode])) {
            $query->where('c.deptcode', $data['deptcode']);

            if (in_array($data['roletypecode'], [$reRoleTypeCode, $distRoleTypeCode])) {
                $query->where('c.regioncode', $data['regioncode']);

                if ($data['roletypecode'] === $distRoleTypeCode) {
                    $query->where('c.distcode', $data['distcode']);
                }
            }
        }

        // Exclude records that are already in userchargedetails
        $query->whereNotIn('c.chargeid', function ($subQuery) {
            $subQuery->select('chargeid')
                ->from('audit.userchargedetails')
                ->where('statusflag', 'Y');
        });

        return $query->get();
    }

    public static function getuserbasedonroletype($table, $data)
    {
        return DB::table("{$table} as u")
        ->select('u.deptuserid', 'u.username')
        ->where('u.statusflag', 'Y')
        ->whereNotIn('u.deptuserid', function ($subQuery) {
            $subQuery->from('audit.userchargedetails')
                ->select('userid')
                ->where('statusflag', 'Y');
        })
        ->get();
    

    }
    



	public static function fetchchargeData($chargeid = null, $table)
	{
        $sessiondetails =   session('charge');
        $sessionroletypecode    =   $sessiondetails->roletypecode;
        $sessiondeptcode   =   $sessiondetails->deptcode;
        $sessionregioncode    =   $sessiondetails->regioncode;
        $sessiondistcode    =   $sessiondetails->distcode;


		// Build the query and apply the 'chargeid' condition if it's provided
		$query  =  DB::table($table)
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
			'd.deptesname',"$table.deptcode","$table.desigcode",'des.desigesname',"$table.chargedescription","$table.chargeid");

            if(($sessionroletypecode ==  View::shared('Ho_roletypecode')) || ($sessionroletypecode ==  View::shared('Re_roletypecode')) || ($sessionroletypecode ==  View::shared('Dist_roletypecode')))
            {
                $query->where("$table.deptcode", $sessiondeptcode);
                if(($sessionroletypecode ==  View::shared('Re_roletypecode')) || ($sessionroletypecode ==  View::shared('Dist_roletypecode')))
                {
                    $query->where("$table.regioncode", $sessionregioncode);
                    if(($sessionroletypecode ==  View::shared('Dist_roletypecode')))
                    $query->where("$table.distcode", $sessiondistcode);
                }
            }
			$query->when($chargeid, function ($query) use ($chargeid) {
				$query->where('chargeid', $chargeid);
			});
			// Return the results directly
            return $query->get();
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
