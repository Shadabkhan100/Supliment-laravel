<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    protected $fillable = [
        'user_id',
        'email_type',
        'send_at',
        'is_sent',
        'promo_code',
           
    ];
   public function user()
{
    return $this->belongsTo(User::class);
}
}