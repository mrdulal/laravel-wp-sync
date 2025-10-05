<?php

/**
 * Laravel WordPress Connector.
 *
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WpComment extends Model
{
    protected $table = 'comments';
    protected $connection = 'wordpress';
    protected $primaryKey = 'comment_ID';
    public $timestamps = false;

    protected $fillable = [
        'comment_post_ID',
        'comment_author',
        'comment_author_email',
        'comment_author_url',
        'comment_author_IP',
        'comment_date',
        'comment_date_gmt',
        'comment_content',
        'comment_karma',
        'comment_approved',
        'comment_agent',
        'comment_type',
        'comment_parent',
        'user_id',
    ];

    protected $casts = [
        'comment_date' => 'datetime',
        'comment_date_gmt' => 'datetime',
        'comment_karma' => 'integer',
        'comment_approved' => 'boolean',
    ];

    /**
     * Get the post that owns the comment.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(WpPost::class, 'comment_post_ID', 'ID');
    }

    /**
     * Get the user that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(WpUser::class, 'user_id', 'ID');
    }

    /**
     * Get the parent comment.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'comment_parent', 'comment_ID');
    }

    /**
     * Get the child comments.
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'comment_parent', 'comment_ID');
    }

    /**
     * Get the comment meta.
     */
    public function meta()
    {
        return $this->hasMany(WpMeta::class, 'comment_id', 'comment_ID')
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
     * Scope to get approved comments.
     */
    public function scopeApproved($query)
    {
        return $query->where('comment_approved', 1);
    }

    /**
     * Scope to get comments by post.
     */
    public function scopeByPost($query, int $postId)
    {
        return $query->where('comment_post_ID', $postId);
    }
}
