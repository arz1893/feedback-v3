<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = 'tenants';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'email',
        'name',
        'tenant_categoryId',
        'address',
        'phone',
        'city',
        'country_id',
        'province',
        'img',
        'logo',
        'memo',
        'news',
        'description',
        'syscreator',
        'syslastupdater',
        'sysdeleted'
    ];

    public function currency() {
        return $this->belongsTo(Currency::class, 'country_id');
    }

    public function tenant_category() {
        return $this->belongsTo(TenantCategory::class, 'tenant_categoryId', 'systemId');
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function services() {
        return $this->hasMany(Service::class);
    }

    public function feedback_product() {
        return $this->hasMany(FeedbackProduct::class);
    }

    public function feedback_service() {
        return $this->hasMany(FeedbackService::class);
    }
}
