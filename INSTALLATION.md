# Installation Guide

## Laravel WordPress Connector

A Laravel package for WordPress database integration with Filament admin management.

### Requirements

- PHP 8.1 or higher
- Laravel 10.0 or higher
- Filament 3.0 or higher
- WordPress database

### Installation

#### 1. Install via Composer

```bash
composer require mrdulal/laravel-wp-connector
```

#### 2. Publish Configuration

```bash
php artisan vendor:publish --tag=wp-connector-config
```

#### 3. Configure Environment Variables

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

#### 4. Configure Database Connection

Update your `config/database.php` to include the WordPress connection:

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

#### 5. Run Migrations (Optional)

If you want to create additional tables for enhanced functionality:

```bash
php artisan migrate
```

#### 6. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### Usage

#### Basic Usage

```php
use MrDulal\WpConnector\Facades\Wp;

// Get recent posts
$posts = Wp::posts()->published()->with('author')->latest()->take(5)->get();

// Get posts by category
$techPosts = Wp::postsByCategory('Technology');

// Get user count
$userCount = Wp::userCount();
```

#### Working with Models

```php
use MrDulal\WpConnector\Models\WpPost;
use MrDulal\WpConnector\Models\WpUser;

// Get a post with relationships
$post = WpPost::with(['author', 'comments', 'terms'])->find(1);

// Get user's posts
$user = WpUser::find(1);
$userPosts = $user->posts()->published()->get();
```

### Filament Admin Panel

The package automatically registers Filament resources for:

- **WordPress Users** - Manage WordPress users
- **WordPress Posts** - Create and edit posts
- **WordPress Comments** - Moderate comments
- **WordPress Terms** - Manage categories and tags

### Dashboard Widgets

The package includes dashboard widgets:

- **Recent Posts Widget** - Shows latest published posts
- **User Count Widget** - Displays user statistics
- **Comment Count Widget** - Shows comment statistics

### Configuration

The package configuration is located in `config/wordpress.php`:

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

### Troubleshooting

#### Common Issues

1. **Database Connection Error**
   - Verify your WordPress database credentials
   - Ensure the database exists and is accessible
   - Check if the WordPress database prefix is correct

2. **Filament Resources Not Showing**
   - Clear application cache: `php artisan cache:clear`
   - Check if Filament is properly installed
   - Verify the service provider is registered

3. **Permission Issues**
   - Ensure your Laravel application has read/write access to the WordPress database
   - Check database user permissions

#### Debug Mode

Enable debug mode in your `.env` file:

```env
APP_DEBUG=true
WP_CONNECTOR_DEBUG=true
```

### Support

- **Documentation**: [GitHub Repository](https://github.com/mrdulal/laravel-wp-connector)
- **Issues**: [GitHub Issues](https://github.com/mrdulal/laravel-wp-connector/issues)
- **Email**: iammrdulal@gmail.com

### License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
