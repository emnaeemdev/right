<?php

namespace App\Filament\Resources\TrainingBagResource\RelationManagers;

use App\Filament\Resources\TrainingBagResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SamplesRelationManager extends RelationManager
{
    protected static string $relationship = 'samples';

    protected static ?string $title = 'نماذج الحقيبة';

    protected static ?string $modelLabel = 'نموذج';

    protected static ?string $pluralModelLabel = 'نماذج الحقيبة';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title.ar')
                    ->label('الاسم المعروض للزائر')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('مثل: PDF تجريبي، فيديو تعريفي...')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title.en')
                    ->label('Display name (English — optional)')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->label('نوع النموذج')
                    ->options([
                        'video' => 'فيديو',
                        'activity' => 'نشاط',
                        'pdf' => 'PDF',
                    ])
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('video_url')
                    ->label('رابط الفيديو (YouTube embed)')
                    ->url()
                    ->visible(fn (Get $get): bool => $get('type') === 'video'),
                Forms\Components\Textarea::make('activity_html')
                    ->label('محتوى النشاط (HTML)')
                    ->rows(6)
                    ->visible(fn (Get $get): bool => $get('type') === 'activity'),
                Forms\Components\FileUpload::make('pdf_path')
                    ->label('ملف PDF')
                    ->disk('public')
                    ->directory('training-bag-samples')
                    ->acceptedFileTypes(['application/pdf'])
                    ->visible(fn (Get $get): bool => $get('type') === 'pdf'),
                Forms\Components\Toggle::make('is_public')
                    ->label('ظاهر للزوار')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn (\App\Models\TrainingBagSample $record): string => $record->displayTitle('ar'))
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('الاسم المعروض')
                    ->getStateUsing(fn (\App\Models\TrainingBagSample $record): string => $record->displayTitle('ar')),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'video' => 'فيديو',
                        'activity' => 'نشاط',
                        'pdf' => 'PDF',
                        default => $state,
                    })
                    ->badge(),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('ظاهر')
                    ->boolean(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('إضافة نموذج')
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
        return TrainingBagResource::processTranslatableData($data, ['title']);
    }

    protected function expandTranslatableData(array $data, object $record): array
    {
        return TrainingBagResource::expandTranslatableData($data, $record, ['title']);
    }
}
