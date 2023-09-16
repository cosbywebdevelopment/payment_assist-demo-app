<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Customer
 *
 * @property int $id
 * @property string $firstname
 * @property string $surname
 * @property string $address1
 * @property string|null $address2
 * @property string $city
 * @property string $postcode
 * @property string $mobile
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $token
 * @property int|null $status
 * @property string|null $email
 * @property int $order_id
 * @property string $county
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereToken($value)
 */
class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'surname', 'address1', 'address2', 'city', 'postcode', 'mobile', 'token', 'status', 'email', 'county'
    ];

    /**
     * @var array
     */
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
