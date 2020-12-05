<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Permissions\HasPermissionsTrait;

class Admin extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasPermissionsTrait;
    
    protected $table = 'admins';
    
    
    protected $hidden = [
        'password'
    ];
    
    protected $fillable = [
        'email',
        'password',
        'name',
        'phone',
        'status',
    ];
    public function validationRules($input = [])
    {
        return [
            'id' => isset($input['id']) ? 'required' : 'sometimes',
            'name' => 'required',
            'email' => isset($input['id']) ? 'required|unique:users,email,' . $input['id'] : 'required|unique:users,email',
            'password' => isset($input['id']) ? 'sometimes' : 'required',
            'confirm_password' => isset($input['id']) ? 'sometimes' : 'required:same:password',
        ];
    }


    public function roles() {
        return $this->belongsToMany(Role::class,'admins_roles');
     }

     public function permissions() {

        return $this->belongsToMany(Permission::class,'admins_permissions');
            
     }
}
