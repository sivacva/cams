<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;


use App\Models\MajorWorkAllocationtypeModel;
use App\Models\AccountParticularsModel;
use App\Models\TransAccountDetailModel;
use App\Models\InstAuditscheduleModel;
use App\Models\TransCallforrecordsModel;
use App\Models\AuditPeriodModel;


use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;

use DataTables;

class AuditeeController extends Controller
{
    protected $fileUploadService;

    // Inject the FileUploadService
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function audit_scheduledetails(Request $request)
    {
        $session = $request->session();
        if ($session->has('user')) {
            $user = $session->get('user');
            $userid = $user->userid ?? null;
        } else {
            return "No user found in session.";
        }
        // return $userid;
        // $userid = '3';
        $audit_scheduledetail = InstAuditscheduleModel::fetch_auditscheduledetails($userid);
        foreach ($audit_scheduledetail as $item) {
            $item->encrypted_auditscheduleid = Crypt::encryptString($item->auditscheduleid);
        }

        $AuditPeriod=AuditPeriodModel::where('statusflag', '=', 'Y')
                                     ->first();

        $auditperiod['from']=$AuditPeriod->fromyear;
        $auditperiod['to']=$AuditPeriod->toyear;

        return response()->json(['data' => $audit_scheduledetail,'auditperiod'=>$auditperiod]); // Ensure the data is wrapped under "data"

        // print_r($audit_plandetail);
    }
    public function auditee_partialchange(Request $request)
    {
        $auditscheduleid = Crypt::decryptString($request->audit_scheduleid);
        $data = $request->all();
        $change_date = Carbon::createFromFormat('d/m/Y', $request->input('change_date'))->format('Y-m-d');
        $entry_date = Carbon::createFromFormat('d/m/Y', $request->input('entry_date'))->format('Y-m-d');

        $request->merge(['change_date' => $change_date]);
        $request->merge(['entry_date' => $change_date]);
        $request->validate([
            'part_remarks'       => 'required', // Ensures only digits, allows leading zeros
            'change_date'     =>  'required|date|date_format:Y-m-d|',        // Only alphabets (no numbers or symbols)

        ]);
        $data = [
            'auditeeremarks' => $request->input('part_remarks'),
            'auditeeproposeddate' => $request->input('change_date'),
            'entrymeetdate' => $request->input('entry_date'),
            'auditeeresponse' => 'P',
            'updatedon' => now(),
            'auditeeresponsedt' => now() // Current timestamp for updated_at
        ];

        $audit_schedulepartial = InstAuditscheduleModel::update_partialchange($data, $auditscheduleid, 'P');

        if ($audit_schedulepartial) {
            return response()->json(['success' => 'Audit Schedule wad partially changed successfully', 'audit_schedule' => $audit_schedulepartial]);
        }
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
    public function filterValuesByKeyword(array $data, string $keyword): array
    {
        $filteredValues = [];

        foreach ($data as $key => $value) {
            if (strpos($key, "-$keyword") !== false) {
                $filteredValues[] = $value; // Add to filtered values array
            }
        }

        return $filteredValues;
    }

    public function uploadfile($data, $fileDetails)
    {
        if (isset($fileDetails['tmp_name']) && $fileDetails['error'] === UPLOAD_ERR_OK) {
            $file = new UploadedFile(
                $fileDetails['tmp_name'],    // Path to the temporary file
                $fileDetails['name'],        // Original file name
                $fileDetails['type'],        // MIME type
                $fileDetails['error'],       // Error code
                true                         // Test mode (skip file checks for temporary files)
            );
            // print_r($file->getPathname());

            // print_r($file);
            $destinationPath = 'uploads/auditeeReply';

            $uploadResult = $this->fileUploadService->uploadFile($file, $destinationPath, '');

            if (is_array($uploadResult)) {
                return null; // Return null if upload failed
            } elseif ($uploadResult instanceof \Illuminate\Http\JsonResponse) {
                $uploadResultData = $uploadResult->getData(true);
                return $uploadResultData['fileupload_id'] ?? null;
            }

            return null;
        }

        return null; // Return null if no valid file is provided
    }
    public function auditee_accept(Request $request)
    {
        $data = $request->all();
        $auditscheduleid = Crypt::decryptString($request->auditscheduleid);

        $request->validate([
            'nodalname'           => ['required', 'string',], // Ensures only digits, allows leading zeros
            'nodalmobile'         =>  'required|',         // Only alphabets (no numbers or symbols)
            'nodalemail'          =>   'required|email|max:50',             // Alphanumeric (letters and numbers)
            'nodaldesignation'    =>  'required|string|',

        ]);

        $accountCodes     = $this->filterValuesByKeyword($data, 'accountcode');
        $cfrSubcodes      = $this->filterValuesByKeyword($data, 'cfrcode');
        $accountValues    = $this->filterValuesByKeyword($data, 'accountvalues');
        $cfrValues        = $this->filterValuesByKeyword($data, 'cfrvalues');
        $replystatus      = $this->filterValuesByKeyword($data, 'cfrradio');
        $accountfilestatus = $this->filterValuesByKeyword($data, 'radio');

        $accountstatus = [];
        $fileDetails = [];
        foreach ($data as $key => $value) {

            if (strpos($key, "-radio") !== false) {

                $accountstatus[] = str_replace("-radio", "", $key);
            }
        }
        foreach ($_FILES as $name => $file) {
            // Check if the field name ends with '-accountfile' and if a file was uploaded
            if (strpos($name, "-accountfile") !== false) {
                $fileDetails[] = $file; // Add the entire file details to the array
            }
        }




        if (count($accountCodes) === count($accountValues)) {
            foreach ($accountCodes as $index => $accountCode) {
                // Determine if a file matches the account code
                $isfileupload = in_array($accountCode, $accountstatus);

                if ($isfileupload) {
                    if ($accountfilestatus[$index] === 'Y') { {
                            $fileuploadid = $this->uploadfile($data, $fileDetails[$index]);
                            // print_r($filefieldname[$index]);
                        }
                    } else {

                        $fileuploadid = '0';
                    }
                } else {
                    $fileuploadid = '0';
                }

                // Create a record for each account code with the corresponding file upload ID
                TransAccountDetailModel::create([
                    'auditscheduleid' => $auditscheduleid,
                    'accountcode' => $accountCode,
                    'remarks' => $accountValues[$index], // Use the corresponding remarks value
                    'statusflag' => 'Y',
                    'createdon' => now(),
                    'updatedon' => now(),
                    'fileuploadid' => $fileuploadid,
                    // other fields as necessary
                ]);
            }
        } else {
        }
        if (count($cfrSubcodes) === count($cfrValues)) {
            foreach ($cfrSubcodes as $key => $cfrSubcode) {

                TransCallforrecordsModel::create([
                    'auditscheduleid' => $auditscheduleid,
                    'subtypecode' => $cfrSubcode,
                    'remarks' => $cfrValues[$key],
                    'replystatus' => $replystatus[$key],
                    'statusflag' => 'Y',
                    'createdon' => now(),
                    'updatedon' => now(),
                    // other fields as necessary
                ]);
            }
        } else {
        }
        $acceptdata = [

            'auditeeresponsedt'    => now(),
            'auditeeresponse'      => 'A',
            'entrymeetdate'        => now(),
            'auditeeremarks'       => $request->auditee_remarks,
            'updatedon'            => now(),
            'auditeeremarks'       => $request->auditee_remarks,
            'nodalname'            => $request->nodalname,
            'nodalmobile'          => $request->nodalmobile,
            'nodalemail'           => $request->nodalemail,
            'nodaldesignation'     => $request->nodaldesignation,
        ];
        $audit_schedulepartial = InstAuditscheduleModel::update_partialchange($acceptdata, $auditscheduleid, 'A');
        if ($audit_schedulepartial);
        return response()->json(['success' => 'Datas submitted successfully']);
    }

    public function auditee_acceptdetails(Request $request)
    {
        $auditscheduleid = $request->auditscheduleid;
        $account_particularsaccept = InstAuditscheduleModel::fetch_Accountaccepteddetails($auditscheduleid);
        $cfr_saccept = InstAuditscheduleModel::fetch_cfraccepteddetails($auditscheduleid);
        return response()->json([
            'data' => $account_particularsaccept,
            'cfr' => $cfr_saccept
        ]);
        // return response()->json(['data' => $account_particularsaccept]); // Ensure the data is wrapped under "data"
    }
}
