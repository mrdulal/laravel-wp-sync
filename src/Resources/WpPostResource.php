<?php

/**
 * Laravel WordPress Connector.
 *
 * @author Sanjaya Dulal <iammrdulal@gmail.com>
 * @copyright 2024 Sanjaya Dulal
 * @license MIT
 */

namespace MrDulal\WpConnector\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use YourName\WpConnector\Models\WpPost;

class WpPostResource extends Resource
{
    protected static ?string $model = WpPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'WordPress';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('post_title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('post_content')
                    ->rows(10)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('post_excerpt')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\Select::make('post_author')
                    ->relationship('author', 'display_name')
                    ->required(),
                Forms\Components\Select::make('post_status')
                    ->options([
                        'publish' => 'Published',
                        'draft' => 'Draft',
                        'private' => 'Private',
                        'pending' => 'Pending',
                    ])
                    ->required()
                    ->default('draft'),
                Forms\Components\Select::make('post_type')
                    ->options([
                        'post' => 'Post',
                        'page' => 'Page',
                        'attachment' => 'Attachment',
                    ])
                    ->required()
                    ->default('post'),
                Forms\Components\TextInput::make('post_name')
                    ->maxLength(200),
                Forms\Components\DateTimePicker::make('post_date')
                    ->default(now()),
                Forms\Components\Select::make('comment_status')
                    ->options([
                        'open' => 'Open',
                        'closed' => 'Closed',
                    ])
                    ->default('open'),
                Forms\Components\Select::make('ping_status')
                    ->options([
                        'open' => 'Open',
                        'closed' => 'Closed',
                    ])
                    ->default('open'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('post_title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('author.display_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('post_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'publish' => 'success',
                        'draft' => 'warning',
                        'private' => 'danger',
                        'pending' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('post_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'post' => 'success',
                        'page' => 'info',
                        'attachment' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('post_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment_count')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('post_status')
                    ->options([
                        'publish' => 'Published',
                        'draft' => 'Draft',
                        'private' => 'Private',
                        'pending' => 'Pending',
                    ]),
                Tables\Filters\SelectFilter::make('post_type')
                    ->options([
                        'post' => 'Post',
                        'page' => 'Page',
                        'attachment' => 'Attachment',
                    ]),
                Tables\Filters\Filter::make('published')
                    ->query(fn ($query) => $query->where('post_status', 'publish')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('post_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWpPosts::route('/'),
            'create' => Pages\CreateWpPost::route('/create'),
            'edit' => Pages\EditWpPost::route('/{record}/edit'),
        ];
    }
}
