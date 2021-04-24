<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'stock',
        'active',
    ];

    /**
     * @return HasMany
     */
    public function imagenes(): HasMany
    {
        return $this->hasMany(Imagen::class, 'product_id');
    }

    /**
     * @param array|null $files
     * @param int $product_id
     */
    public function asignarImagen(?array $files, int $product_id)
    {
        if (!$files) {
            return;
        }
        foreach ($files as $file) {
            $name = $file->getClientOriginalName();
            $file->move(public_path() . '/uploads/', $name);

            $imagen = new Imagen();

            $imagen->name       = $name;
            $imagen->product_id = $product_id;

            $imagen->save();
        }
    }

    /**
     * @return mixed
     */
    public function tieneImagen()
    {
        return $this->imagenes
            ->flatten()
            ->pluck('name')
            ->unique();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * @param $query
     * @param $trademark
     */
    public function scopeTrademark($query, $trademark)
    {
        if (empty($trademark)) {
            return;
        }

        return  $query->whereHas('categories', function ($query) use ($trademark) {
            $query->where('name', $trademark);
        });
    }

    /**
     * @return BelongsToMany
     */
    public function trademarks(): BelongsToMany
    {
        return $this->belongsToMany(Trademark::class);
    }

    /**
     * @param $trademark
     */
    public function asignarTrademark($trademark): void
    {
        $this->trademarks()->sync($trademark, false);
    }

    /**
     * @return mixed
     */
    public function tieneTrademark()
    {
        return $this->trademarks
            ->flatten()
            ->pluck('name')
            ->unique();
    }

    /**
     * @return BelongsToMany
     */
    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class)
            ->withTimestamps();
    }

    /**
     * @param $size
     */
    public function asignarSize($size): void
    {
        $this->sizes()->sync($size, false);
    }

    /**
     * @return mixed
     */
    public function tieneSize()
    {
        return $this->sizes->flatten()
            ->pluck('name')
            ->unique();
    }


    /**
     * @return mixed
     */
    public function getCacheProducts()
    {
        return Cache::remember('products', now()->addDay(), function () {
            return $this->all();
        });
    }
}
