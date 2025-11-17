<?php

namespace App\Models;

use App\Models\Service as EloquentService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Installation extends Model
{
    /** @use HasFactory<\Database\Factories\InstallationFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(EloquentService::class);
    }
}
