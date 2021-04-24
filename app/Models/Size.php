<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class Size extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'sizes';

    protected $fillable = [
        'id',
        'name',
    ];
    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany('App\Entities\Product')
            ->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function getCacheSizes()
    {
        return Cache::remember('sizes', now()->addDay(), function () {
            return $this->all();
        });
    }
}
