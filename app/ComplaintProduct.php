<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintProduct extends Model
{
    protected $table = 'complaint_products';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'customer_rating',
        'customer_complaint',
        'is_need_call',
        'is_urgent',
        'customerId',
        'productId',
        'productCategoryId',
        'tenantId',
        'attachment',
        'is_answered',
        'syscreator',
        'sysupdater'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customerId', 'systemId');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'productId','systemId');
    }

    public function product_category() {
        return $this->belongsTo(ProductCategory::class, 'productCategoryId','id');
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId', 'systemId');
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'syscreator', 'systemId');
    }

    public function complaint_product_replies() {
        return $this->hasMany(ComplaintProductReply::class, 'complaintProductId', 'systemId');
    }
}
