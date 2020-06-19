<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'age', 'weight', 'image', 'blood_group', 'lat', 'long', 'device_id', 'is_donner','is_verified', 'test_positive_date', 'test_negative_date', 'test_negative_date_second', 'last_donation_date'
    ];
}
