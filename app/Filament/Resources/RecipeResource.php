<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipeResource\Pages;
use App\Filament\Resources\RecipeResource\RelationManagers;
use App\Models\Recipe;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

class RecipeResource extends Resource
{
    use Translatable;

    protected static ?string $model = Recipe::class;

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\FileUpload::make('main_image')
                            ->image()
                            ->disk('public')
                            ->directory('images/recipes')
                            ->visibility('public')
                            ->afterStateHydrated(function (Forms\Components\FileUpload $component, $state, $record) {
                                if ($record) {
                                    $component->state($record->getRawOriginal('main_image'));
                                }
                            }),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->rows(3),
                        Forms\Components\Textarea::make('ingredients')
                            ->rows(8),
                        Forms\Components\Textarea::make('instructions')
                            ->rows(8),
                        Forms\Components\Textarea::make('notes')
                            ->rows(3),
                        Forms\Components\TextInput::make('servings'),
                        Forms\Components\Select::make('user_id')
                            ->relationship('author', 'email')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Author'),
                        Forms\Components\CheckboxList::make('categories')
                            ->relationship('categories', 'name')
                            ->columns(3),
                        Forms\Components\TextInput::make('prep_time')
                            ->numeric()
                            ->suffix('minutes'),
                        Forms\Components\TextInput::make('cook_time')
                            ->numeric()
                            ->suffix('minutes'),
                    ]),
                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('published')
                            ->default(false),
                        Forms\Components\Toggle::make('featured')
                            ->default(false),
                        Forms\Components\Toggle::make('traditional')
                            ->default(false),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('author.profile.name')
                    ->label('Author')
                    ->sortable(),
                Tables\Columns\TextColumn::make('images_count')
                    ->counts('images')
                    ->label('Images'),
                Tables\Columns\IconColumn::make('published')
                    ->boolean(),
                Tables\Columns\IconColumn::make('traditional')
                    ->boolean(),
                Tables\Columns\IconColumn::make('featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('published'),
                Tables\Filters\TernaryFilter::make('featured'),
                Tables\Filters\TernaryFilter::make('traditional'),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecipes::route('/'),
            'create' => Pages\CreateRecipe::route('/create'),
            'view' => Pages\ViewRecipe::route('/{record}'),
            'edit' => Pages\EditRecipe::route('/{record}/edit'),
        ];
    }
}
