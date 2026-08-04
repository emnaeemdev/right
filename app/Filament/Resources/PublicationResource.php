<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\InteractsWithTranslatableFields;
use App\Filament\Forms\Components\ContentRichEditor;
use App\Filament\Resources\PublicationResource\Pages;
use App\Filament\Support\DocumentUpload;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PublicationResource extends Resource
{
    use InteractsWithTranslatableFields;

    protected static ?string $model = Publication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $navigationLabel = 'أوراق رايت';

    protected static ?string $modelLabel = 'ورقة';

    protected static ?string $pluralModelLabel = 'أوراق رايت';

    protected static ?int $navigationSort = 5;

    public static function getTranslatableFields(): array
    {
        return ['title', 'description', 'excerpt'];
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
                            Forms\Components\Textarea::make('description.ar')->label('وصف قصير')->rows(2),
                            ContentRichEditor::make('content_ar')->label('المحتوى الكامل')->columnSpanFull(),
                        ]),
                    Forms\Components\Tabs\Tab::make('English (اختياري)')
                        ->schema([
                            Forms\Components\Placeholder::make('en_hint')
                                ->label('')
                                ->content('اترك الحقول فارغة إذا لا توجد ترجمة إنجليزية.'),
                            Forms\Components\TextInput::make('title.en')->label('Title'),
                            Forms\Components\Textarea::make('excerpt.en')->label('Excerpt')->rows(3),
                            Forms\Components\Textarea::make('description.en')->label('Short Description')->rows(2),
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
                        ->directory('papers'),
                    DocumentUpload::pdfField('pdf_path', 'publications/documents'),
                    DocumentUpload::wordField('word_path', 'publications/documents'),
                ])->columns(2),
            Forms\Components\Select::make('category')->label('التصنيف')->options([
                'governance' => 'الحوكمة',
                'm_e' => 'المتابعة والتقييم',
                'research' => 'البحوث',
                'training' => 'التدريب',
            ]),
            Forms\Components\TextInput::make('year')->label('السنة')->numeric()->minValue(1900)->maxValue(2100),
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
                ->getStateUsing(fn (Publication $record): string => (string) ($record->getTranslation('title', 'ar') ?: $record->getTranslation('title', 'en'))),
            Tables\Columns\TextColumn::make('id')->label('الرابط')->formatStateUsing(fn (int $state): string => '/papers/'.$state),
            Tables\Columns\TextColumn::make('category')->label('التصنيف'),
            Tables\Columns\TextColumn::make('year')->label('السنة')->sortable(),
            Tables\Columns\IconColumn::make('is_published')->label('منشور')->boolean(),
        ])->defaultSort('year', 'desc')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}
