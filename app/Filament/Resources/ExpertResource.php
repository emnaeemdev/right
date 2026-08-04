<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\InteractsWithTranslatableFields;
use App\Filament\Resources\ExpertResource\Pages;
use App\Models\Expert;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExpertResource extends Resource
{
    use InteractsWithTranslatableFields;

    protected static ?string $model = Expert::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $navigationLabel = 'الخبراء';

    protected static ?string $modelLabel = 'خبير';

    protected static ?string $pluralModelLabel = 'الخبراء';

    protected static ?int $navigationSort = 6;

    public static function getTranslatableFields(): array
    {
        return ['name', 'title', 'bio', 'specializations'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make(__('admin.translations'))
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('العربية')
                            ->schema([
                                Forms\Components\TextInput::make('name.ar')
                                    ->label(__('admin.fields.name'))
                                    ->required(),
                                Forms\Components\TextInput::make('title.ar')
                                    ->label(__('admin.fields.job_title')),
                                Forms\Components\Textarea::make('bio.ar')
                                    ->label(__('admin.fields.description'))
                                    ->rows(4),
                                Forms\Components\Textarea::make('specializations.ar')
                                    ->label(__('admin.fields.specializations'))
                                    ->rows(3),
                            ]),
                        Forms\Components\Tabs\Tab::make(__('admin.english_optional'))
                            ->schema([
                                Forms\Components\Placeholder::make('en_hint')
                                    ->label('')
                                    ->content(__('admin.english_optional_hint')),
                                Forms\Components\TextInput::make('name.en')
                                    ->label('Name'),
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title'),
                                Forms\Components\Textarea::make('bio.en')
                                    ->label('Bio')
                                    ->rows(4),
                                Forms\Components\Textarea::make('specializations.en')
                                    ->label('Specializations')
                                    ->rows(3),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('photo')
                    ->label(__('admin.fields.photo'))
                    ->image()
                    ->disk('public')
                    ->directory('experts'),
                Forms\Components\TextInput::make('email')
                    ->label(__('admin.fields.email'))
                    ->email(),
                Forms\Components\TextInput::make('sort_order')
                    ->label(__('admin.fields.sort_order'))
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_published')
                    ->label(__('admin.fields.is_published'))
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label(__('admin.fields.photo'))
                    ->disk('public'),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.fields.name'))
                    ->getStateUsing(fn (Expert $record): string => (string) $record->getTranslation('name', 'ar')),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('admin.fields.job_title'))
                    ->getStateUsing(fn (Expert $record): string => (string) $record->getTranslation('title', 'ar')),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('admin.fields.email')),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('admin.fields.sort_order'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label(__('admin.fields.is_published'))
                    ->boolean(),
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
            'index' => Pages\ListExperts::route('/'),
            'create' => Pages\CreateExpert::route('/create'),
            'edit' => Pages\EditExpert::route('/{record}/edit'),
        ];
    }
}
