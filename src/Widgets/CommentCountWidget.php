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

class CommentCountWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $commentCount = Wp::commentCount();

        return [
            Stat::make('Total Comments', $commentCount)
                ->description('All approved comments')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('success'),

            Stat::make('Approved Comments', $commentCount)
                ->description('Comments approved')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),

            Stat::make('Pending Comments', 0)
                ->description('Awaiting approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
