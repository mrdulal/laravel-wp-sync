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

use Filament\Resources\Pages\CreateRecord;
use MrDulal\WpConnector\Resources\WpPostResource;

class CreateWpPost extends CreateRecord
{
    protected static string $resource = WpPostResource::class;
}
