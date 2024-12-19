<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\View;


class FieldAuditModel extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'audit.trans_auditslip';
    protected $primaryKey = 'auditslipid';
    public $incrementing = true;
    const CREATED_AT = 'createdon';
    const UPDATED_AT = 'updatedon';

    protected $fillable = [
        'auditscheduleid', 'schteammemberid', 'auditplanid',
        'mainobjectionid', 'subobjectionid', 'amtinvolved',
        'tempslipnumber', 'mainslipnumber', 'slipdetails',
        'auditorremarks', 'severity','liability', 'liabilityname' ,'statusflag', 'createdon', 'updatedon',
        'createdby','updatedby','processcode','auditeeremarks'
    ];

    public static function getsubobjection($majorobjectionid)
    {
        return DB::table('audit.mst_subobjection')
            ->where('mainobjectionid', $majorobjectionid)
            ->where('statusflag', 'Y')
            ->select('subobjectionename', 'subobjectiontname','subobjectionid')
            ->orderBy('subobjectionename', 'asc')
            ->get();
    }


    public static function createIfNotExistsOrUpdate(array $data, $auditslipid = null)
    {
        try {

            // If no conflicts, proceed with create or update
            if ($auditslipid) {
                $existingUser = self::find($auditslipid);
                $existingUser->update($data);

                return [
                    'auditslipid' => $existingUser->auditslipid,
                    'slipnumber'  => $existingUser->mainslipnumber,
                ];
            } else {

                $maxId = self::max('auditslipid'); // Get the maximum ID
                $existingUser = self::find($maxId); // Find the record by the maximum ID

                if ($existingUser) {
                    $code = $existingUser->mainslipnumber; // Access the 'code' column value
                    $code   =   $code + 1;
                    $data['mainslipnumber'] =   $code;
                }
                else
                {
                    $code =1;
                    $data['mainslipnumber'] =   1;
                }
                $newRecord = self::create($data);

                // Return the ID of the newly created record
                   return ['auditslipid' => $newRecord->auditslipid,
                'slipnumber'    =>  $code ];


            }
        } catch (\Exception $e) {
            // Throwing a custom exception with the message from the model
            throw new \Exception($e->getMessage());
        }
    }



    // public static function fetchdata($userchargeid, $auditslipid = null,$auditteamhead,$auditscheduleid)
    // {

    //     // echo $auditteamhead;
    //     try {

    //     $query = FieldAuditModel::join('audit.slipfileupload as t3', 'trans_auditslip.auditslipid', '=', 't3.auditslipid')
    //     ->join('audit.fileuploaddetail as t2', 't2.fileuploadid', '=', 't3.fileuploadid')
    //     ->join('audit.mst_subobjection as s', 's.subobjectionid', '=', 'trans_auditslip.subobjectionid')
    //     ->select(
    //         'trans_auditslip.auditslipid',
    //         DB::raw('STRING_AGG(CONCAT(t2.filename, \'-\', t2.filepath, \'-\', t2.filesize,\'-\', t2.fileuploadid), \',\' ORDER BY t2.fileuploadid) AS filedetails_1'),
    //         'mainslipnumber',
    //         'trans_auditslip.subobjectionid',
    //         'trans_auditslip.mainobjectionid',
    //         'amtinvolved',
    //         'slipdetails',  // Keep the whole JSON column
    //         's.subobjectionename',
    //         DB::raw('auditorremarks::json->>\'content\' AS auditorremarks'),  // Extract specific key from JSON
    //         'severity',
    //         'liabilityname',
    //         'processcode',
    //         'auditorremarks'
    //     );

    //     // echo $userchargeid;
    //     // echo $auditscheduleid;




    //     // Add conditions based on $auditteamhead
    //     if ($auditteamhead === 'N') {
    //         $query->where('trans_auditslip.createdby', $userchargeid);
    //     }

    //     if ($auditteamhead === 'Y') {
    //         $query->where(function ($subQuery) use ($userchargeid) {
    //             // Add the conditions for when processcode is either 'S' or 'F'
    //             $subQuery->whereIn('trans_auditslip.processcode', ['S', 'F'])
    //                 ->orWhere(function ($nestedQuery) use ($userchargeid) {
    //                     // Condition for processcode 'E' and createdby
    //                     $nestedQuery->where('trans_auditslip.createdby', $userchargeid)
    //                         ->where('trans_auditslip.processcode', 'E');
    //                 });
    //                 // ->orWhere(function ($nestedQuery) {
    //                 //     // Condition for statusflag 'Y' and processcode 'E'
    //                 //     $nestedQuery->where('trans_auditslip.statusflag', 'Y')
    //                 //         ->where('trans_auditslip.processcode', 'E');
    //                 // });
    //         });dgf
    //     }

    //     // Add common conditions
    //     $query->where('trans_auditslip.statusflag', 'Y')
    //         ->where('trans_auditslip.auditscheduleid', $auditscheduleid);

    //     // Apply the auditslipid filter if it's provided
    //     if ($auditslipid) {
    //         $query->where('trans_auditslip.auditslipid', $auditslipid);
    //     }
    //     // Add group by clause with the extracted fields for JSON
    //     $results = $query->groupBy(
    //         'trans_auditslip.auditslipid',
    //         'mainslipnumber',
    //         'trans_auditslip.mainobjectionid',
    //         'amtinvolved',
    //         'slipdetails', // Ensure 'slipdetails' is a field that can be grouped
    //         DB::raw('auditorremarks::json->>\'content\''), // Group by the specific key inside the JSON field
    //         'severity',
    //         'liabilityname',
    //         's.subobjectionename',
    //         'trans_auditslip.subobjectionid',
    //         'trans_auditslip.auditscheduleid',
    //         'processcode'
    //     )->get();

    //     //         $rawQuery = $query->toSql();  // Get the raw SQL query

    //     // dd($rawQuery);  // Dump and die the query



    //         return $results;

    //     } catch (\Exception $e) {
    //         // Throwing a custom exception with the message from the model
    //         throw new \Exception($e->getMessage());
    //     }
    // }


    public static function fetchdata($userchargeid, $auditslipid = null,$auditteamhead,$auditscheduleid)
    {

        // echo $auditteamhead;
        try {

        $query = FieldAuditModel::join('audit.slipfileupload as t3', 'trans_auditslip.auditslipid', '=', 't3.auditslipid')
        ->join('audit.fileuploaddetail as t2', 't2.fileuploadid', '=', 't3.fileuploadid')
        ->join('audit.mst_subobjection as s', 's.subobjectionid', '=', 'trans_auditslip.subobjectionid')
        ->leftjoin('audit.userchargedetails as uc', 'uc.userchargeid', '=', 'trans_auditslip.forwardedby')
        ->leftjoin('audit.deptuserdetails as du', 'du.deptuserid', '=', 'uc.userid')
        ->leftjoin('audit.userchargedetails as uca', 'uca.userchargeid', '=', 'trans_auditslip.approvedby')
        ->leftjoin('audit.deptuserdetails as dua', 'dua.deptuserid', '=', 'uca.userid')

        ->select(
            'trans_auditslip.auditslipid',
            DB::raw('STRING_AGG(CONCAT(t2.filename, \'-\', t2.filepath, \'-\', t2.filesize,\'-\', t2.fileuploadid), \',\' ORDER BY t2.fileuploadid) AS filedetails_1'),
            'mainslipnumber',
            'trans_auditslip.subobjectionid',
            'trans_auditslip.mainobjectionid',
            'amtinvolved',
            'slipdetails',  // Keep the whole JSON column
            's.subobjectionename',
            DB::raw('auditorremarks::json->>\'content\' AS auditorremarks'),  // Extract specific key from JSON
            'severity',
            'liabilityname',
            'processcode',
            'auditorremarks',
            'liability',
            'dua.username as approvedbyusername',
            'approvedon',
            'du.username as forwardedbyusername',
            'forwardedon'
        )
        ->where('t2.usertypecode', View::shared('auditorlogin'));

        // echo $userchargeid;
        // echo $auditscheduleid;
        // Add conditions based on $auditteamhead
        if ($auditteamhead === 'N') {
            $query->where('trans_auditslip.createdby', $userchargeid);
        }

        if ($auditteamhead === 'Y') {
            $query->where(function ($subQuery) use ($userchargeid) {
                // Add the conditions for when processcode is either 'S' or 'F'
                $subQuery->whereIn('trans_auditslip.processcode', ['S', 'F','R','A','X'])
                    ->orWhere(function ($nestedQuery) use ($userchargeid) {
                        // Condition for processcode 'E' and createdby
                        $nestedQuery->where('trans_auditslip.createdby', $userchargeid)
                            ->where('trans_auditslip.processcode', 'E');
                    });
            });
        }

        // Add common conditions
        $query->where('trans_auditslip.statusflag', 'Y')
            ->where('trans_auditslip.auditscheduleid', $auditscheduleid);

        // Apply the auditslipid filter if it's provided
        if ($auditslipid) {
            $query->where('trans_auditslip.auditslipid', $auditslipid);
        }

        // Add group by clause with the extracted fields for JSON
        $results = $query->groupBy(
            'trans_auditslip.auditslipid',
            'mainslipnumber',
            'trans_auditslip.mainobjectionid',
            'amtinvolved',
            'slipdetails', // Ensure 'slipdetails' is a field that can be grouped
            DB::raw('auditorremarks::json->>\'content\''), // Group by the specific key inside the JSON field
            'severity',
            'liabilityname',
            's.subobjectionename',
            'trans_auditslip.subobjectionid',
            'trans_auditslip.auditscheduleid',
            'processcode','liability',
            'dua.username',
          
            'du.username'
        )
        ->get();





                return $results;

        } catch (\Exception $e) {
            // Throwing a custom exception with the message from the model
            throw new \Exception($e->getMessage());
        }
    }

    public static function fetchdata_auditee($userid, $auditslipid = null)
    {
        // First query: Fetch detailed audit slip data
        $query1 = FieldAuditModel::
        select([
            'trans_auditslip.auditslipid',
            DB::raw('CONCAT(t2.filename, \'-\', t2.filepath, \'-\', t2.filesize, \'-\', t2.fileuploadid) AS filedetails_1'),
            'mainslipnumber',
            'trans_auditslip.subobjectionid',
            'trans_auditslip.mainobjectionid',
            'amtinvolved',
            'slipdetails',
            's.subobjectionename',
            DB::raw("auditorremarks::json->>'content' AS auditorremarks"),
            'severity',
            'liabilityname',
            'trans_auditslip.processcode',
            'liability',
        ])
        ->join('audit.sliptransactiondetail as tr', 'trans_auditslip.auditslipid', '=', 'tr.auditslipid')
        ->join('audit.sliphistorytransactions as t', 'trans_auditslip.auditslipid', '=', 't.auditslipid')
        ->join('audit.slipfileupload as t3', 'trans_auditslip.auditslipid', '=', 't3.auditslipid')
        ->join('audit.fileuploaddetail as t2', 't2.fileuploadid', '=', 't3.fileuploadid')
        ->join('audit.mst_subobjection as s', 's.subobjectionid', '=', 'trans_auditslip.subobjectionid')
        ->where('t2.usertypecode', '=', 'A')
        ->when($auditslipid, function ($query) use ($auditslipid) {
            return $query->where('trans_auditslip.auditslipid', $auditslipid);
        })
        ->where(function ($query) use ($userid) {
            $auditeelogin = View::shared('auditeelogin'); // Retrieve the shared value

            $query->where(function ($subquery) use ($userid, $auditeelogin) {
                $subquery->where('tr.forwardedto', '=', $userid)
                         ->where('tr.forwardedtousertypecode', '=', $auditeelogin);
            })->orWhere(function ($subquery) use ($userid, $auditeelogin) {
                $subquery->where('t.forwardedby', '=', $userid)
                         ->where('t.forwardedtousertypecode', '=', $auditeelogin);
            });
        })

        ->where('trans_auditslip.statusflag', '=', 'Y')
        ->groupBy([
            'mainslipnumber',
            'trans_auditslip.subobjectionid',
            'trans_auditslip.mainobjectionid',
            'amtinvolved',
            'slipdetails',
            's.subobjectionename',
            DB::raw("auditorremarks::json->>'content'"),
            'severity',
            'liabilityname',
            'trans_auditslip.processcode',
            'liability',
            'trans_auditslip.auditslipid',
            't2.filename',
            't2.filepath',
            't2.filesize',
            't2.fileuploadid',
        ])
        ->orderby('trans_auditslip.auditslipid');


        // Execute the first query
        $results1 = $query1->get(); // This returns a Collection

        $query2 = FieldAuditModel::join('audit.sliptransactiondetail as tr', 'trans_auditslip.auditslipid', '=', 'tr.auditslipid')
        ->join('audit.sliphistorytransactions as t', 'trans_auditslip.auditslipid', '=', 't.auditslipid')
        ->join('audit.slipfileupload as t3', 'trans_auditslip.auditslipid', '=', 't3.auditslipid')
        ->join('audit.fileuploaddetail as t2', 't2.fileuploadid', '=', 't3.fileuploadid')
        ->select([
            DB::raw("CONCAT(t2.filename, '-', t2.filepath, '-', t2.filesize, '-', t2.fileuploadid) AS filedetails_1"),
            DB::raw("auditeeremarks::json->>'content' AS auditeeremarks"),
            'trans_auditslip.mainslipnumber',
        ])
        ->where('trans_auditslip.statusflag', 'Y')
        ->where('t2.uploadedby', $userid)
        ->where('t2.usertypecode', View::shared('auditeelogin'))
        ->when($auditslipid, function ($query) use ($auditslipid) {
            return $query->where('trans_auditslip.auditslipid', $auditslipid);
        })
        ->where(function ($query) use ($userid) {
            $query->where(function ($subquery) use ($userid) {
                $subquery->where('tr.forwardedto', $userid)
                         ->where('tr.forwardedtousertypecode', 'I');
            })->orWhere(function ($subquery) use ($userid) {
                $subquery->where('t.forwardedby', $userid)
                         ->where('t.forwardedtousertypecode', 'I');
            });
        })
        ->when($auditslipid, function ($query) use ($auditslipid) {
            return $query->where('trans_auditslip.auditslipid', $auditslipid);
        })
        ->groupBy([
            'trans_auditslip.auditslipid',
            'trans_auditslip.mainslipnumber',
            DB::raw("auditeeremarks::json->>'content'"),
            't2.filename',
            't2.filepath',
            't2.filesize',
            't2.fileuploadid',
        ])
        ->orderBy('trans_auditslip.auditslipid')
        ;



        // // Execute the second query
         $results2 = $query2->get(); // This returns a Collection

        // Combine the results as needed, here we are returning both results as an array
        return collect([
            'auditDetails' => $results1,
            'auditorRemarks' => $results2
        ]);
    }
    // public static function fetchdata_auditee($userid, $auditslipid = null)
    // {

    //     // First query: Fetch detailed audit slip data
    //     // $query1 = FieldAuditModel::
    //     //     join('audit.sliptransactiondetail as tr', 'trans_auditslip.auditslipid', '=', 'tr.auditslipid')
    //     //     ->leftjoin('audit.sliphistorytransactions as t', 'trans_auditslip.auditslipid', '=', 't.auditslipid') ->where('t.forwardedby', $userid)

    //     //     ->join('audit.slipfileupload as t3', 'trans_auditslip.auditslipid', '=', 't3.auditslipid')
    //     //     ->join('audit.fileuploaddetail as t2', 't2.fileuploadid', '=', 't3.fileuploadid')
    //     //     ->join('audit.mst_subobjection as s', 's.subobjectionid', '=', 'trans_auditslip.subobjectionid')
    //     //     ->select(
    //     //         'trans_auditslip.auditslipid',
    //     //         DB::raw("STRING_AGG(CONCAT(t2.filename, '-', t2.filepath, '-', t2.filesize, '-', t2.fileuploadid), ',' ORDER BY t2.fileuploadid) AS filedetails_1"),
    //     //         'mainslipnumber',
    //     //         'trans_auditslip.subobjectionid',
    //     //         'trans_auditslip.mainobjectionid',
    //     //         'amtinvolved',
    //     //         'slipdetails', // Retain the whole JSON column
    //     //         's.subobjectionename',
    //     //         DB::raw("auditorremarks::json->>'content' AS auditorremarks"), // Extract specific key from JSON
    //     //         'severity',
    //     //         'liabilityname',
    //     //         'trans_auditslip.processcode',
    //     //         'liability'
    //     //     )
    //     //     // ->where('t2.uploadedby', $userid)
    //     //     ->where('t2.usertypecode', View::shared('auditorlogin'))
    //     //     ->where('trans_auditslip.statusflag', 'Y')


    //     //     ->where(function ($query) use ($userid) {
    //     //         $query->where('tr.forwardedto', $userid)
    //     //               ->where('tr.forwardedtousertypecode', 'I');
    //     //             //   ->orWhere(function ($query) use ($userid) {
    //     //             //       $query->where('t.forwardedby', $userid)
    //     //             //             ->where('t.forwardedbyusertypecode', 'A');
    //     //             //   });
    //     //     })

    //     //     ->when($auditslipid, function ($query) use ($auditslipid) {
    //     //         return $query->where('trans_auditslip.auditslipid', $auditslipid);
    //     //     })
    //     //     ->groupBy(
    //     //         'trans_auditslip.auditslipid',
    //     //         'mainslipnumber',
    //     //         'trans_auditslip.mainobjectionid',
    //     //         'amtinvolved',
    //     //         'slipdetails',
    //     //         DB::raw("auditorremarks::json->>'content'"),
    //     //         'severity',
    //     //         'liabilityname',
    //     //         's.subobjectionename',
    //     //         'trans_auditslip.subobjectionid',
    //     //         'trans_auditslip.auditscheduleid',
    //     //         'trans_auditslip.processcode',
    //     //         'liability',
    //     //         'tr.auditslipid'
    //     //     );


    //     $query1 = FieldAuditModel::
    // join('audit.sliptransactiondetail as tr', 'trans_auditslip.auditslipid', '=', 'tr.auditslipid')
    // ->join('audit.slipfileupload as t3', 'trans_auditslip.auditslipid', '=', 't3.auditslipid')
    // ->join('audit.fileuploaddetail as t2', 't2.fileuploadid', '=', 't3.fileuploadid')
    // ->join('audit.mst_subobjection as s', 's.subobjectionid', '=', 'trans_auditslip.subobjectionid')
    // ->select(
    //     'trans_auditslip.auditslipid',
    //     DB::raw("STRING_AGG(CONCAT(t2.filename, '-', t2.filepath, '-', t2.filesize, '-', t2.fileuploadid), ',' ORDER BY t2.fileuploadid) AS filedetails_1"),
    //     'mainslipnumber',
    //     'trans_auditslip.subobjectionid',
    //     'trans_auditslip.mainobjectionid',
    //     'amtinvolved',
    //     'slipdetails', // Retain the whole JSON column
    //     's.subobjectionename',
    //     DB::raw("auditorremarks::json->>'content' AS auditorremarks"), // Extract specific key from JSON
    //     'severity',
    //     'liabilityname',
    //     'trans_auditslip.processcode',
    //     'liability'
    // )
    // ->where('t2.usertypecode', View::shared('auditorlogin'))
    // ->where('trans_auditslip.statusflag', 'Y')
    // ->where(function ($query) use ($userid) {
    //     $query->where('tr.forwardedto', $userid)
    //           ->where('tr.forwardedtousertypecode', 'I');
    // })
    // ->when(function () use ($userid) {
    //     // Check if there are any records in sliphistorytransactions matching the conditions
    //     return DB::table('audit.sliphistorytransactions')
    //         ->where('forwardedby', $userid)
    //         ->where('forwardedbyusertypecode', 'A')
    //         ->exists();
    // }, function ($query) use ($userid) {
    //     // Include the join and conditionally add the related where clause
    //     $query->leftJoin('audit.sliphistorytransactions as t', 'trans_auditslip.auditslipid', '=', 't.auditslipid')
    //           ->where(function ($query) use ($userid) {
    //               $query->orWhere('t.forwardedby', $userid)
    //                     ->where('t.forwardedbyusertypecode', 'A');
    //           });
    // })
    // ->when($auditslipid, function ($query) use ($auditslipid) {
    //     return $query->where('trans_auditslip.auditslipid', $auditslipid);
    // })
    // ->groupBy(
    //     'trans_auditslip.auditslipid',
    //     'mainslipnumber',
    //     'trans_auditslip.mainobjectionid',
    //     'amtinvolved',
    //     'slipdetails',
    //     DB::raw("auditorremarks::json->>'content'"),
    //     'severity',
    //     'liabilityname',
    //     's.subobjectionename',
    //     'trans_auditslip.subobjectionid',
    //     'trans_auditslip.auditscheduleid',
    //     'trans_auditslip.processcode',
    //     'liability',
    //     'tr.auditslipid'
    // );

    // // $rawQuery = $query1->toSql();  // Get the raw SQL query

    // //  dd($rawQuery);  // Dump and die the query

    //     // Execute the first query
    //     $results1 = $query1->get(); // This returns a Collection

    //     //print_r($results1);

    //     // $query2 = FieldAuditModel::
    //     // join('audit.sliptransactiondetail as tr', 'trans_auditslip.auditslipid', '=', 'tr.auditslipid')
    //     // ->join('audit.sliphistorytransactions as t', 'trans_auditslip.auditslipid', '=', 't.auditslipid')
    //     // ->join('audit.slipfileupload as t3', 'trans_auditslip.auditslipid', '=', 't3.auditslipid')
    //     // ->join('audit.fileuploaddetail as t2', 't2.fileuploadid', '=', 't3.fileuploadid')
    //     // ->select(
    //     //     DB::raw("STRING_AGG(CONCAT(t2.filename, '-', t2.filepath, '-', t2.filesize, '-', t2.fileuploadid), ',' ORDER BY t2.fileuploadid) AS filedetails_1"),
    //     //     DB::raw("auditeeremarks::json->>'content' AS auditeeremarks") // Extract specific key from JSON
    //     // )
    //     // ->where('trans_auditslip.statusflag', 'Y')
    //     // ->where('t2.uploadedby', $userid)
    //     // ->where('t2.usertypecode', View::shared('auditeelogin'))
    //     // // ->where(function ($query) use ($userid) {
    //     // //     $query->where('t.forwardedbyusertype', View::shared('auditeelogin'))
    //     // //           ->where('t.forwardedby', $userid);
    //     // // })
    //     // // ->where('t2.usertypecode', View::shared('auditeelogin'))
    //     // ->where(function ($query) use ($userid) {
    //     //     $query->where('tr.forwardedto', $userid)
    //     //         ->where('tr.forwardedtousertypecode', 'I')
    //     //         ->orWhere(function ($query) use ($userid) {
    //     //             $query->where('t.forwardedby', $userid)
    //     //                     ->where('t.forwardedbyusertypecode', 'I');
    //     //         });
    //     // })
    //     // ->when($auditslipid, function ($query) use ($auditslipid) {
    //     //     return $query->where('trans_auditslip.auditslipid', $auditslipid);
    //     // })
    //     // ->groupBy(
    //     //     DB::raw("auditeeremarks::json->>'content'"),
    //     //     'tr.auditslipid'
    //     // );

    //     $query2 = FieldAuditModel::
    // join('audit.sliptransactiondetail as tr', 'trans_auditslip.auditslipid', '=', 'tr.auditslipid')
    // ->join('audit.slipfileupload as t3', 'trans_auditslip.auditslipid', '=', 't3.auditslipid')
    // ->join('audit.fileuploaddetail as t2', 't2.fileuploadid', '=', 't3.fileuploadid')
    // ->select(
    //     DB::raw("STRING_AGG(CONCAT(t2.filename, '-', t2.filepath, '-', t2.filesize, '-', t2.fileuploadid), ',' ORDER BY t2.fileuploadid) AS filedetails_1"),
    //     DB::raw("auditeeremarks::json->>'content' AS auditeeremarks") // Extract specific key from JSON
    // )
    // ->where('trans_auditslip.statusflag', 'Y')
    // ->where('t2.uploadedby', $userid)
    // ->where('t2.usertypecode', View::shared('auditeelogin'))
    // ->where(function ($query) use ($userid) {
    //     $query->where('tr.forwardedto', $userid)
    //           ->where('tr.forwardedtousertypecode', 'I');
    // })
    // ->when(function () use ($userid) {
    //     // Check if there are any records in sliphistorytransactions matching the conditions
    //     return DB::table('audit.sliphistorytransactions')
    //         ->where('forwardedby', $userid)
    //         ->where('forwardedbyusertypecode', 'I')
    //         ->exists();
    // }, function ($query) use ($userid) {
    //     // Include the join and conditionally add the related where clause
    //     $query->join('audit.sliphistorytransactions as t', 'trans_auditslip.auditslipid', '=', 't.auditslipid')
    //           ->where(function ($query) use ($userid) {
    //               $query->where('t.forwardedby', $userid)
    //                     ->where('t.forwardedbyusertypecode', 'I');
    //           });
    // })
    // ->when($auditslipid, function ($query) use ($auditslipid) {
    //     return $query->where('trans_auditslip.auditslipid', $auditslipid);
    // })
    // ->groupBy(
    //     DB::raw("auditeeremarks::json->>'content'"),
    //     'tr.auditslipid'
    // );



    //     // Execute the second query
    //     $results2 = $query2->get(); // This returns a Collection

    //     // Combine the results as needed, here we are returning both results as an array
    //     return collect([
    //         'auditDetails' => $results1,
    //         'auditorRemarks' => $results2
    //     ]);
    // }


    public static function getviewauditslip_withreply($userid, $auditslipid = null,$auditscheduleid,$auditteamhead)
    {
        $query1 = FieldAuditModel::
            join('audit.sliptransactiondetail as tr', 'trans_auditslip.auditslipid', '=', 'tr.auditslipid')
            ->join('audit.slipfileupload as t3', 'trans_auditslip.auditslipid', '=', 't3.auditslipid')
            ->join('audit.fileuploaddetail as t2', 't2.fileuploadid', '=', 't3.fileuploadid')
            ->join('audit.mst_subobjection as s', 's.subobjectionid', '=', 'trans_auditslip.subobjectionid')
            ->join('audit.mst_process as p', 'p.processcode', '=', 'trans_auditslip.processcode')
            ->select(
                'trans_auditslip.auditslipid',
                DB::raw("
                    STRING_AGG(CONCAT(
                        COALESCE(t2.filename, ''), '-',
                        COALESCE(t2.filepath, ''), '-',
                        COALESCE(t2.filesize::TEXT, ''), '-',
                        COALESCE(t2.fileuploadid::TEXT, '')
                    ), ',' ORDER BY t2.fileuploadid) AS filedetails_1
                "),
                'mainslipnumber',
                'trans_auditslip.subobjectionid',
                'trans_auditslip.mainobjectionid',
                'amtinvolved',
                'slipdetails', // Retain the whole JSON column
                's.subobjectionename',
                DB::raw("COALESCE(auditorremarks::json->>'content', '') AS auditorremarks"), // Extract specific key from JSON
                'severity',
                'liabilityname',
                'trans_auditslip.processcode',
                'liability',
                'trans_auditslip.auditeerepliedon',
                'p.processelname'
            )
            ->where('trans_auditslip.statusflag', 'Y')
            ->where('trans_auditslip.auditscheduleid', $auditscheduleid);

            if ($auditteamhead === 'N') {
                $query1->where('trans_auditslip.createdby', $userid)
                ->wherein('trans_auditslip.processcode', ['R','A','X']);
            }

            if ($auditteamhead === 'Y') {
                $query1->where('tr.forwardedto', $userid)
                ->where('tr.forwardedtousertypecode', View::shared('auditorlogin'));
            }




            $query1->where('t2.usertypecode', View::shared('auditorlogin'))
            ->when($auditslipid, function ($query) use ($auditslipid) {
                return $query->where('trans_auditslip.auditslipid', $auditslipid);
            })

            ->groupBy(
                'trans_auditslip.auditslipid',
                'mainslipnumber',
                'trans_auditslip.mainobjectionid',
                'amtinvolved',
                'slipdetails',
                DB::raw("auditorremarks::json->>'content'"),
                'severity',
                'liabilityname',
                's.subobjectionename',
                'trans_auditslip.subobjectionid',
                'trans_auditslip.auditscheduleid',
                'trans_auditslip.processcode',
                'liability',
                'trans_auditslip.auditeerepliedon',
                'p.processelname'
            )
            ->orderby('trans_auditslip.auditslipid');


        // Execute the first query
        $results1 = $query1->get(); // This returns a Collection


        $query2 = FieldAuditModel::
            join('audit.slipfileupload as t3', 'trans_auditslip.auditslipid', '=', 't3.auditslipid')
            ->join('audit.fileuploaddetail as t2', 't2.fileuploadid', '=', 't3.fileuploadid')
            ->select(
                DB::raw("
                    STRING_AGG(CONCAT(
                        COALESCE(t2.filename, ''), '-',
                        COALESCE(t2.filepath, ''), '-',
                        COALESCE(t2.filesize::TEXT, ''), '-',
                        COALESCE(t2.fileuploadid::TEXT, '')
                    ), ',' ORDER BY t2.fileuploadid) AS filedetails_1
                "),
                DB::raw("COALESCE(auditeeremarks::json->>'content', '') AS auditeeremarks")
            )
            ->where('trans_auditslip.statusflag', 'Y')
            ->where('trans_auditslip.auditscheduleid', $auditscheduleid)
            ->wherein('trans_auditslip.processcode', ['R','A','X'])
            ->where('t2.usertypecode', View::shared('auditeelogin'))
            ->when($auditslipid, function ($query) use ($auditslipid) {
                return $query->where('trans_auditslip.auditslipid', $auditslipid);
            })
            ->groupBy('trans_auditslip.auditslipid',DB::raw("auditeeremarks::json->>'content'"))
            ->orderby('trans_auditslip.auditslipid');

        //dd($query2->toSql());


        // Execute the second query
        $results2 = $query2->get(); // This returns a Collection


        // Combine the results as needed, here we are returning both results as an array
        return collect([
            'auditDetails' => $results1,
            'auditorRemarks' => $results2
        ]);
    }


    public static function fetchdata_teamheaduserid($auditslipid)
    {
        try {

            $query1 = FieldAuditModel::join('audit.inst_schteammember as im', 'im.auditscheduleid', '=', 'trans_auditslip.auditscheduleid')
                ->join('audit.userchargedetails as u', 'u.userid', '=', 'im.userid')
                ->where('trans_auditslip.auditslipid', $auditslipid)
                ->where('u.statusflag', 'Y')
                ->where('im.auditteamhead', 'Y');

             // Fetch and return user IDs
            return $query1->pluck('u.userchargeid'); // Returns an array of user IDs
        } catch (\Exception $e) {
            // Throw a custom exception with the message from the model
            throw new \Exception($e->getMessage());
        }
    }

    public static function slipfileupload(array $data, $auditslipid = null, $fileuploadid = null)
    {
        try {
            // If both auditslipid and fileuploadid are provided, proceed with the logic
            if ($auditslipid && $fileuploadid) {
                // Check if there is an existing record for this audit slip and file upload ID
                $existingUser = DB::table('audit.slipfileupload')
                    ->where('auditslipid', $auditslipid)
                    ->where('fileuploadid', $fileuploadid)
                    ->first(); // Using first() to fetch a single record


                // If an existing record is found, update it
                if ($existingUser) {
                    // Update the existing record with the new data
                    DB::table('audit.slipfileupload')
                        ->where('auditslipid', $auditslipid)
                        ->where('fileuploadid', $fileuploadid)
                        ->update($data);

                    // You can return a success message or the ID of the updated record
                    return $existingUser->slipfileuploadid; // or return a custom response like success or affected rows count
                } else {
                    // If no existing record, insert a new one
                    $slipfileuploadid = DB::table('audit.slipfileupload')
                        ->insertGetId($data, 'slipfileuploadid');

                    return $slipfileuploadid; // Return the ID of the newly inserted record
                }
            } else {
                // If either auditslipid or fileuploadid is not provided, handle it accordingly
                throw new \Exception('Both auditslipid and fileuploadid are required.');
            }
        } catch (\Exception $e) {
            // Catch any exceptions and throw them to be handled elsewhere
            throw new \Exception('Error in slipfileupload: ' . $e->getMessage());
        }
    }





    public function slip_gettransaction()
    {

    }

    public static function fetchdata_auditeeuserid($instid)
    {
        try {
            $query = DB::table('audit.audtieeuserdetails as au')
                ->where('au.instid', $instid);

             // Fetch and return user IDs
            return $query->pluck('au.auditeeuserid'); // Returns an array of user IDs
        } catch (\Exception $e) {
            // Throw a custom exception with the message from the model
            throw new \Exception($e->getMessage());
        }
    }
    // public static function create_transactiondel($insertdata, $updatedata, $auditslipid = null)
    // {
    //     try {
    //         $isInserted = false;
    //         $isUpdated = false;

    //         // Initialize the transaction ID
    //         $transid = null;

    //         // Query the table to check if auditslipid exists
    //         $query = DB::table('audit.sliptransactiondetail as ts');

    //         if ($auditslipid !== null) {
    //             $query->where('ts.auditslipid', $auditslipid);
    //         }

    //         // Check for the existence of the auditslipid
    //         $slipidExists = $query->exists();

    //         if (!$slipidExists) {
    //             // Create a new transaction if auditslipid does not exist
    //             $transactionid = DB::table('audit.sliptransactiondetail')->insertGetId($insertdata, 'transactionid');

    //             // Check if creation was successful
    //             if ($transactionid) {
    //                 // $transid = $transdel->transactionid;
    //                 $isInserted = true; // Mark the insert as successful
    //             } else {
    //                 throw new \Exception("Failed to create a new transaction.");
    //             }
    //         } else {
    //             // Update the existing transaction if auditslipid exists
    //             $transdel = DB::where('auditslipid', $auditslipid)->first();

    //             if ($transdel) {
    //                 $updateResult = $transdel->update($updatedata);

    //                 // Check if the update was successful
    //                 if ($updateResult) {
    //                     $transid = $transdel->transid;
    //                     $isUpdated = true; // Mark the update as successful
    //                 } else {
    //                     throw new \Exception("Update failed for transaction with auditslipid {$auditslipid}.");
    //                 }
    //             } else {
    //                 throw new \Exception("Transaction with auditslipid {$auditslipid} not found.");
    //             }
    //         }

    //         // Return true if either insert or update was successful
    //         if ($isInserted || $isUpdated) {
    //             return true; // Success
    //         } else {
    //             throw new \Exception("Neither insert nor update was successful.");
    //         }
    //     } catch (\Exception $e) {
    //         // Handle exceptions and throw a custom error message
    //         throw new \Exception($e->getMessage());
    //     }
    // }
    public static function create_transactiondel($insertdata, $updatedata, $auditslipid = null)
    {
        try {
            $isInserted = false;
            $isUpdated = false;
            $transid = null;

            // Check if auditslipid exists in the table
            $slipidExists = DB::table('audit.sliptransactiondetail')
                ->where('auditslipid', $auditslipid)
                ->exists();

            if (!$slipidExists) {
                // If auditslipid doesn't exist, insert the new record
                $transactionid = DB::table('audit.sliptransactiondetail')
                    ->insertGetId($insertdata, 'transactionid');

                if ($transactionid) {
                    $isInserted = true; // Mark the insertion as successful
                    // echo "Insert successful!\n";
                } else {
                    throw new \Exception("Failed to create a new transaction.");
                }
            } else {
                // If auditslipid exists, update the existing record
                $updateResult = DB::table('audit.sliptransactiondetail')
                    ->where('auditslipid', $auditslipid)
                    ->update($updatedata);

                if ($updateResult) {
                    $isUpdated = true;
                    // echo "Update successful!\n";
                } else {
                   // echo "Update failed. No changes made.\n";
                }
            }

            // Return true if insert or update was successful
            if ($isInserted || $isUpdated) {
                return true; // Success
            } else {
                throw new \Exception("Neither insert nor update was successful.");
            }
        } catch (\Exception $e) {
            // Handle exceptions and throw a custom error message
            echo "Error: " . $e->getMessage() . "\n";
            throw new \Exception($e->getMessage());
        }
    }


    public static function insert_historytransactiondel($data, $auditslipid = null)
    {
        try {
            $isUpdated = false;
            $isInserted = false;

            // Check if the auditslipid condition is provided and exists
            if ($auditslipid !== null) {
                $slipidExists = DB::table('audit.sliphistorytransactions as ts')
                    ->where('ts.auditslipid', $auditslipid)
                    ->exists();

                // Update the existing record if auditslipid exists
                if ($slipidExists) {
                    $updateCount = DB::table('audit.sliphistorytransactions')
                        ->where('auditslipid', $auditslipid)
                        ->update(['transtatus' => 'I']);

                    // Check if the update was successful
                    $isUpdated = $updateCount > 0;
                }
            }

            // // Create a new history transaction record
            // $historytransdel = self::create($data);

            $historytransdel = DB::table('audit.sliphistorytransactions')->insertGetId($data, 'transhistoryid');


            // Check if the insert was successful
            if ($historytransdel) {
                $isInserted = true;
            }

            // Return true only if both operations succeeded
            if ($isUpdated || $isInserted) {
                return true;
            } else {
                throw new \Exception("Neither update nor insert was successful.");
            }
        } catch (\Exception $e) {
            // Throw a custom exception with the message from the model
            throw new \Exception($e->getMessage());
        }
    }
   
    public static function getpendingparadetails($auditscheduleid)
    {
        $query = FieldAuditModel::join('audit.mst_process as p', 'p.processcode', '=', 'trans_auditslip.processcode')
            ->join('audit.mst_mainobjection as m', 'm.mainobjectionid', '=', 'trans_auditslip.mainobjectionid')
            ->join('audit.mst_subobjection as s', 's.subobjectionid', '=', 'trans_auditslip.subobjectionid')
            ->where('trans_auditslip.auditscheduleid', $auditscheduleid)
            ->select('m.objectionename', 's.subobjectionename', 'mainslipnumber', 'amtinvolved', 'slipdetails', 
            'auditorremarks','p.processelname','p.processcode',
                    'liability', 'liabilityname')
            ->get();
        return $query;
    }
    

    public static function update_auditsliptable($data, $auditslipid = null)
    {
        try {
            if ($auditslipid === null) {
                throw new \Exception("Auditslip ID is required for updating.");
            }

            // Check if the record exists
            $slipidExists = DB::table('audit.trans_auditslip')
                ->where('auditslipid', $auditslipid)
                ->exists();

            if (!$slipidExists) {
                throw new \Exception("Auditslip ID {$auditslipid} does not exist.");
            }

            // Perform the update
            $updated = DB::table('audit.trans_auditslip')
                ->where('auditslipid', $auditslipid)
                ->update($data);

            // Log the update result
            \Log::info("Update result: {$updated}");

            if ($updated) {
                return true; // Update was successful
            } else {
                throw new \Exception("Update executed but no rows were affected. Check the data.");
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

}
