<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('content')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Textarea::make('meta_description')
                    ->maxLength(65535),
                Forms\Components\Toggle::make('is_published')
                    ->default(false),
                Forms\Components\TextInput::make('hero_title')
                    ->maxLength(255),
                Forms\Components\Textarea::make('hero_subtitle')
                    ->maxLength(65535),
                Forms\Components\FileUpload::make('hero_image')
                    ->image(),
                Forms\Components\TextInput::make('hero_button_text')
                    ->maxLength(255),
                Forms\Components\TextInput::make('hero_button_url')
                    ->maxLength(255),
                Forms\Components\TextInput::make('portfolio_title')
                    ->maxLength(255),
                Forms\Components\Textarea::make('portfolio_subtitle')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('services_title')
                    ->maxLength(255),
                Forms\Components\Textarea::make('services_subtitle')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('features_title')
                    ->maxLength(255),
                Forms\Components\Textarea::make('features_subtitle')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('testimonials_title')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('hero_title'),
                Tables\Columns\TextColumn::make('portfolio_title'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}