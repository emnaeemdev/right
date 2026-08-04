<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\InteractsWithTranslatableFields;
use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    use InteractsWithTranslatableFields;

    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $navigationLabel = 'الشركاء';

    protected static ?string $modelLabel = 'شريك';

    protected static ?string $pluralModelLabel = 'الشركاء';

    protected static ?int $navigationSort = 7;

    public static function getTranslatableFields(): array
    {
        return ['name'];
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
                            ]),
                        Forms\Components\Tabs\Tab::make(__('admin.english_optional'))
                            ->schema([
                                Forms\Components\Placeholder::make('en_hint')
                                    ->label('')
                                    ->content(__('admin.english_optional_hint')),
                                Forms\Components\TextInput::make('name.en')
                                    ->label('Name'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('logo')
                    ->label('شعار / صورة المؤسسة')
                    ->helperText('ارفع شعار أو صورة المؤسسة — تظهر بشكل بارز في الصفحة الرئيسية وصفحة الشركاء. يُفضّل PNG أو JPG بخلفية شفافة أو بيضاء.')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('partners')
                    ->columnSpanFull(),
                Forms\Components\Select::make('category')
                    ->label(__('admin.fields.category'))
                    ->options([
                        'intl' => 'دولي',
                        'gov' => 'حكومي',
                        'ngo' => 'أهلي',
                    ])
                    ->required()
                    ->default('gov'),
                Forms\Components\TextInput::make('website')
                    ->label(__('admin.fields.website'))
                    ->url(),
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
                Tables\Columns\ImageColumn::make('logo')
                    ->label(__('admin.fields.logo'))
                    ->disk('public'),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.fields.name'))
                    ->getStateUsing(fn (Partner $record): string => (string) $record->getTranslation('name', 'ar')),
                Tables\Columns\TextColumn::make('category')
                    ->label(__('admin.fields.category'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'intl' => 'دولي',
                        'gov' => 'حكومي',
                        'ngo' => 'أهلي',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('website')
                    ->label(__('admin.fields.website'))
                    ->limit(30),
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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
