<?php

/**
 * Laravel WordPress Connector
 * 
 * @package mrdulal
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector\Tests;

use Orchestra\Testbench\TestCase;
use MrDulal\WpConnector\WpConnectorServiceProvider;
use MrDulal\WpConnector\Facades\Wp;

class WpConnectorTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            WpConnectorServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Wp' => \MrDulal\WpConnector\Facades\Wp::class,
        ];
    }

    public function test_facade_can_be_resolved()
    {
        $this->assertInstanceOf(\MrDulal\WpConnector\WpConnector::class, Wp::getFacadeRoot());
    }

    public function test_can_get_posts_query()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, Wp::posts());
    }

    public function test_can_get_users_query()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, Wp::users());
    }

    public function test_can_get_comments_query()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, Wp::comments());
    }

    public function test_can_get_terms_query()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, Wp::terms());
    }

    public function test_can_get_options_query()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, Wp::options());
    }
}
