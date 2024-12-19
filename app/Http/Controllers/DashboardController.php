<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

use App\Models\AuditTeamModel;
use App\Models\AuditModel;
use App\Models\DesignationModel;
use App\Models\DistrictModel;
use App\Models\UserChargeDetailsModel;
use App\Models\AuditMemberModel;
use App\Models\Charge;
use App\Models\AssignCharge;
use App\Models\UserChargeDetailModel;
use Illuminate\Http\Request;

use DB;

class DashboardController extends Controller
{
    public function dashboard_detail()
    {
        $charge = session('charge');
        $chargeid = $charge->chargeid;
        if ($chargeid == '1') {
            // $auditscheduleid = $request->auditscheduleid;
            $teamdetail = AuditTeamModel::fetch_teamdetail();
            $plandetail = AuditModel::fetch_plandetail();
            return response()->json([

                'teamdetail' => $teamdetail,
                'plandetail' => $plandetail
            ]);
        }
    }
}