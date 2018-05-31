<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackServiceListCrudRight extends Model
{
    protected $table = 'feedback_service_list_crud_rights';
    protected $primaryKey = 'usergroupid';
    public $incrementing = false;

    protected $fillable = [
        'usergroupid',
        'view',
        'answer',
        'edit',
        'delete'
    ];

    public function getUserGroup() {
        return $this->belongsTo(UserGroup::class, 'usergroupid', 'systemId');
    }
}
