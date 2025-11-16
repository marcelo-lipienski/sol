<?php

namespace App\Models;

use App\Models\Service as EloquentService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'name',
        'phone_number',
        'document'
    ];

    public function services(): HasMany
    {
        return $this->hasMany(EloquentService::class);
    }
}
