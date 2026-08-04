<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'صندوق الوارد';

    protected static ?string $navigationLabel = 'رسائل التواصل';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'رسالة';

    protected static ?string $pluralModelLabel = 'رسائل التواصل';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('admin.sections.message'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.fields.name'))
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->label(__('admin.fields.email'))
                            ->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('admin.fields.phone'))
                            ->disabled(),
                        Forms\Components\TextInput::make('subject')
                            ->label(__('admin.fields.subject'))
                            ->disabled(),
                        Forms\Components\Textarea::make('message')
                            ->label(__('admin.fields.message'))
                            ->disabled()
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Forms\Components\Toggle::make('is_read')
                    ->label(__('admin.fields.mark_as_read')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->boolean()
                    ->label(__('admin.fields.read')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.fields.name'))
                    ->searchable()
                    ->weight(fn (ContactMessage $record): ?\Filament\Support\Enums\FontWeight => $record->is_read ? null : \Filament\Support\Enums\FontWeight::Bold),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('admin.fields.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label(__('admin.fields.subject'))
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label(__('admin.fields.read_status')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggleRead')
                    ->label(fn (ContactMessage $record): string => $record->is_read
                        ? __('admin.fields.mark_unread')
                        : __('admin.fields.mark_read'))
                    ->icon(fn (ContactMessage $record): string => $record->is_read ? 'heroicon-o-envelope' : 'heroicon-o-envelope-open')
                    ->action(fn (ContactMessage $record) => $record->update(['is_read' => ! $record->is_read])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('markRead')
                        ->label(__('admin.fields.mark_as_read'))
                        ->icon('heroicon-o-envelope-open')
                        ->action(fn ($records) => $records->each->update(['is_read' => true])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
