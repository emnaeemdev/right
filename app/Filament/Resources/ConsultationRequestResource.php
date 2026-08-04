<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultationRequestResource\Pages;
use App\Models\ConsultationRequest;
use App\Models\Expert;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConsultationRequestResource extends Resource
{
    protected static ?string $model = ConsultationRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'صندوق الوارد';

    protected static ?string $navigationLabel = 'طلبات الاستشارة';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'طلب استشارة';

    protected static ?string $pluralModelLabel = 'طلبات الاستشارة';

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
                        Forms\Components\TextInput::make('consultation_type')
                            ->label(__('admin.fields.consultation_type'))
                            ->disabled(),
                        Forms\Components\Textarea::make('description')
                            ->label(__('admin.fields.description'))
                            ->disabled()
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('budget_range')
                            ->label(__('admin.fields.budget_range'))
                            ->disabled(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make(__('admin.sections.admin'))
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label(__('admin.fields.status'))
                            ->options(__('admin.statuses.consultation'))
                            ->required(),
                        Forms\Components\Select::make('assigned_expert_id')
                            ->label(__('admin.fields.assigned_expert'))
                            ->options(fn (): array => Expert::query()
                                ->get()
                                ->mapWithKeys(fn (Expert $expert): array => [
                                    $expert->id => $expert->getTranslation('name', 'ar'),
                                ])
                                ->all())
                            ->searchable()
                            ->nullable(),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label(__('admin.fields.admin_notes'))
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
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
                Tables\Columns\TextColumn::make('consultation_type')
                    ->label(__('admin.fields.type')),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('admin.fields.status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __('admin.statuses.consultation.' . $state))
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'assigned' => 'warning',
                        'in_progress' => 'info',
                        'closed' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('assignedExpert.name')
                    ->label(__('admin.fields.expert'))
                    ->getStateUsing(fn (ConsultationRequest $record): string => $record->assignedExpert
                        ? (string) $record->assignedExpert->getTranslation('name', 'ar')
                        : '—'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('admin.fields.status'))
                    ->options(__('admin.statuses.consultation')),
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
            'index' => Pages\ListConsultationRequests::route('/'),
            'edit' => Pages\EditConsultationRequest::route('/{record}/edit'),
        ];
    }
}
