<?php

namespace App\Filament\Resources\TrainingBagResource\RelationManagers;

use App\Filament\Resources\TrainingBagResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CycleStepsRelationManager extends RelationManager
{
    protected static string $relationship = 'cycleSteps';

    protected static ?string $title = 'Cycle Steps';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Translations')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('العربية')
                            ->schema([
                                Forms\Components\TextInput::make('title.ar')
                                    ->label('العنوان')
                                    ->required(),
                                Forms\Components\Textarea::make('description.ar')
                                    ->label('الوصف')
                                    ->rows(3),
                            ]),
                        Forms\Components\Tabs\Tab::make('English (اختياري)')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title'),
                                Forms\Components\Textarea::make('description.en')
                                    ->label('Description')
                                    ->rows(3),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->getStateUsing(fn (\App\Models\TrainingBagCycleStep $record): string => (string) $record->getTranslation('title', 'ar')),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(fn (array $data): array => $this->processTranslatableData($data)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(fn (array $data, $record): array => $this->expandTranslatableData($data, $record))
                    ->mutateFormDataUsing(fn (array $data): array => $this->processTranslatableData($data)),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function processTranslatableData(array $data): array
    {
        return TrainingBagResource::processTranslatableData($data, ['title', 'description']);
    }

    protected function expandTranslatableData(array $data, object $record): array
    {
        return TrainingBagResource::expandTranslatableData($data, $record, ['title', 'description']);
    }
}
