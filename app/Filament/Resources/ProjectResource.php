<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\InteractsWithTranslatableFields;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    use InteractsWithTranslatableFields;

    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $navigationLabel = 'المشاريع';

    protected static ?string $modelLabel = 'مشروع';

    protected static ?string $pluralModelLabel = 'المشاريع';

    protected static ?int $navigationSort = 8;

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
                Forms\Components\TextInput::make('client'),
                Forms\Components\TextInput::make('field'),
                Forms\Components\TextInput::make('year')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(2100),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('projects'),
                Forms\Components\Toggle::make('is_featured'),
                Forms\Components\Toggle::make('is_published')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->getStateUsing(fn (Project $record): string => (string) $record->getTranslation('title', 'ar')),
                Tables\Columns\TextColumn::make('client'),
                Tables\Columns\TextColumn::make('field'),
                Tables\Columns\TextColumn::make('year')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
            ])
            ->defaultSort('year', 'desc')
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\ExpertsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
