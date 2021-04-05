<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Box extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discount',
    ];

    /**
     * Products that are in the box.
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Get content attribute.
     *
     * @return array
     */
    public function getContentAttribute(): array
    {
        // Get products belonging to the box
        $products = $this->products()->get(['id', 'name']);

        $products_counts = [];
        $products_names  = [];

        // Get count of every product in the box
        foreach ($products as $product) {
            if (!isset($products_counts[$product->id])) {
                $products_counts[$product->id] = 1;
                $products_names[$product->id]  = $product->name;
            } else {
                $products_counts[$product->id] += 1;
            }
        }

        $content = [];
        foreach ($products_counts as $id => $count) {
            array_push($content, [
                'id'    => $id,
                'name'  => $products_names[$id],
                'count' => $count,
            ]);
        }
        return $content;
    }

    /**
     * Get price attribute.
     *
     * @return float
     */
    public function getPriceAttribute()
    {
        // Get products belonging to the box
        $products = $this->products()->get(['id', 'price']);
        $price    = 0.00;

        foreach ($products as $product) {
            $price += $product->price;
        }
        return round(($price * (100 - $this->discount) / 100), 2);
    }
}
