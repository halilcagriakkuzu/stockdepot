<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentForm extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'interlocutor_name',
        'interlocutor_email',
        'interlocutor_phone',
        'price',
        'currency',
        'rent_form_status_id',
        'company_id',
        'created_by',
        'updated_by',
    ];

    /**
     * RentForm belongs to one company
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

    /**
     * RentForm belongs to one rent form status
     * @return BelongsTo
     */
    public function rentFormStatus(): BelongsTo
    {
        return $this->belongsTo(RentFormStatus::class);
    }

    /**
     * RentForm has many ProductTransaction
     * @return HasMany
     */
    public function productTransactions(): HasMany
    {
        return $this->hasMany(ProductTransaction::class);
    }

    /**
     * RentForm has many rentFormProducts
     * @return HasMany
     */
    public function rentFormProducts(): HasMany
    {
        return $this->hasMany(RentFormProduct::class)->withTrashed();
    }

    /**
     * RentForm belongs to one created user
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    /**
     * RentForm belongs to one updated user
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by')->withTrashed();
    }
}
