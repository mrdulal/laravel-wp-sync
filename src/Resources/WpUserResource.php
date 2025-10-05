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
use YourName\WpConnector\Models\WpUser;

class WpUserResource extends Resource
{
    protected static ?string $model = WpUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'WordPress';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_login')
                    ->required()
                    ->maxLength(60)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('user_email')
                    ->email()
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('user_nicename')
                    ->maxLength(50),
                Forms\Components\TextInput::make('user_url')
                    ->url()
                    ->maxLength(100),
                Forms\Components\TextInput::make('display_name')
                    ->maxLength(250),
                Forms\Components\DateTimePicker::make('user_registered')
                    ->default(now()),
                Forms\Components\TextInput::make('user_status')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_login')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('display_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_registered')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'success',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('posts_count')
                    ->counts('posts')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_status')
                    ->options([
                        '0' => 'Active',
                        '1' => 'Inactive',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListWpUsers::route('/'),
            'create' => Pages\CreateWpUser::route('/create'),
            'edit' => Pages\EditWpUser::route('/{record}/edit'),
        ];
    }
}
