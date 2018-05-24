<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionListCrudRight extends Model
{
    protected $table = 'question_list_crud_rights';
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
        return $this->belongsTo(User::class, 'usergroupid', 'systemId');
    }
}
