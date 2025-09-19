<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReportingIncentive extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'by',
        'date',
        'case_number',
        'client_name',
        'warranty_status',
        'comment',
        'collection_fees',
        'sap_number',
        'damaged_position',
    ];
    protected $casts = [
        'date' => 'datetime',
        'damaged_position' => 'boolean'
    ];
}
