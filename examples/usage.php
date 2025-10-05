<?php

/**
 * Laravel WordPress Connector
 * 
 * @package mrdulal
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 * 
 * Example Usage
 * 
 * This file demonstrates how to use the Laravel WordPress Connector package.
 */

use MrDulal\WpConnector\Facades\Wp;
use MrDulal\WpConnector\Models\WpPost;
use MrDulal\WpConnector\Models\WpUser;
use MrDulal\WpConnector\Models\WpComment;

// Example 1: Get recent published posts with authors
$recentPosts = Wp::posts()->published()->with('author')->latest()->take(5)->get();

// Example 2: Get posts by category
$techPosts = Wp::postsByCategory('Technology');

// Example 3: Get posts by tag
$laravelPosts = Wp::postsByTag('Laravel');

// Example 4: Get user statistics
$userCount = Wp::userCount();
$commentCount = Wp::commentCount();
$postCount = Wp::postCount();

// Example 5: Working with a specific post
$post = WpPost::with(['author', 'comments', 'terms'])->find(1);

// Get post meta
$featuredImage = $post->getMeta('_thumbnail_id');
$customField = $post->getMeta('custom_field', 'default_value');

// Set post meta
$post->setMeta('custom_field', 'custom_value');

// Example 6: Working with users
$user = WpUser::find(1);
$userPosts = $user->posts()->published()->get();

// Get user meta
$firstName = $user->getMeta('first_name');
$lastName = $user->getMeta('last_name');

// Example 7: Working with comments
$comments = WpComment::with(['post', 'user'])->approved()->get();

// Example 8: Get WordPress options
$siteName = Wp::option('blogname');
$siteDescription = Wp::option('blogdescription');

// Set WordPress options
Wp::setOption('custom_option', 'custom_value');

// Example 9: Complex queries
$featuredPosts = Wp::posts()
    ->whereHas('meta', function ($query) {
        $query->where('meta_key', 'featured')
              ->where('meta_value', '1');
    })
    ->published()
    ->get();

// Example 10: Get posts with specific relationships
$postsWithDetails = Wp::posts()
    ->with(['author.meta', 'comments.user', 'terms.taxonomy'])
    ->published()
    ->get();

// Example 11: Filter posts by author
$authorPosts = Wp::posts()->byAuthor(1)->published()->get();

// Example 12: Get posts by type
$pages = Wp::posts()->type('page')->published()->get();

// Example 13: Get categories and tags
$categories = Wp::terms()->categories()->get();
$tags = Wp::terms()->tags()->get();

// Example 14: Get recent posts with pagination
$recentPosts = Wp::posts()
    ->published()
    ->with('author')
    ->latest('post_date')
    ->paginate(10);

// Example 15: Search posts
$searchResults = Wp::posts()
    ->where('post_title', 'like', '%Laravel%')
    ->orWhere('post_content', 'like', '%Laravel%')
    ->published()
    ->get();

echo "Laravel WordPress Connector Examples\n";
echo "====================================\n\n";

echo "Recent Posts Count: " . $recentPosts->count() . "\n";
echo "User Count: " . $userCount . "\n";
echo "Comment Count: " . $commentCount . "\n";
echo "Post Count: " . $postCount . "\n";
echo "Site Name: " . $siteName . "\n";
echo "Site Description: " . $siteDescription . "\n";
