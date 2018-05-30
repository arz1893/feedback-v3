<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportViewRights extends Model
{
    protected $table = 'report_view_rights';
    protected $primaryKey = 'usergroupid';
    public $incrementing = false;

    protected $fillable = [
        'usergroupid', 'view', 'action'
    ];

    public function getUserGroup() {
        return $this->belongsTo(UserGroup::class, 'usergroupid', 'systemId');
    }
}
