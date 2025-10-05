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
use Filament\Resources\Pages\EditRecord;
use MrDulal\WpConnector\Resources\WpCommentResource;

class EditWpComment extends EditRecord
{
    protected static string $resource = WpCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
