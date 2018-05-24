<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackListCrudRight extends Model
{
    protected $table = 'feedback_list_crud_rights';
    protected $primaryKey = 'usergroupid';
    public $incrementing = false;

    protected $fillable = [
        'usergroupid',
        'answer',
        'edit',
        'delete',
        'view'
    ];

    public function getUserGroup() {
        return $this->belongsTo(UserGroup::class, 'usergroupid','systemId');
    }
}
