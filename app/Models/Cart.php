<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $product_id
 * @property int $user_id
 * @property int|null $qty
 *
 * @package App\Models
 */
class Cart extends Model
{
    protected $table = 'carts';
    public static $snakeAttributes = false;

    protected $casts = [
        'product_id' => 'int',
        'user_id' => 'int',
        'qty' => 'int'
    ];

    protected $fillable = [
        'product_id',
        'user_id',
        'qty'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
