<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'user_groups';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'name',
        'sysbuiltin',
        'memo',
        'recOwner',
        'syscreator',
        'syslastupdater',
        'sysdeleted'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'recOwner', 'systemId');
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'syscreator', 'systemId');
    }

    public function getMasterDataRight() {
        return $this->hasOne(MasterDataRight::class, 'systemId', 'usergroupid');
    }

    public function getFeedbackCrudRight() {
        return $this->hasOne(FeedbackCrudRight::class, 'systemId', 'usergroupid');
    }

    public function getFeedbackListCrudRight() {
        return $this->hasOne(FeedbackListCrudRight::class, 'systemId', 'usergroupid');
    }

    public function getFaqCrudRight() {
        return $this->hasOne(FaqCrudRight::class, 'systemId', 'usergroupid');
    }

    public function getQuestionCrudRight() {
        return $this->hasOne(QuestionCrudRight::class, 'systemId', 'usergroupid');
    }

    public function getQuestionListCrudRight() {
        return $this->hasOne(QuestionListCrudRight::class, 'systemId', 'usergroupid');
    }
}
