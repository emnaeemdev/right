<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\InteractsWithTranslatableFields;
use App\Filament\Forms\Components\TrainingBagSectionBuilder;
use App\Filament\Resources\TrainingBagResource\Pages;
use App\Filament\Resources\TrainingBagResource\RelationManagers;
use App\Models\TrainingBag;
use App\Support\TrainingFieldOptions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrainingBagResource extends Resource
{
    use InteractsWithTranslatableFields;

    protected static ?string $model = TrainingBag::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $navigationLabel = 'الحقائب التدريبية';

    protected static ?string $modelLabel = 'حقيبة تدريبية';

    protected static ?string $pluralModelLabel = 'الحقائب التدريبية';

    protected static ?int $navigationSort = 2;

    public static function getTranslatableFields(): array
    {
        return ['title', 'description'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('البيانات الأساسية')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('صورة الحقيبة')
                            ->image()
                            ->disk('public')
                            ->directory('training-bags'),
                        Forms\Components\Select::make('field')
                            ->label('المجال')
                            ->options(fn (): array => TrainingFieldOptions::all())
                            ->searchable()
                            ->nullable()
                            ->placeholder('— اختياري —')
                            ->helperText('لإضافة أو تعديل المجالات: الإعدادات ← مجالات التدريب'),
                        Forms\Components\Repeater::make('meta_highlights')
                            ->label('معلومات تحت العنوان')
                            ->helperText('أضف أو عدّل أو احذف أي سطر. اكتب النص كما سيظهر للزائر — مثل: 12 يوم، 60 ساعة، جاهزة، 180 شريحة.')
                            ->schema([
                                Forms\Components\TextInput::make('ar')
                                    ->label('النص (عربي)')
                                    ->required(),
                                Forms\Components\TextInput::make('en')
                                    ->label('Text (English — optional)'),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('إضافة سطر')
                            ->reorderable()
                            ->collapsible()
                            ->collapsed()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('الترتيب')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_published')
                            ->label('منشور')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('أقسام صفحة الحقيبة')
                    ->description('أضف فقط الأقسام التي تريد عرضها في صفحة الحقيبة. يمكنك إضافة، حذف، وإعادة ترتيب الأقسام.')
                    ->schema([
                        TrainingBagSectionBuilder::make(),
                    ]),

                Forms\Components\Tabs::make('الترجمات')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('العربية')
                            ->schema(static::translationTabSchema('ar')),
                        Forms\Components\Tabs\Tab::make('English (اختياري)')
                            ->schema(static::translationTabSchema('en')),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected static function translationTabSchema(string $locale): array
    {
        $suffix = ".{$locale}";
        $isArabic = $locale === 'ar';

        return array_filter([
            ...($isArabic ? [] : [
                Forms\Components\Placeholder::make('en_hint')
                    ->label('')
                    ->content('اترك الحقول فارغة إذا لا توجد ترجمة إنجليزية.'),
            ]),
            Forms\Components\TextInput::make("title{$suffix}")
                ->label($isArabic ? 'عنوان الحقيبة' : 'Title')
                ->required($isArabic),
            Forms\Components\Textarea::make("description{$suffix}")
                ->label($isArabic ? 'وصف مختصر' : 'Short description')
                ->rows(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->getStateUsing(fn (TrainingBag $record): string => (string) $record->getTranslation('title', 'ar')),
                Tables\Columns\TextColumn::make('field')
                    ->label('المجال')
                    ->formatStateUsing(fn (?string $state): string => TrainingFieldOptions::label($state) ?? '—'),
                Tables\Columns\TextColumn::make('id')
                    ->label('الرابط')
                    ->formatStateUsing(fn (int $state): string => '/training-bags/'.$state),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge(),
                Tables\Columns\TextColumn::make('duration_days')
                    ->label('الأيام'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور')
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\SamplesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainingBags::route('/'),
            'create' => Pages\CreateTrainingBag::route('/create'),
            'edit' => Pages\EditTrainingBag::route('/{record}/edit'),
        ];
    }
}
