<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'full_name',
        'status',
        'comment',
        'quantity',
        'total_price',
    ];

    public function products():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
