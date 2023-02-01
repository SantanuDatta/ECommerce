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
        'total_quantity',
        'paid_amount',
        'amount',
        'currency',
        'transaction_id',
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function division(){
        return $this->belongsTo(Division::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
