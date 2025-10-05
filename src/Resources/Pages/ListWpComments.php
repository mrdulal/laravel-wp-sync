<?php

/**
 * Laravel WordPress Connector
 * 
 * @package mrdulal
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector\Resources\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use MrDulal\WpConnector\Resources\WpCommentResource;

class ListWpComments extends ListRecords
{
    protected static string $resource = WpCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
