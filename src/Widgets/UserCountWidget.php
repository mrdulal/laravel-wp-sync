<?php

/**
 * Laravel WordPress Connector.
 *
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use MrDulal\WpConnector\Facades\Wp;

class UserCountWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $userCount = Wp::userCount();

        return [
            Stat::make('Total Users', $userCount)
                ->description('WordPress users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Active Users', $userCount)
                ->description('Users with active status')
                ->descriptionIcon('heroicon-m-user-check')
                ->color('info'),

            Stat::make('Growth', '+0%')
                ->description('Since last month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }
}
