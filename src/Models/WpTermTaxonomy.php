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

class WpTermTaxonomy extends Model
{
    protected $table = 'term_taxonomy';
    protected $connection = 'wordpress';
    protected $primaryKey = 'term_taxonomy_id';
    public $timestamps = false;

    protected $fillable = [
        'term_id',
        'taxonomy',
        'description',
        'parent',
        'count',
    ];

    protected $casts = [
        'count' => 'integer',
        'parent' => 'integer',
    ];

    /**
     * Get the term that owns the taxonomy.
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(WpTerm::class, 'term_id', 'term_id');
    }
}
