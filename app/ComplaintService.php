<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintService extends Model
{
    protected $table = 'complaint_services';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'customer_rating',
        'customer_complaint',
        'is_need_call',
        'is_urgent',
        'customerId',
        'serviceId',
        'serviceCategoryId',
        'tenantId',
        'attachment',
        'is_answered',
        'syscreator',
        'sysupdater'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customerId', 'systemId');
    }

    public function service() {
        return $this->belongsTo(Service::class, 'serviceId', 'systemId');
    }

    public function service_category() {
        return $this->belongsTo(ServiceCategory::class, 'serviceCategoryId', 'id');
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'syscreator', 'systemId');
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId', 'systemId');
    }

    public function complaint_service_replies() {
        return $this->hasMany(ComplaintServiceReply::class, 'complaintServiceId', 'systemId');
    }
}
