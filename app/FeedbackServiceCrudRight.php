<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackServiceCrudRight extends Model
{
    protected $table = 'feedback_service_crud_rights';
    protected $primaryKey = 'usergroupid';
    public $incrementing = false;

    protected $fillable = [
        'usergroupid',
        'view',
        'show'
    ];

    public function getUserGroup() {
        return $this->belongsTo(UserGroup::class, 'usergroupid', 'systemId');
    }
}
