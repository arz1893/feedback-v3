<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterDataRight extends Model
{
    protected $table = 'master_data_rights';
    protected $primaryKey = 'usergroupid';
    public $incrementing = false;

    protected $fillable = [
        'usergroupid',
        'create',
        'edit',
        'delete',
        'view'
    ];

    public function getUserGroup() {
        return $this->belongsTo(UserGroup::class, 'usergroupid', 'systemid');
    }
}
