<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trademark extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'trademarks';
    protected $fillable = [
        'id',
        'name',
        'code'
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
    public function getCacheCategories()
    {
        return Cache::remember('categories', now()
            ->addDay(), function () {
            return $this->all();
        });
    }

    /**
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%$search%")
                ->orWhere('code', 'LIKE', "%$search%");
        }
    }
}
