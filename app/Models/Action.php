<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Action extends Model
{
    use HasFactory;

    const TYPE_RENT_TO_COMPANY = 1;
    const TYPE_RENT_BACK_FROM_COMPANY_TO_DEPOT = 2;
    const TYPE_RENT_BACK_FROM_COMPANY_TO_MAINTENANCE = 3;
    const TYPE_SEND_TO_MAINTENANCE_FROM_DEPOT = 4;
    const TYPE_MARK_AS_DISABLED = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'description',
    ];

    /**
     * Action has many ProductTransaction
     * @return HasMany
     */
    public function productTransactions(): HasMany
    {
        return $this->hasMany(ProductTransaction::class);
    }
}
