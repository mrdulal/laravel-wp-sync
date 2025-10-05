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
use Illuminate\Database\Eloquent\Relations\MorphTo;

class WpMeta extends Model
{
    protected $table = 'postmeta';
    protected $connection = 'wordpress';
    protected $primaryKey = 'meta_id';
    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'meta_key',
        'meta_value',
    ];

    /**
     * Get the parent model (post, user, comment, or term).
     */
    public function parent(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope to get meta by key.
     */
    public function scopeByKey($query, string $key)
    {
        return $query->where('meta_key', $key);
    }

    /**
     * Scope to get meta by value.
     */
    public function scopeByValue($query, $value)
    {
        return $query->where('meta_value', $value);
    }
}
