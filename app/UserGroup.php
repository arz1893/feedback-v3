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
}
