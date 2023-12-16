<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'salary'
    ];

    protected $casts = [
        'salary' => 'float'
    ];

    public function fees()
    {
        return $this->hasMany(EmployeeFee::class, 'employee_id', 'id');
    }
}
