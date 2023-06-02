<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'cost',
        'comment',
    ];

    protected $cast = [
        'cost' => 'float'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
