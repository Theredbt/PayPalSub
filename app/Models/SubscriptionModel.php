<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionModel extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'plan_id',
        'plan_name',
        'plan_description',
        'status',
        'status_update_time',
        'subscription_id',
        'start_time',
        'billing_info'
    ];

    protected $casts = [
        'start_time' => 'datetime:Y-m-d',
        'status_update_time' => 'datetime:Y-m-d',
        'billing_info' => 'json',
        'next_billing_time' => 'datetime'
    ];

    public function get_next_billing_time()
    {
        return date('Y-m-d', strtotime($this->billing_info['next_billing_time']));
    }
}
