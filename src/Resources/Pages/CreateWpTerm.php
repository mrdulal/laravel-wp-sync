<?php

/**
 * Laravel WordPress Connector.
 *
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector\Resources\Pages;

use Filament\Resources\Pages\CreateRecord;
use MrDulal\WpConnector\Resources\WpTermResource;

class CreateWpTerm extends CreateRecord
{
    protected static string $resource = WpTermResource::class;
}
