<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackService extends Model
{
    protected $table = 'feedback_services';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'customer_rating',
        'customer_feedback',
        'is_need_call',
        'is_urgent',
        'customerId',
        'serviceId',
        'serviceCategoryId',
        'tenantId',
        'is_answered',
        'attachment',
        'syscreator',
        'sysupdater',
        'created_at',
        'updated_at'
    ];

    public function service() {
        return $this->belongsTo(Service::class, 'serviceId', 'systemId');
    }

    public function service_category() {
        return $this->belongsTo(ServiceCategory::class, 'serviceCategoryId', 'id');
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId', 'systemId');
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'syscreator', 'systemId');
    }
}
