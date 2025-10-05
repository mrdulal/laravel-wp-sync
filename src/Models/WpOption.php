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

class WpOption extends Model
{
    protected $table = 'options';
    protected $connection = 'wordpress';
    protected $primaryKey = 'option_id';
    public $timestamps = false;

    protected $fillable = [
        'option_name',
        'option_value',
        'autoload',
    ];

    protected $casts = [
        'autoload' => 'boolean',
    ];

    /**
     * Get an option value.
     */
    public static function get(string $name, $default = null)
    {
        $option = static::where('option_name', $name)->first();

        return $option ? $option->option_value : $default;
    }

    /**
     * Set an option value.
     */
    public static function set(string $name, $value, bool $autoload = true): void
    {
        static::updateOrCreate(
            ['option_name' => $name],
            [
                'option_value' => $value,
                'autoload' => $autoload ? 'yes' : 'no',
            ]
        );
    }

    /**
     * Delete an option.
     */
    public static function deleteOption(string $name): bool
    {
        return static::where('option_name', $name)->delete() > 0;
    }
}
