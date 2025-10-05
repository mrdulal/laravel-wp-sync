# API Documentation

## Laravel WordPress Connector

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mrdulal/laravel-wp-connector?style=flat-square)](https://packagist.org/packages/mrdulal/laravel-wp-connector)
[![Total Downloads](https://img.shields.io/packagist/dt/mrdulal/laravel-wp-connector?style=flat-square)](https://packagist.org/packages/mrdulal/laravel-wp-connector)
[![License](https://img.shields.io/packagist/l/mrdulal/laravel-wp-connector?style=flat-square)](https://packagist.org/packages/mrdulal/laravel-wp-connector)

Complete API reference for the Laravel WordPress Connector package.

## 📚 Table of Contents

- [Wp Facade](#wp-facade)
- [Models](#models)
- [Relationships](#relationships)
- [Scopes](#scopes)
- [Meta Data](#meta-data)
- [WordPress Options](#wordpress-options)
- [Filament Resources](#filament-resources)
- [Dashboard Widgets](#dashboard-widgets)

## 🔧 Wp Facade

The `Wp` facade provides easy access to WordPress data through a simple interface.

### Basic Query Methods

```php
use MrDulal\WpConnector\Facades\Wp;

// Get query builders
$users = Wp::users();           // Returns WpUser query builder
$posts = Wp::posts();           // Returns WpPost query builder
$comments = Wp::comments();     // Returns WpComment query builder
$terms = Wp::terms();           // Returns WpTerm query builder
$options = Wp::options();       // Returns WpOption query builder
```

### Convenience Methods

```php
// Get recent posts with author
$recentPosts = Wp::recentPosts(5);

// Get posts by category
$categoryPosts = Wp::postsByCategory('Technology');

// Get posts by tag
$tagPosts = Wp::postsByTag('Laravel');

// Get statistics
$userCount = Wp::userCount();
$commentCount = Wp::commentCount();
$postCount = Wp::postCount();
```

### WordPress Options

```php
// Get option value
$siteName = Wp::option('blogname');
$siteDescription = Wp::option('blogdescription');

// Set option value
Wp::setOption('custom_option', 'custom_value', true);
```

## 📦 Models

### WpUser Model

Represents WordPress users with full relationship support.

```php
use MrDulal\WpConnector\Models\WpUser;

// Basic usage
$user = WpUser::find(1);
$user = WpUser::where('user_login', 'admin')->first();

// Relationships
$user->posts;           // HasMany: User's posts
$user->comments;        // HasMany: User's comments
$user->meta;            // HasMany: User meta data

// Scopes
$activeUsers = WpUser::published()->get();
```

#### WpUser Properties

| Property | Type | Description |
|----------|------|-------------|
| `ID` | int | User ID |
| `user_login` | string | Username |
| `user_email` | string | Email address |
| `user_nicename` | string | URL-friendly username |
| `user_url` | string | User website |
| `display_name` | string | Display name |
| `user_registered` | Carbon | Registration date |
| `user_status` | int | User status (0 = active) |

#### WpUser Methods

```php
// Meta data methods
$user->getMeta('first_name');
$user->setMeta('first_name', 'John');
$user->meta; // Get all meta data

// Relationship methods
$user->posts(); // Get user's posts
$user->comments(); // Get user's comments
```

### WpPost Model

Represents WordPress posts with full content management.

```php
use MrDulal\WpConnector\Models\WpPost;

// Basic usage
$post = WpPost::find(1);
$posts = WpPost::published()->get();

// Relationships
$post->author;          // BelongsTo: Post author
$post->comments;        // HasMany: Post comments
$post->terms;           // BelongsToMany: Post terms (categories/tags)
$post->meta;            // HasMany: Post meta data
```

#### WpPost Properties

| Property | Type | Description |
|----------|------|-------------|
| `ID` | int | Post ID |
| `post_title` | string | Post title |
| `post_content` | string | Post content |
| `post_excerpt` | string | Post excerpt |
| `post_status` | string | Post status (publish, draft, etc.) |
| `post_type` | string | Post type (post, page, etc.) |
| `post_author` | int | Author user ID |
| `post_date` | Carbon | Publication date |
| `post_modified` | Carbon | Last modified date |
| `comment_count` | int | Number of comments |

#### WpPost Methods

```php
// Meta data methods
$post->getMeta('_thumbnail_id');
$post->setMeta('custom_field', 'value');
$post->meta; // Get all meta data

// Relationship methods
$post->author(); // Get post author
$post->comments(); // Get post comments
$post->terms(); // Get post terms

// Scopes
$publishedPosts = WpPost::published()->get();
$pages = WpPost::type('page')->get();
$authorPosts = WpPost::byAuthor(1)->get();
```

### WpComment Model

Represents WordPress comments with moderation support.

```php
use MrDulal\WpConnector\Models\WpComment;

// Basic usage
$comment = WpComment::find(1);
$comments = WpComment::approved()->get();

// Relationships
$comment->post;         // BelongsTo: Comment post
$comment->user;         // BelongsTo: Comment user
$comment->parent;       // BelongsTo: Parent comment
$comment->children;     // HasMany: Child comments
$comment->meta;         // HasMany: Comment meta data
```

#### WpComment Properties

| Property | Type | Description |
|----------|------|-------------|
| `comment_ID` | int | Comment ID |
| `comment_post_ID` | int | Post ID |
| `comment_author` | string | Author name |
| `comment_author_email` | string | Author email |
| `comment_content` | string | Comment content |
| `comment_approved` | int | Approval status (0/1) |
| `comment_type` | string | Comment type |
| `user_id` | int | User ID (if logged in) |
| `comment_date` | Carbon | Comment date |

#### WpComment Methods

```php
// Meta data methods
$comment->getMeta('custom_field');
$comment->setMeta('custom_field', 'value');

// Relationship methods
$comment->post(); // Get comment post
$comment->user(); // Get comment user
$comment->parent(); // Get parent comment
$comment->children(); // Get child comments

// Scopes
$approvedComments = WpComment::approved()->get();
$postComments = WpComment::byPost(1)->get();
```

### WpTerm Model

Represents WordPress terms (categories, tags, etc.).

```php
use MrDulal\WpConnector\Models\WpTerm;

// Basic usage
$term = WpTerm::find(1);
$categories = WpTerm::categories()->get();
$tags = WpTerm::tags()->get();

// Relationships
$term->posts;           // BelongsToMany: Term posts
$term->taxonomy;        // HasOne: Term taxonomy
$term->meta;            // HasMany: Term meta data
```

#### WpTerm Properties

| Property | Type | Description |
|----------|------|-------------|
| `term_id` | int | Term ID |
| `name` | string | Term name |
| `slug` | string | Term slug |
| `term_group` | int | Term group |

#### WpTerm Methods

```php
// Meta data methods
$term->getMeta('custom_field');
$term->setMeta('custom_field', 'value');

// Relationship methods
$term->posts(); // Get term posts
$term->taxonomy(); // Get term taxonomy

// Scopes
$categories = WpTerm::categories()->get();
$tags = WpTerm::tags()->get();
```

## 🔗 Relationships

### User Relationships

```php
$user = WpUser::with(['posts', 'comments'])->find(1);

// Get user's posts
$userPosts = $user->posts()->published()->get();

// Get user's comments
$userComments = $user->comments()->approved()->get();
```

### Post Relationships

```php
$post = WpPost::with(['author', 'comments', 'terms'])->find(1);

// Get post author
$author = $post->author;

// Get post comments
$comments = $post->comments()->approved()->get();

// Get post terms
$categories = $post->terms()->categories()->get();
$tags = $post->terms()->tags()->get();
```

### Comment Relationships

```php
$comment = WpComment::with(['post', 'user', 'parent', 'children'])->find(1);

// Get comment post
$post = $comment->post;

// Get comment user
$user = $comment->user;

// Get parent comment
$parent = $comment->parent;

// Get child comments
$children = $comment->children;
```

## 🎯 Scopes

### WpUser Scopes

```php
// Get active users
$activeUsers = WpUser::published()->get();
```

### WpPost Scopes

```php
// Get published posts
$publishedPosts = WpPost::published()->get();

// Get posts by type
$pages = WpPost::type('page')->get();

// Get posts by author
$authorPosts = WpPost::byAuthor(1)->get();
```

### WpComment Scopes

```php
// Get approved comments
$approvedComments = WpComment::approved()->get();

// Get comments by post
$postComments = WpComment::byPost(1)->get();
```

### WpTerm Scopes

```php
// Get categories
$categories = WpTerm::categories()->get();

// Get tags
$tags = WpTerm::tags()->get();
```

## 🏷️ Meta Data

### Post Meta

```php
$post = WpPost::find(1);

// Get meta value
$featuredImage = $post->getMeta('_thumbnail_id');
$customField = $post->getMeta('custom_field', 'default_value');

// Set meta value
$post->setMeta('custom_field', 'custom_value');

// Get all meta data
$metaData = $post->meta;
```

### User Meta

```php
$user = WpUser::find(1);

// Get meta value
$firstName = $user->getMeta('first_name');
$lastName = $user->getMeta('last_name');

// Set meta value
$user->setMeta('first_name', 'John');
$user->setMeta('last_name', 'Doe');
```

### Comment Meta

```php
$comment = WpComment::find(1);

// Get meta value
$customField = $comment->getMeta('custom_field');

// Set meta value
$comment->setMeta('custom_field', 'value');
```

### Term Meta

```php
$term = WpTerm::find(1);

// Get meta value
$customField = $term->getMeta('custom_field');

// Set meta value
$term->setMeta('custom_field', 'value');
```

## ⚙️ WordPress Options

### Get Options

```php
use MrDulal\WpConnector\Facades\Wp;

// Get option value
$siteName = Wp::option('blogname');
$siteDescription = Wp::option('blogdescription');
$adminEmail = Wp::option('admin_email');
```

### Set Options

```php
// Set option value
Wp::setOption('custom_option', 'custom_value');

// Set option with autoload
Wp::setOption('custom_option', 'custom_value', true);
```

### Delete Options

```php
use MrDulal\WpConnector\Models\WpOption;

// Delete option
WpOption::delete('custom_option');
```

## 🎨 Filament Resources

### WpUserResource

Complete CRUD operations for WordPress users.

**Features:**
- User management interface
- Role and permission handling
- User meta data management
- Bulk operations

### WpPostResource

Complete CRUD operations for WordPress posts.

**Features:**
- Rich text editor
- Category and tag management
- Post status management
- Featured image support
- Bulk operations

### WpCommentResource

Comment moderation and management.

**Features:**
- Comment approval workflow
- Comment filtering
- User association
- Bulk operations

### WpTermResource

Category and tag management.

**Features:**
- Category management
- Tag management
- Custom taxonomy support
- Term relationships

## 📊 Dashboard Widgets

### RecentPostsWidget

Shows recent published posts with statistics.

**Features:**
- Latest posts display
- Author information
- Post statistics
- Real-time updates

### UserCountWidget

Displays user statistics and metrics.

**Features:**
- Total user count
- Active user statistics
- Growth metrics
- Real-time updates

### CommentCountWidget

Shows comment statistics and moderation info.

**Features:**
- Total comment count
- Approved comments
- Pending comments
- Real-time updates

## 🔧 Configuration

### Package Configuration

```php
// config/wordpress.php
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

### Environment Variables

```env
WP_CONNECTOR_ENABLED=true
WP_DB_HOST=127.0.0.1
WP_DB_PORT=3306
WP_DB_DATABASE=wordpress
WP_DB_USERNAME=root
WP_DB_PASSWORD=your_password
WP_DB_PREFIX=wp_
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

### Test Examples

```php
// Test facade functionality
$posts = Wp::posts()->published()->get();
$this->assertInstanceOf(Collection::class, $posts);

// Test model relationships
$post = WpPost::with('author')->find(1);
$this->assertInstanceOf(WpUser::class, $post->author);

// Test meta data
$post->setMeta('test_field', 'test_value');
$this->assertEquals('test_value', $post->getMeta('test_field'));
```

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
