<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rate',
        'timestamp',
    ];

    /**
     * Get the currency that owns the ExchangeRate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from() {
        return $this->belongsTo(Currency::class, 'from_currency_id', 'id');
    }

    /**
     * Get the currency that owns the ExchangeRate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to() {
        return $this->belongsTo(Currency::class, 'to_currency_id', 'id');
    }
}
