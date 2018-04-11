<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackServiceReply extends Model
{
    protected $table = 'feedback_service_replies';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'reply_content',
        'parentId',
        'customerId',
        'feedbackServiceId',
        'attachment',
        'syscreator',
        'sysupdater'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customerId', 'systemId');
    }

    public function feedback_service() {
        return $this->belongsTo(FeedbackService::class, 'feedbackServiceId', 'systemId');
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'syscreator', 'systemId');
    }
}
