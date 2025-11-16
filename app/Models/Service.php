<?php

namespace App\Models;

use App\Models\Customer as EloquentCustomer;
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
        'customer_id'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(EloquentCustomer::class);
    }
}
