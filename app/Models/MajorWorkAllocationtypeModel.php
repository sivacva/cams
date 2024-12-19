<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MajorWorkAllocationtypeModel extends Model
{
    protected $connection = 'pgsql'; // Default is 'mysql', use 'pgsql' for PostgreSQL


    protected $table = 'audit.mst_majorworkallocationtype';
    protected $primaryKey = 'majorworkallocationtypeid'; // No primary key
    // public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';
    const CREATED_AT = 'createdon'; // Custom column name for `created_at`
    const UPDATED_AT = 'updatedon';

    public static function audit_particulars()
    {
        return self::query()
            ->join('audit.mst_subworkallocationtype as sub', 'mst_majorworkallocationtype.majorworkallocationtypeid', '=', 'sub.majorworkallocationtypeid')

            ->select(
                'mst_majorworkallocationtype.majorworkallocationtypeename',
                'mst_majorworkallocationtype.majorworkallocationtypeid',
                'sub.subworkallocationtypeid',
                'sub.subworkallocationtypeename'

            )
            ->orderBy('mst_majorworkallocationtype.majorworkallocationtypeename', 'desc')
            ->where('sub.statusflag', '=', 'Y')
            ->get();
    }
}
