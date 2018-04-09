<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackProduct extends Model
{
    protected $table = 'feedback_products';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'customer_rating',
        'customer_feedback',
        'is_need_call',
        'is_urgent',
        'customerId',
        'productId',
        'productCategoryId',
        'tenantId',
        'is_answered',
        'attachment',
        'syscreator',
        'sysupdater',
        'created_at',
        'updated_at'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customerId', 'systemId');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'productId', 'systemId');
    }

    public function product_category() {
        return $this->belongsTo(ProductCategory::class, 'productCategoryId', 'id');
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId', 'systemId');
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'syscreator', 'systemId');
    }

    public function feedback_product_replies() {
        return $this->hasMany(FeedbackProductReply::class);
    }
}
