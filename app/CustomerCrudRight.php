<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCrudRight extends Model
{
    protected $table = 'customer_crud_rights';
    protected $primaryKey = 'usergroupid';
    public $incrementing = false;

    protected $fillable = [
        'usergroupid',
        'create',
        'edit',
        'delete'
    ];

    public function getUserGroup() {
        return $this->belongsTo(UserGroup::class, 'usergroupid', 'systemId');
    }
}
