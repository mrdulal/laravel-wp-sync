<?php

/**
 * Laravel WordPress Connector.
 *
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Database\Eloquent\Builder users()
 * @method static \Illuminate\Database\Eloquent\Builder posts()
 * @method static \Illuminate\Database\Eloquent\Builder comments()
 * @method static \Illuminate\Database\Eloquent\Builder terms()
 * @method static \Illuminate\Database\Eloquent\Builder options()
 * @method static mixed option(string $name, $default = null)
 * @method static void setOption(string $name, $value, bool $autoload = true)
 * @method static \Illuminate\Database\Eloquent\Collection recentPosts(int $limit = 5)
 * @method static \Illuminate\Database\Eloquent\Collection postsByCategory(string $category)
 * @method static \Illuminate\Database\Eloquent\Collection postsByTag(string $tag)
 * @method static int userCount()
 * @method static int commentCount()
 * @method static int postCount()
 */
class Wp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'wp';
    }
}
