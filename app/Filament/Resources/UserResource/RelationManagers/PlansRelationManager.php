<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PlansRelationManager extends RelationManager
{
    protected static string $relationship = 'plans';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Planes del usuario :user', ['user' => $ownerRecord->name]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([

                TextColumn::make('name')
                    ->label( __('Nombre') ),

                ToggleColumn::make('pivot.active')
                    ->label( __('Activo') )
                    ->updateStateUsing(function ($record, $state) {
                        $record->pivot->active = $state;
                        $record->pivot->save();
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ])
            ->emptyStateDescription( __('Este usuario no tiene planes actualmente') );
    }
}
