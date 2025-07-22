<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Estudiantes en el curso :course', ['course' => $ownerRecord->name]);
    }

    protected static function getRecordLabel(): ?string
    {
        return __('Estudiante');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([

                TextColumn::make('name')
                    ->label( __('Nombre') ),

                TextColumn::make('pivot.completed')
                    ->label( __('Completado') )
                    ->badge()
                    ->alignCenter()
                    ->color(fn (Model $record) => $record->pivot->completed ? 'success' : 'danger')
                    ->state(fn (Model $record) => $record->pivot->completed ? __('Si') : __('No')),
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
            ->emptyStateDescription( __('No hay estudiantes en este curso') );
    }
}
