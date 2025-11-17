<?php

namespace App\Models;

use App\Models\Customer as EloquentCustomer;
use App\Models\State as EloquentState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'state_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(EloquentCustomer::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(EloquentState::class);
    }
}