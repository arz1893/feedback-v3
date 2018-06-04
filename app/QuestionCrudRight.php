<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionCrudRight extends Model
{
    protected $table = 'question_crud_rights';
    protected $primaryKey = 'usergroupid';
    public $incrementing = false;

    protected $fillable = [
        'usergroupid',
        'create',
        'view'
    ];

    public function getUserGroup() {
        return $this->belongsTo(UserGroup::class,'usergroupid', 'systemId');
    }
}
