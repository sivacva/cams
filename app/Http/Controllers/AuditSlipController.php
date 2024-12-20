<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AuditSlipController extends Controller
{
    public function showAuditSlips()
    {
        // Fetch data from the database where processcode = 'X'
        $auditSlips = DB::table('audit.trans_auditslip')
            ->where('processcode', 'X')
            ->get();

        // Pass data to the view
        return view('audit/transauditslip', ['auditSlips' => $auditSlips]);
    }
}
