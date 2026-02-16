<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::OutlinedUsers;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Account')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create'),
                    ]),
                Section::make('Profile')
                    ->relationship('profile')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\Textarea::make('info')
                            ->label('Bio')
                            ->rows(3),
                        Forms\Components\TextInput::make('website')
                            ->url(),
                        Forms\Components\TextInput::make('telephone')
                            ->tel(),
                        Forms\Components\TextInput::make('city'),
                        Fieldset::make('Social Media')
                            ->schema([
                                Forms\Components\TextInput::make('facebook'),
                                Forms\Components\TextInput::make('instagram'),
                                Forms\Components\TextInput::make('twitter'),
                                Forms\Components\TextInput::make('pinterest'),
                            ])->columns(2),
                        Fieldset::make('Flags')
                            ->schema([
                                Forms\Components\Toggle::make('is_pro')
                                    ->label('Pro'),
                                Forms\Components\Toggle::make('is_restaurant')
                                    ->label('Restaurant'),
                                Forms\Components\Toggle::make('is_top')
                                    ->label('Top'),
                            ])->columns(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('profile.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('recipes_count')
                    ->counts('recipes')
                    ->label('Recipes'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
