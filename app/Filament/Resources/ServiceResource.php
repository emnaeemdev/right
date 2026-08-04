<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\InteractsWithTranslatableFields;
use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    use InteractsWithTranslatableFields;

    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $navigationLabel = 'الخدمات';

    protected static ?string $modelLabel = 'خدمة';

    protected static ?string $pluralModelLabel = 'الخدمات';

    protected static ?int $navigationSort = 1;

    public static function getTranslatableFields(): array
    {
        return ['title', 'description', 'slug'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Translations')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('العربية')
                            ->schema([
                                Forms\Components\TextInput::make('title.ar')
                                    ->label('Title')
                                    ->required(),
                                Forms\Components\Textarea::make('description.ar')
                                    ->label('Description')
                                    ->rows(4),
                                Forms\Components\TextInput::make('slug.ar')
                                    ->label('Slug')
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('English (اختياري)')
                            ->schema([
                                Forms\Components\Placeholder::make('en_hint')
                                    ->label('')
                                    ->content('اترك الحقول فارغة إذا لا توجد ترجمة إنجليزية.'),
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title'),
                                Forms\Components\Textarea::make('description.en')
                                    ->label('Description')
                                    ->rows(4),
                                Forms\Components\TextInput::make('slug.en')
                                    ->label('Slug'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('icon')
                    ->placeholder('heroicon-o-academic-cap'),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_published')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->getStateUsing(fn (Service $record): string => (string) $record->getTranslation('title', 'ar')),
                Tables\Columns\TextColumn::make('slug')
                    ->label('الرابط')
                    ->getStateUsing(fn (Service $record): string => (string) $record->getTranslation('slug', 'ar')),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
