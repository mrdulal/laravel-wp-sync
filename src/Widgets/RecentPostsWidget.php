<?php

/**
 * Laravel WordPress Connector
 * 
 * @package mrdulal
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use MrDulal\WpConnector\Facades\Wp;

class RecentPostsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $recentPosts = Wp::recentPosts(5);
        $totalPosts = Wp::postCount();

        return [
            Stat::make('Total Posts', $totalPosts)
                ->description('All published posts')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Recent Posts', $recentPosts->count())
                ->description('Last 5 published posts')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),

            Stat::make('Latest Post', $recentPosts->first()?->post_title ?? 'No posts')
                ->description($recentPosts->first()?->post_date?->diffForHumans() ?? '')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('warning'),
        ];
    }
}
