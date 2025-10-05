<?php

/**
 * Laravel WordPress Connector.
 *
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector\Resources\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use MrDulal\WpConnector\Resources\WpUserResource;

class ListWpUsers extends ListRecords
{
    protected static string $resource = WpUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
