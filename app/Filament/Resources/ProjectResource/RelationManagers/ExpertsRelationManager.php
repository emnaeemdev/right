<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ExpertsRelationManager extends RelationManager
{
    protected static string $relationship = 'experts';

    protected static ?string $title = 'الخبراء';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->disabled(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->getStateUsing(fn (\App\Models\Expert $record): string => (string) $record->getTranslation('name', 'ar')),
                Tables\Columns\TextColumn::make('title')
                    ->label('المسمى')
                    ->getStateUsing(fn (\App\Models\Expert $record): string => (string) $record->getTranslation('title', 'ar')),
                Tables\Columns\TextColumn::make('email'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordTitle(fn (\App\Models\Expert $record): string => $record->getTranslation('name', 'ar')),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
