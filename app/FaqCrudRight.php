<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqCrudRight extends Model
{
    protected $table = 'faq_crud_rights';
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
        return $this->belongsTo(UserGroup::class, 'usergroupid', 'systemId');
    }
}
