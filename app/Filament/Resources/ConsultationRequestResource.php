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
                Forms\Components\Section::make('Submission Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->disabled(),
                        Forms\Components\TextInput::make('organization')
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->disabled(),
                        Forms\Components\TextInput::make('consultation_type')
                            ->disabled(),
                        Forms\Components\Textarea::make('description')
                            ->disabled()
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('budget_range')
                            ->disabled(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Admin')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'new' => 'New',
                                'assigned' => 'Assigned',
                                'in_progress' => 'In Progress',
                                'closed' => 'Closed',
                            ])
                            ->required(),
                        Forms\Components\Select::make('assigned_expert_id')
                            ->label('Assigned Expert')
                            ->options(fn (): array => Expert::query()
                                ->get()
                                ->mapWithKeys(fn (Expert $expert): array => [
                                    $expert->id => $expert->getTranslation('name', 'ar'),
                                ])
                                ->all())
                            ->searchable()
                            ->nullable(),
                        Forms\Components\Textarea::make('admin_notes')
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('consultation_type')
                    ->label('Type'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'assigned' => 'warning',
                        'in_progress' => 'info',
                        'closed' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('assignedExpert.name')
                    ->label('الخبير')
                    ->getStateUsing(fn (ConsultationRequest $record): string => $record->assignedExpert
                        ? (string) $record->assignedExpert->getTranslation('name', 'ar')
                        : '—'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'assigned' => 'Assigned',
                        'in_progress' => 'In Progress',
                        'closed' => 'Closed',
                    ]),
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
