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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WpPost extends Model
{
    protected $table = 'posts';
    protected $connection = 'wordpress';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'post_author',
        'post_date',
        'post_date_gmt',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'comment_status',
        'ping_status',
        'post_password',
        'post_name',
        'to_ping',
        'pinged',
        'post_modified',
        'post_modified_gmt',
        'post_content_filtered',
        'post_parent',
        'guid',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count',
    ];

    protected $casts = [
        'post_date' => 'datetime',
        'post_date_gmt' => 'datetime',
        'post_modified' => 'datetime',
        'post_modified_gmt' => 'datetime',
        'comment_count' => 'integer',
        'menu_order' => 'integer',
    ];

    /**
     * Get the author of the post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(WpUser::class, 'post_author', 'ID');
    }

    /**
     * Get the comments for the post.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(WpComment::class, 'comment_post_ID', 'ID');
    }

    /**
     * Get the terms (categories/tags) for the post.
     */
    public function terms(): BelongsToMany
    {
        return $this->belongsToMany(
            WpTerm::class,
            'term_relationships',
            'object_id',
            'term_taxonomy_id'
        );
    }

    /**
     * Get the post meta.
     */
    public function meta()
    {
        return $this->hasMany(WpMeta::class, 'post_id', 'ID')
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
     * Scope to get published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('post_status', 'publish');
    }

    /**
     * Scope to get posts by type.
     */
    public function scopeType($query, string $type)
    {
        return $query->where('post_type', $type);
    }

    /**
     * Scope to get posts by author.
     */
    public function scopeByAuthor($query, int $authorId)
    {
        return $query->where('post_author', $authorId);
    }
}
