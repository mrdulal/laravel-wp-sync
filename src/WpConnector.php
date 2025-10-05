<?php

/**
 * Laravel WordPress Connector.
 *
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector;

use MrDulal\WpConnector\Models\WpComment;
use MrDulal\WpConnector\Models\WpOption;
use MrDulal\WpConnector\Models\WpPost;
use MrDulal\WpConnector\Models\WpTerm;
use MrDulal\WpConnector\Models\WpUser;

class WpConnector
{
    /**
     * Get the users query builder.
     */
    public function users()
    {
        return WpUser::query();
    }

    /**
     * Get the posts query builder.
     */
    public function posts()
    {
        return WpPost::query();
    }

    /**
     * Get the comments query builder.
     */
    public function comments()
    {
        return WpComment::query();
    }

    /**
     * Get the terms query builder.
     */
    public function terms()
    {
        return WpTerm::query();
    }

    /**
     * Get the options query builder.
     */
    public function options()
    {
        return WpOption::query();
    }

    /**
     * Get a specific option value.
     */
    public function option(string $name, $default = null)
    {
        return WpOption::get($name, $default);
    }

    /**
     * Set an option value.
     */
    public function setOption(string $name, $value, bool $autoload = true): void
    {
        WpOption::set($name, $value, $autoload);
    }

    /**
     * Get recent posts with author.
     */
    public function recentPosts(int $limit = 5)
    {
        return $this->posts()
            ->published()
            ->with('author')
            ->latest('post_date')
            ->take($limit)
            ->get();
    }

    /**
     * Get posts by category.
     */
    public function postsByCategory(string $category)
    {
        return $this->posts()
            ->published()
            ->whereHas('terms', function ($query) use ($category) {
                $query->where('name', $category)
                    ->whereHas('taxonomy', function ($q) {
                        $q->where('taxonomy', 'category');
                    });
            })
            ->get();
    }

    /**
     * Get posts by tag.
     */
    public function postsByTag(string $tag)
    {
        return $this->posts()
            ->published()
            ->whereHas('terms', function ($query) use ($tag) {
                $query->where('name', $tag)
                    ->whereHas('taxonomy', function ($q) {
                        $q->where('taxonomy', 'post_tag');
                    });
            })
            ->get();
    }

    /**
     * Get user count.
     */
    public function userCount(): int
    {
        return $this->users()->count();
    }

    /**
     * Get comment count.
     */
    public function commentCount(): int
    {
        return $this->comments()->approved()->count();
    }

    /**
     * Get post count.
     */
    public function postCount(): int
    {
        return $this->posts()->published()->count();
    }
}
