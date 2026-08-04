<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuoteRequestResource\Pages;
use App\Models\QuoteRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuoteRequestResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'صندوق الوارد';

    protected static ?string $navigationLabel = 'طلبات عروض الأسعار';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'طلب عرض سعر';

    protected static ?string $pluralModelLabel = 'طلبات عروض الأسعار';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('admin.sections.submission_details'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.fields.name'))
                            ->disabled(),
                        Forms\Components\TextInput::make('organization')
                            ->label(__('admin.fields.organization'))
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->label(__('admin.fields.email'))
                            ->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('admin.fields.phone'))
                            ->disabled(),
                        Forms\Components\Select::make('training_bag_id')
                            ->label(__('admin.fields.training_bag'))
                            ->relationship('trainingBag', 'title')
                            ->getOptionLabelFromRecordUsing(fn ($record): string => $record->getTranslation('title', 'ar'))
                            ->disabled(),
                        Forms\Components\Textarea::make('notes')
                            ->label(__('admin.fields.notes'))
                            ->disabled()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make(__('admin.sections.admin'))
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label(__('admin.fields.status'))
                            ->options(__('admin.statuses.quote'))
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.fields.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('admin.fields.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('trainingBag.title')
                    ->label(__('admin.fields.training_bag'))
                    ->getStateUsing(fn (QuoteRequest $record): string => $record->trainingBag
                        ? (string) $record->trainingBag->getTranslation('title', 'ar')
                        : '—'),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('admin.fields.status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __('admin.statuses.quote.' . $state))
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'contacted' => 'warning',
                        'quoted' => 'info',
                        'closed' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('admin.fields.status'))
                    ->options(__('admin.statuses.quote')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuoteRequests::route('/'),
            'edit' => Pages\EditQuoteRequest::route('/{record}/edit'),
        ];
    }
}
