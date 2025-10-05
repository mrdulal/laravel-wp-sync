<?php

/**
 * Laravel WordPress Connector
 * 
 * @package mrdulal
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WpTerm extends Model
{
    protected $table = 'terms';
    protected $connection = 'wordpress';
    protected $primaryKey = 'term_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'term_group',
    ];

    protected $casts = [
        'term_group' => 'integer',
    ];

    /**
     * Get the posts for the term.
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            WpPost::class,
            'term_relationships',
            'term_taxonomy_id',
            'object_id'
        );
    }

    /**
     * Get the term taxonomy.
     */
    public function taxonomy()
    {
        return $this->hasOne(WpTermTaxonomy::class, 'term_id', 'term_id');
    }

    /**
     * Get the term meta.
     */
    public function meta()
    {
        return $this->hasMany(WpMeta::class, 'term_id', 'term_id')
            ->where('meta_key', '!=', '');
    }

    /**
     * Get a specific meta value.
     */
    public function getMeta(string $key, $default = null)
    {
        $meta = $this->meta()->where('meta_key', $key)->first();
        return $meta ? $meta->meta_value : $default;
    }

    /**
     * Set a meta value.
     */
    public function setMeta(string $key, $value): void
    {
        $this->meta()->updateOrCreate(
            ['meta_key' => $key],
            ['meta_value' => $value]
        );
    }

    /**
     * Scope to get categories.
     */
    public function scopeCategories($query)
    {
        return $query->whereHas('taxonomy', function ($q) {
            $q->where('taxonomy', 'category');
        });
    }

    /**
     * Scope to get tags.
     */
    public function scopeTags($query)
    {
        return $query->whereHas('taxonomy', function ($q) {
            $q->where('taxonomy', 'post_tag');
        });
    }
}
