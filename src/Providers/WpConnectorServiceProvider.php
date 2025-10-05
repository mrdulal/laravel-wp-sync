<?php

/**
 * Laravel WordPress Connector
 * 
 * @package mrdulal
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use MrDulal\WpConnector\Models\WpUser;
use MrDulal\WpConnector\Models\WpPost;
use MrDulal\WpConnector\Models\WpComment;
use MrDulal\WpConnector\Models\WpTerm;
use MrDulal\WpConnector\Models\WpOption;
use MrDulal\WpConnector\Models\WpMeta;

class WpConnectorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish config file
        $this->publishes([
            __DIR__ . '/../../config/wordpress.php' => config_path('wordpress.php'),
        ], 'wp-connector-config');

        // Register Filament resources
        $this->app->booted(function () {
            $this->registerFilamentResources();
        });

        // Set up WordPress database connection
        $this->setupWordPressConnection();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/wordpress.php',
            'wordpress'
        );

        // Register the Wp facade
        $this->app->singleton('wp', function ($app) {
            return new \MrDulal\WpConnector\WpConnector();
        });
    }

    protected function registerFilamentResources()
    {
        if (class_exists(\Filament\Filament::class)) {
            \Filament\Filament::serving(function () {
                \Filament\Filament::registerResources([
                    \MrDulal\WpConnector\Resources\WpUserResource::class,
                    \MrDulal\WpConnector\Resources\WpPostResource::class,
                    \MrDulal\WpConnector\Resources\WpCommentResource::class,
                    \MrDulal\WpConnector\Resources\WpTermResource::class,
                ]);

                \Filament\Filament::registerWidgets([
                    \MrDulal\WpConnector\Widgets\RecentPostsWidget::class,
                    \MrDulal\WpConnector\Widgets\UserCountWidget::class,
                    \MrDulal\WpConnector\Widgets\CommentCountWidget::class,
                ]);
            });
        }
    }

    protected function setupWordPressConnection()
    {
        $config = config('wordpress');
        
        if ($config['enabled']) {
            config([
                'database.connections.wordpress' => [
                    'driver' => 'mysql',
                    'host' => $config['host'],
                    'port' => $config['port'],
                    'database' => $config['database'],
                    'username' => $config['username'],
                    'password' => $config['password'],
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => $config['prefix'],
                    'strict' => false,
                    'engine' => null,
                ]
            ]);

            // Set default connection for WordPress models
            WpUser::setConnection('wordpress');
            WpPost::setConnection('wordpress');
            WpComment::setConnection('wordpress');
            WpTerm::setConnection('wordpress');
            WpOption::setConnection('wordpress');
            WpMeta::setConnection('wordpress');
        }
    }
}
