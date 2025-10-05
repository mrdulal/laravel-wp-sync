# Installation Guide

## Laravel WordPress Connector

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mrdulal/laravel-wp-connector?style=flat-square)](https://packagist.org/packages/mrdulal/laravel-wp-connector)
[![Total Downloads](https://img.shields.io/packagist/dt/mrdulal/laravel-wp-connector?style=flat-square)](https://packagist.org/packages/mrdulal/laravel-wp-connector)
[![License](https://img.shields.io/packagist/l/mrdulal/laravel-wp-connector?style=flat-square)](https://packagist.org/packages/mrdulal/laravel-wp-connector)

A comprehensive Laravel package that seamlessly integrates WordPress database functionality into Laravel applications with full Filament admin panel support.

## 📋 Requirements

- **PHP**: 8.1 or higher
- **Laravel**: 10.0 or higher  
- **Filament**: 3.0 or higher
- **WordPress Database**: Access to WordPress database
- **Composer**: For package management

## 🚀 Quick Installation

### Step 1: Install the Package

```bash
composer require mrdulal/laravel-wp-connector
```

### Step 2: Publish Configuration

```bash
php artisan vendor:publish --tag=wp-connector-config
```

### Step 3: Configure Environment Variables

Add the following to your `.env` file:

```env
# WordPress Database Configuration
WP_CONNECTOR_ENABLED=true
WP_DB_HOST=127.0.0.1
WP_DB_PORT=3306
WP_DB_DATABASE=wordpress
WP_DB_USERNAME=root
WP_DB_PASSWORD=your_password
WP_DB_PREFIX=wp_
```

### Step 4: Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## 🔧 Detailed Configuration

### Database Connection Setup

The package automatically configures a WordPress database connection. You can customize it in `config/wordpress.php`:

```php
return [
    'enabled' => env('WP_CONNECTOR_ENABLED', true),
    'host' => env('WP_DB_HOST', '127.0.0.1'),
    'port' => env('WP_DB_PORT', '3306'),
    'database' => env('WP_DB_DATABASE', 'wordpress'),
    'username' => env('WP_DB_USERNAME', 'root'),
    'password' => env('WP_DB_PASSWORD', ''),
    'prefix' => env('WP_DB_PREFIX', 'wp_'),
    
    'filament' => [
        'navigation_group' => 'WordPress',
        'navigation_sort' => 1,
        'enable_widgets' => true,
    ],
];
```

### Manual Database Configuration

If you prefer to configure the database connection manually, add this to your `config/database.php`:

```php
'connections' => [
    // ... your existing connections
    
    'wordpress' => [
        'driver' => 'mysql',
        'host' => env('WP_DB_HOST', '127.0.0.1'),
        'port' => env('WP_DB_PORT', '3306'),
        'database' => env('WP_DB_DATABASE', 'wordpress'),
        'username' => env('WP_DB_USERNAME', 'root'),
        'password' => env('WP_DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => env('WP_DB_PREFIX', 'wp_'),
        'strict' => false,
        'engine' => null,
    ],
],
```

## 🎯 Usage Examples

### Basic Usage

```php
use MrDulal\WpConnector\Facades\Wp;

// Get recent posts with authors
$posts = Wp::posts()->published()->with('author')->latest()->take(5)->get();

// Get posts by category
$techPosts = Wp::postsByCategory('Technology');

// Get posts by tag
$laravelPosts = Wp::postsByTag('Laravel');

// Get user statistics
$userCount = Wp::userCount();
$commentCount = Wp::commentCount();
$postCount = Wp::postCount();
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

### Meta Data Management

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

// Set user meta
$user->setMeta('first_name', 'John');
$user->setMeta('last_name', 'Doe');
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

## 🎨 Filament Admin Panel

The package automatically provides Filament resources for:

### WordPress Users
- Complete CRUD operations
- User management interface
- Role and permission handling
- User meta data management

### WordPress Posts
- Create and edit posts
- Rich text editor
- Category and tag management
- Post status management
- Featured image support

### WordPress Comments
- Comment moderation
- Approval workflow
- Comment filtering
- User association

### WordPress Terms
- Category management
- Tag management
- Custom taxonomy support
- Term relationships

## 📊 Dashboard Widgets

The package includes several dashboard widgets:

### Recent Posts Widget
- Shows latest published posts
- Author information
- Post statistics

### User Count Widget
- Total user count
- Active user statistics
- Growth metrics

### Comment Count Widget
- Total comment count
- Approved comments
- Pending comments

## 🔍 Advanced Queries

### Complex Queries

```php
// Get posts with specific meta
$featuredPosts = Wp::posts()
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

// Get posts with relationships
$postsWithDetails = Wp::posts()
    ->with(['author.meta', 'comments.user', 'terms.taxonomy'])
    ->published()
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

## 🛠️ Troubleshooting

### Common Issues

#### Database Connection Error
- Verify your WordPress database credentials
- Ensure the database exists and is accessible
- Check if the WordPress database prefix is correct

#### Filament Resources Not Showing
- Clear application cache: `php artisan cache:clear`
- Check if Filament is properly installed
- Verify the service provider is registered

#### Permission Issues
- Ensure your Laravel application has read/write access to the WordPress database
- Check database user permissions

### Debug Mode

Enable debug mode in your `.env` file:

```env
APP_DEBUG=true
WP_CONNECTOR_DEBUG=true
```

### Logging

The package logs important events. Check your Laravel logs:

```bash
tail -f storage/logs/laravel.log
```

## 🧪 Testing

### Run Tests

```bash
# Run all tests
composer test

# Run tests with coverage
composer test-coverage

# Run code quality checks
composer quality
```

### Test Configuration

The package includes comprehensive tests for:
- Model relationships
- Facade functionality
- Service provider registration
- Configuration loading

## 📚 Additional Resources

- **Documentation**: [GitHub Repository](https://github.com/mrdulal/laravel-wp-connector)
- **Issues**: [GitHub Issues](https://github.com/mrdulal/laravel-wp-connector/issues)
- **Changelog**: [CHANGELOG.md](https://github.com/mrdulal/laravel-wp-connector/blob/main/CHANGELOG.md)
- **Contributing**: [CONTRIBUTING.md](https://github.com/mrdulal/laravel-wp-connector/blob/main/CONTRIBUTING.md)

## 🆘 Support

- **Email**: iammrdulal@gmail.com
- **GitHub Issues**: [Report bugs and request features](https://github.com/mrdulal/laravel-wp-connector/issues)
- **Documentation**: [Complete documentation](https://github.com/mrdulal/laravel-wp-connector#readme)

## 📄 License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Made with ❤️ by [Sanjaya Dulal](https://github.com/mrdulal)**
