<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'name',
        'address',
        'city',
        'email',
        'gender',
        'phone',
        'birthdate',
        'memo',
        'tenantId'
    ];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId', 'systemId');
    }

    public function complaint_products() {
        return $this->hasMany(ComplaintProduct::class);
    }

    public function feedbackProducts() {
        return $this->hasMany(FeedbackProduct::class);
    }

    public function feedbackProductReplies() {
        return $this->hasMany(FeedbackProductReply::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function getFullInformationAttribute() {
        return "{$this->name} - {$this->phone}";
    }
}
