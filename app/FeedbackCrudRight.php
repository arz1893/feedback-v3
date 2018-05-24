<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackCrudRight extends Model
{
    protected $table = 'feedback_crud_rights';
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
