<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /***** START ABILITIES *****/
    CONST ABILITIES = [
        // Users
        'users:index',
        'users:create',
        'users:update',
        'users:delete',
        // Imports
        'imports:index',
        'imports:index:full',
        'imports:create',
        'imports:update',
        'imports:delete',
        // Exports
        'exports:index',
        'exports:index:full',
        'exports:create',
        'exports:update',
        'exports:delete',
        // Spare parts permits
        'sparePartsPermits:index',
        'sparePartsPermits:index:full',
        'sparePartsPermits:create',
        'sparePartsPermits:update',
        'sparePartsPermits:delete',
        // Statistics page
        'statistics:show',
        // employees
        'employees:index',
        'employees:create',
        'employees:update',
        'employees:delete',
    ];

    // Users
    CONST ABILITY_USERS_INDEX                    =  'users:index';
    CONST ABILITY_USERS_CREATE                   =  'users:create';
    CONST ABILITY_USERS_UPDATE                   =  'users:update';
    CONST ABILITY_USERS_DELETE                   =  'users:delete';
    // Imports
    CONST ABILITY_IMPORTS_INDEX                  = 'imports:index';
    CONST ABILITY_IMPORTS_INDEX_FULL             = 'imports:index:full';
    CONST ABILITY_IMPORTS_CREATE                 = 'imports:create';
    CONST ABILITY_IMPORTS_UPDATE                 = 'imports:update';
    CONST ABILITY_IMPORTS_DELETE                 = 'imports:delete';
    // Exports
    CONST ABILITY_EXPORTS_INDEX                  = 'exports:index';
    CONST ABILITY_EXPORTS_INDEX_FULL             = 'exports:index:full';
    CONST ABILITY_EXPORTS_CREATE                 = 'exports:create';
    CONST ABILITY_EXPORTS_UPDATE                 = 'exports:update';
    CONST ABILITY_EXPORTS_DELETE                 = 'exports:delete';
    // Spare parts permits
    CONST ABILITY_SPARE_PARTS_PERMITS_INDEX      = 'sparePartsPermits:index';
    CONST ABILITY_SPARE_PARTS_PERMITS_INDEX_FULL = 'sparePartsPermits:index:full';
    CONST ABILITY_SPARE_PARTS_PERMITS_CREATE     = 'sparePartsPermits:create';
    CONST ABILITY_SPARE_PARTS_PERMITS_UPDATE     = 'sparePartsPermits:update';
    CONST ABILITY_SPARE_PARTS_PERMITS_DELETE     = 'sparePartsPermits:delete';
    // Statistics page
    CONST ABILITY_STATISTICS_SHOW                = 'statistics:show';
    // Employees
    CONST ABILITY_EMPLOYEES_INDEX                =  'employees:index';
    CONST ABILITY_EMPLOYEES_CREATE               =  'employees:create';
    CONST ABILITY_EMPLOYEES_UPDATE               =  'employees:update';
    CONST ABILITY_EMPLOYEES_DELETE               =  'employees:delete';
    /***** END ABILITIES *****/

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'f_name',
        'l_name',
        'username',
        'email',
        'password',
        'abilities',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * get abilities of user
     *
     * @return array|false
     */
    public function getAbilities()
    {
        return explode(',', $this->abilities);
    }

    /**
     * set abilities of user
     *
     * @param array $abilities
     * @return void
     */
    public function setAbilities(array $abilities)
    {
        $this->abilities = implode(',', $abilities);
    }
}
