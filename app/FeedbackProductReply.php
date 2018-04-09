<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackProductReply extends Model
{
    protected $table = 'feedback_product_replies';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'reply_content',
        'parentId',
        'customerId',
        'feedbackProductId',
        'attachment',
        'syscreator',
        'sysupdater'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customerId', 'systemId');
    }

    public function feedback_product() {
        return $this->belongsTo(FeedbackProduct::class, 'feedbackProductId', 'systemId');
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'syscreator', 'systemId');
    }
}
