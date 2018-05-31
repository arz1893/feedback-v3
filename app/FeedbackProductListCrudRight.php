<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackProductListCrudRight extends Model
{
    protected $table = 'feedback_product_list_crud_rights';
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
