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
use YourName\WpConnector\Models\WpComment;

class WpCommentResource extends Resource
{
    protected static ?string $model = WpComment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'WordPress';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('comment_post_ID')
                    ->relationship('post', 'post_title')
                    ->required(),
                Forms\Components\TextInput::make('comment_author')
                    ->maxLength(245),
                Forms\Components\TextInput::make('comment_author_email')
                    ->email()
                    ->maxLength(100),
                Forms\Components\TextInput::make('comment_author_url')
                    ->url()
                    ->maxLength(200),
                Forms\Components\Textarea::make('comment_content')
                    ->rows(5)
                    ->columnSpanFull(),
                Forms\Components\Select::make('comment_approved')
                    ->options([
                        0 => 'Pending',
                        1 => 'Approved',
                    ])
                    ->required()
                    ->default(0),
                Forms\Components\Select::make('comment_type')
                    ->options([
                        'comment' => 'Comment',
                        'pingback' => 'Pingback',
                        'trackback' => 'Trackback',
                    ])
                    ->default('comment'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'display_name')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('comment_date')
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('comment_ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('post.post_title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('comment_author')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment_content')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('comment_approved')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        '1' => 'Approved',
                        '0' => 'Pending',
                        default => 'Unknown',
                    }),
                Tables\Columns\TextColumn::make('comment_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'comment' => 'success',
                        'pingback' => 'info',
                        'trackback' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('comment_date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('comment_approved')
                    ->options([
                        '1' => 'Approved',
                        '0' => 'Pending',
                    ]),
                Tables\Filters\SelectFilter::make('comment_type')
                    ->options([
                        'comment' => 'Comment',
                        'pingback' => 'Pingback',
                        'trackback' => 'Trackback',
                    ]),
                Tables\Filters\Filter::make('approved')
                    ->query(fn ($query) => $query->where('comment_approved', 1)),
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
            ->defaultSort('comment_date', 'desc');
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
            'index' => Pages\ListWpComments::route('/'),
            'create' => Pages\CreateWpComment::route('/create'),
            'edit' => Pages\EditWpComment::route('/{record}/edit'),
        ];
    }
}
