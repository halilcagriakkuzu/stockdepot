<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_number',
        'make',
        'model',
        'shelf_no',
        'row_no',
        'count',
        'unavailable_count',
        'description',
        'buy_price',
        'buy_date',
        'is_active',
    ];

    /**
     * Product belongs to one category
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Product has many ProductTransaction
     * @return HasMany
     */
    public function productTransactions(): HasMany
    {
        return $this->hasMany(ProductTransaction::class);
    }
}
