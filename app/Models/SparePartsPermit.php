<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePartsPermit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'permit_number',
        'case_number',
        'client_name',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
