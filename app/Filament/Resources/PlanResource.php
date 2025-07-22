<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Filament\Resources\PlanResource\RelationManagers\UsersRelationManager;
use App\Models\Plan;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'eos-product-subscriptions';

    protected static ?int $navigationSort = 20;

    public static function getLabel(): string
    {
        return __('Planes');
    }

    public static function getNavigationLabel(): string
    {
        return __('Planes');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                    ->label( __('Nombre') )
                    ->autofocus()
                    ->required()
                    ->unique(static::getModel(), 'name', ignoreRecord: true)
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Set $set, ?string $old, ?string $state) {
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug'),

                TextInput::make('description')
                    ->required()
                    ->maxLength(200)
                    ->label( __('Descripción') ),

                TextInput::make('price')
                    ->required()
                    ->maxLength(100)
                    ->suffix('Q')
                    ->label( __('Precio') ),

                Checkbox::make('active')
                    ->label( __('Activo') ),

                Checkbox::make('featured')
                    ->label( __('Destacado') ),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->columns([

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label( __('Nombre') )
                    ->description(fn (Plan $plan) => $plan->description),

                TextColumn::make('slug')
                    ->label( __('Slug') ),

                TextColumn::make('price')
                    ->sortable()
                    ->money('gtq')
                    ->label( __('Precio') ),

                ToggleColumn::make('active')
                    ->label( __('Activo') ),

                ToggleColumn::make('featured')
                    ->label( __('Destacado') ),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
