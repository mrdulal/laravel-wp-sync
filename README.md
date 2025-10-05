<!--
Laravel WordPress Connector

@package mrdulal
@author Sanjaya Dulal <iammrdulal@gmail.com>
@copyright 2024 Sanjaya Dulal
@license MIT
-->

# Laravel WordPress Connector

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mrdulal/laravel-wp-connector?style=flat-square)](https://packagist.org/packages/mrdulal/laravel-wp-connector)
[![Total Downloads](https://img.shields.io/packagist/dt/mrdulal/laravel-wp-connector?style=flat-square)](https://packagist.org/packages/mrdulal/laravel-wp-connector)
[![License](https://img.shields.io/packagist/l/mrdulal/laravel-wp-connector?style=flat-square)](https://packagist.org/packages/mrdulal/laravel-wp-connector)
[![PHP Version](https://img.shields.io/packagist/php-v/mrdulal/laravel-wp-connector?style=flat-square)](https://packagist.org/packages/mrdulal/laravel-wp-connector)
[![Laravel Version](https://img.shields.io/badge/Laravel-10.0%2B-red?style=flat-square)](https://laravel.com)
[![Filament Version](https://img.shields.io/badge/Filament-3.0%2B-blue?style=flat-square)](https://filamentphp.com)
[![Build Status](https://img.shields.io/github/actions/workflow/status/mrdulal/laravel-wp-connector/ci.yml?branch=main&style=flat-square)](https://github.com/mrdulal/laravel-wp-connector/actions)
[![Code Coverage](https://img.shields.io/codecov/c/github/mrdulal/laravel-wp-connector?style=flat-square)](https://codecov.io/gh/mrdulal/laravel-wp-connector)
[![Code Quality](https://img.shields.io/badge/code%20style-PSR--12-green?style=flat-square)](https://www.php-fig.org/psr/psr-12/)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%208-brightgreen?style=flat-square)](https://phpstan.org)

A comprehensive Laravel package that seamlessly integrates WordPress database functionality into Laravel applications with full Filament admin panel support.

## Features

- 🔗 **WordPress Database Integration**: Connect to WordPress database with Eloquent models
- 🎨 **Filament Admin Panel**: Complete admin interface for managing WordPress content
- 📊 **Dashboard Widgets**: Real-time statistics and recent content widgets
- 🔍 **Advanced Queries**: Easy-to-use facade for complex WordPress queries
- 🏷️ **Relationships**: Full relationship mapping between WordPress entities
- ⚙️ **Configurable**: Publishable config with database connection options

## Installation

1. Install the package via Composer:

```bash
composer require mrdulal/laravel-wp-connector
```

2. Publish the configuration file:

```bash
php artisan vendor:publish --tag=wp-connector-config
```

3. Configure your WordPress database connection in `config/wordpress.php`:

```php
return [
    'enabled' => true,
    'host' => env('WP_DB_HOST', '127.0.0.1'),
    'port' => env('WP_DB_PORT', '3306'),
    'database' => env('WP_DB_DATABASE', 'wordpress'),
    'username' => env('WP_DB_USERNAME', 'root'),
    'password' => env('WP_DB_PASSWORD', ''),
    'prefix' => env('WP_DB_PREFIX', 'wp_'),
];
```

4. Add your WordPress database credentials to your `.env` file:

```env
WP_CONNECTOR_ENABLED=true
WP_DB_HOST=127.0.0.1
WP_DB_PORT=3306
WP_DB_DATABASE=wordpress
WP_DB_USERNAME=root
WP_DB_PASSWORD=your_password
WP_DB_PREFIX=wp_
```

## Usage

### Basic Queries

```php
use MrDulal\WpConnector\Facades\Wp;

// Get recent published posts with authors
$posts = Wp::posts()->published()->with('author')->latest()->take(5)->get();

// Get posts by category
$categoryPosts = Wp::postsByCategory('Technology');

// Get posts by tag
$tagPosts = Wp::postsByTag('Laravel');

// Get user count
$userCount = Wp::userCount();

// Get comment count
$commentCount = Wp::commentCount();
```

### Working with Models

```php
use MrDulal\WpConnector\Models\WpPost;
use MrDulal\WpConnector\Models\WpUser;
use MrDulal\WpConnector\Models\WpComment;

// Get a post with its author and comments
$post = WpPost::with(['author', 'comments'])->find(1);

// Get user's posts
$user = WpUser::find(1);
$userPosts = $user->posts()->published()->get();

// Get post comments
$post = WpPost::find(1);
$comments = $post->comments()->approved()->get();

// Get post terms (categories/tags)
$post = WpPost::find(1);
$categories = $post->terms()->categories()->get();
$tags = $post->terms()->tags()->get();
```

### Meta Data

```php
// Get post meta
$post = WpPost::find(1);
$featuredImage = $post->getMeta('_thumbnail_id');
$customField = $post->getMeta('custom_field', 'default_value');

// Set post meta
$post->setMeta('custom_field', 'custom_value');

// Get user meta
$user = WpUser::find(1);
$firstName = $user->getMeta('first_name');
$lastName = $user->getMeta('last_name');
```

### WordPress Options

```php
use MrDulal\WpConnector\Facades\Wp;

// Get WordPress options
$siteName = Wp::option('blogname');
$siteDescription = Wp::option('blogdescription');

// Set WordPress options
Wp::setOption('custom_option', 'custom_value');
```

## Filament Admin Panel

The package includes complete Filament resources for managing WordPress content:

- **Users**: Manage WordPress users with full CRUD operations
- **Posts**: Create, edit, and manage WordPress posts and pages
- **Comments**: Moderate and manage comments
- **Terms**: Manage categories, tags, and custom taxonomies

### Dashboard Widgets

- **Recent Posts Widget**: Shows latest published posts
- **User Count Widget**: Displays user statistics
- **Comment Count Widget**: Shows comment statistics

## Configuration

### Database Connection

The package automatically sets up a WordPress database connection. You can customize the connection settings in the config file.

### Filament Configuration

```php
'filament' => [
    'navigation_group' => 'WordPress',
    'navigation_sort' => 1,
    'enable_widgets' => true,
],
```

## Models

### WpUser
- Primary key: `ID`
- Relationships: `posts()`, `comments()`, `meta()`
- Scopes: `published()`

### WpPost
- Primary key: `ID`
- Relationships: `author()`, `comments()`, `terms()`, `meta()`
- Scopes: `published()`, `type()`, `byAuthor()`

### WpComment
- Primary key: `comment_ID`
- Relationships: `post()`, `user()`, `parent()`, `children()`, `meta()`
- Scopes: `approved()`, `byPost()`

### WpTerm
- Primary key: `term_id`
- Relationships: `posts()`, `taxonomy()`, `meta()`
- Scopes: `categories()`, `tags()`

## Advanced Usage

### Custom Queries

```php
// Get posts with specific meta
$posts = Wp::posts()
    ->whereHas('meta', function ($query) {
        $query->where('meta_key', 'featured')
              ->where('meta_value', '1');
    })
    ->published()
    ->get();

// Get users with specific capabilities
$admins = Wp::users()
    ->whereHas('meta', function ($query) {
        $query->where('meta_key', 'wp_capabilities')
              ->where('meta_value', 'like', '%administrator%');
    })
    ->get();
```

### Relationship Loading

```php
// Eager load relationships
$posts = Wp::posts()
    ->with(['author', 'comments', 'terms'])
    ->published()
    ->get();

// Load specific relationships
$post = WpPost::with(['author.meta', 'comments.user'])->find(1);
```

## Requirements

- PHP 8.1+
- Laravel 10.0+
- Filament 3.0+
- WordPress database

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Sanjaya Dulal](https://github.com/mrdulal)
- [All Contributors](../../contributors)
