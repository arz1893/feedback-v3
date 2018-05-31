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

    public function getMasterDataRights() {
        return $this->hasOne(MasterDataRight::class, 'usergroupid', 'systemId');
    }

    public function getFeedbackProductCrudRights() {
        return $this->hasOne(FeedbackProductCrudRight::class, 'usergroupid', 'systemId');
    }

    public function getFeedbackProductListCrudRights() {
        return $this->hasOne(FeedbackProductListCrudRight::class, 'usergroupid', 'systemId');
    }

    public function getFeedbackServiceCrudRights() {
        return $this->hasOne(FeedbackServiceCrudRight::class, 'usergroupid', 'systemId');
    }

    public function getFeedbackServiceListCrudRights() {
        return $this->hasOne(FeedbackServiceListCrudRight::class, 'usergroupid', 'systemId');
    }

    public function getFaqCrudRights() {
        return $this->hasOne(FaqCrudRight::class, 'usergroupid', 'systemId');
    }

    public function getQuestionCrudRights() {
        return $this->hasOne(QuestionCrudRight::class, 'usergroupid', 'systemId');
    }

    public function getQuestionListCrudRights() {
        return $this->hasOne(QuestionListCrudRight::class, 'usergroupid', 'systemId');
    }

    public function getCustomerCrudRights() {
        return $this->hasOne(CustomerCrudRight::class, 'usergroupid', 'systemId');
    }

    public function getReportViewRights() {
        return $this->hasOne(ReportViewRights::class, 'usergroupid', 'systemId');
    }
}
