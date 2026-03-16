<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Orders';

    protected static ?string $modelLabel = 'Order';

    protected static ?string $pluralModelLabel = 'Orders';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('domain')
                    ->required()
                    ->maxLength(255)
                    ->label('Domain'),

                Forms\Components\Select::make('website_type')
                    ->options([
                        'business' => 'Business Website',
                        'e-commerce' => 'E-commerce',
                        'portfolio' => 'Portfolio',
                        'blog' => 'Blog',
                        'landing-page' => 'Landing Page',
                        'other' => 'Other',
                    ])
                    ->required()
                    ->label('Website Type'),

                Forms\Components\Select::make('timeline')
                    ->options([
                        'asap' => 'ASAP',
                        '1-month' => '1 Month',
                        '2-3-months' => '2-3 Months',
                        '3-6-months' => '3-6 Months',
                        'flexible' => 'Flexible',
                    ])
                    ->required()
                    ->label('Timeline'),

                Forms\Components\Select::make('budget_range')
                    ->options([
                        'under-5k' => 'Under $5,000',
                        '5k-10k' => '$5,000 - $10,000',
                        '10k-25k' => '$10,000 - $25,000',
                        '25k-50k' => '$25,000 - $50,000',
                        'over-50k' => 'Over $50,000',
                    ])
                    ->required()
                    ->label('Budget Range'),

                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewing' => 'Reviewing',
                        'approved' => 'Approved',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('pending'),

Forms\Components\TextInput::make('price_estimate')
                    ->numeric()
                    ->prefix('$')
                    ->label('Estimated Total'),

                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('client_name')
                    ->maxLength(255)
                    ->label('Client Name'),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),

                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),

                Forms\Components\Textarea::make('project_description')
                    ->rows(4)
                    ->maxLength(65535)
                    ->label('Project Description'),

                Forms\Components\Textarea::make('additional_requirements')
                    ->rows(3)
                    ->maxLength(65535)
                    ->label('Additional Requirements'),

                Forms\Components\CheckboxList::make('services')
                    ->relationship('services', 'name')
                    ->columns(2)
                    ->label('Services'),

                Forms\Components\CheckboxList::make('features')
                    ->relationship('features', 'name')
                    ->columns(2)
                    ->label('Features'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('domain')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('client.name')
                    ->label('Client')
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'pending',
                        'warning' => 'reviewing',
                        'success' => 'approved',
                        'primary' => 'in_progress',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-eye' => 'reviewing',
                        'heroicon-o-check-circle' => 'approved',
                        'heroicon-o-cog' => 'in_progress',
                        'heroicon-o-check' => 'completed',
                        'heroicon-o-x-circle' => 'cancelled',
                    ]),

                TextColumn::make('website_type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('-', ' ', $state)))
                    ->badge()
                    ->color('gray'),

                TextColumn::make('timeline')
                    ->label('Timeline')
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('-', ' ', $state))),

                TextColumn::make('budget_range')
                    ->label('Budget')
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('-', ' ', $state))),

                TextColumn::make('price_estimate')
                    ->label('Estimated Total')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewing' => 'Reviewing',
                        'approved' => 'Approved',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),

                SelectFilter::make('website_type')
                    ->options([
                        'business' => 'Business Website',
                        'e-commerce' => 'E-commerce',
                        'portfolio' => 'Portfolio',
                        'blog' => 'Blog',
                        'landing-page' => 'Landing Page',
                        'other' => 'Other',
                    ])
                    ->label('Website Type'),

                SelectFilter::make('timeline')
                    ->options([
                        'asap' => 'ASAP',
                        '1-month' => '1 Month',
                        '2-3-months' => '2-3 Months',
                        '3-6-months' => '3-6 Months',
                        'flexible' => 'Flexible',
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}