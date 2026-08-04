<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\InteractsWithTranslatableFields;
use App\Filament\Forms\Components\ContentRichEditor;
use App\Filament\Resources\TrainingActivityResource\Pages;
use App\Filament\Support\DocumentUpload;
use App\Models\TrainingActivity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrainingActivityResource extends Resource
{
    use InteractsWithTranslatableFields;

    protected static ?string $model = TrainingActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $navigationLabel = 'أنشطة وفعاليات';

    protected static ?string $modelLabel = 'نشاط';

    protected static ?string $pluralModelLabel = 'أنشطة وفعاليات';

    protected static ?int $navigationSort = 3;

    public static function getTranslatableFields(): array
    {
        return ['title', 'excerpt'];
    }

    public static function getRichEditorFields(): array
    {
        return ['content'];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('الترجمات')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('العربية')
                        ->schema([
                            Forms\Components\TextInput::make('title.ar')->label('العنوان')->required(),
                            Forms\Components\Textarea::make('excerpt.ar')->label('نبذة مختصرة')->rows(3),
                            ContentRichEditor::make('content_ar')->label('المحتوى الكامل')->columnSpanFull(),
                        ]),
                    Forms\Components\Tabs\Tab::make('English (اختياري)')
                        ->schema([
                            Forms\Components\Placeholder::make('en_hint')
                                ->label('')
                                ->content('اترك الحقول فارغة إذا لا توجد ترجمة إنجليزية.'),
                            Forms\Components\TextInput::make('title.en')->label('Title'),
                            Forms\Components\Textarea::make('excerpt.en')->label('Excerpt')->rows(3),
                            ContentRichEditor::make('content_en')->label('Full Content')->columnSpanFull(),
                        ]),
                ])->columnSpanFull(),
            Forms\Components\Section::make('الوسائط والملفات')
                ->description('صورة للقائمة + ملفات PDF أو Word للتحميل — غير مرتبطة باللغة.')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('صورة القائمة')
                        ->image()
                        ->disk('public')
                        ->directory('activities'),
                    DocumentUpload::pdfField('pdf_path', 'activities/documents'),
                    DocumentUpload::wordField('word_path', 'activities/documents'),
                ])->columns(2),
            Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
            Forms\Components\Toggle::make('is_published')->label('منشور')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')
                ->label('الصورة')
                ->disk('public'),
            Tables\Columns\TextColumn::make('title')
                ->label('العنوان')
                ->getStateUsing(fn (TrainingActivity $record): string => (string) ($record->getTranslation('title', 'ar') ?: $record->getTranslation('title', 'en'))),
            Tables\Columns\TextColumn::make('id')->label('الرابط')->formatStateUsing(fn (int $state): string => '/activities/'.$state),
            Tables\Columns\TextColumn::make('sort_order')->label('الترتيب')->sortable(),
            Tables\Columns\IconColumn::make('is_published')->label('منشور')->boolean(),
        ])->defaultSort('sort_order')->reorderable('sort_order')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainingActivities::route('/'),
            'create' => Pages\CreateTrainingActivity::route('/create'),
            'edit' => Pages\EditTrainingActivity::route('/{record}/edit'),
        ];
    }
}
