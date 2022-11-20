<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'inv_id',
        'user_id',
        'user_id',
        'lastName',
        'email',
        'phone',
        'address_1',
        'address_2',
        'country_id',
        'division_id',
        'district_id',
        'zipcode',
        'status',
        'add_info',
        'payment_method',
        'paid_amount',
        'amount',
        'currency',
        'transaction_id',
    ];

}
