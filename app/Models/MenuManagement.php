<?php

namespace App\Models;
use Support\BaseModel;

class MenuManagement extends BaseModel
{
    // Model logic here
    protected $table = 'menu_access';
    protected $primaryKey = 'access_id';
    // protected $fillable = [
    //     'menu_id', 
    //     'role_id', 
    //     'uid', 
    //     'can_view', 
    //     'can_create', 
    //     'can_update', 
    //     'can_delete',
    // ];
}
