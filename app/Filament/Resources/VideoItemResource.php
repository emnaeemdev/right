<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\InteractsWithTranslatableFields;
use App\Filament\Resources\VideoItemResource\Pages;
use App\Models\VideoItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VideoItemResource extends Resource
{
    use InteractsWithTranslatableFields;

    protected static ?string $model = VideoItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $navigationLabel = 'فيديو';

    protected static ?string $modelLabel = 'فيديو';

    protected static ?string $pluralModelLabel = 'فيديو';

    protected static ?int $navigationSort = 4;

    public static function getTranslatableFields(): array
    {
        return ['title', 'description'];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('الترجمات')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('العربية')
                        ->schema([
                            Forms\Components\TextInput::make('title.ar')->label('العنوان')->required(),
                            Forms\Components\Textarea::make('description.ar')->label('الوصف')->rows(3),
                        ]),
                    Forms\Components\Tabs\Tab::make('English (اختياري)')
                        ->schema([
                            Forms\Components\Placeholder::make('en_hint')
                                ->label('')
                                ->content('اترك الحقول فارغة إذا لا توجد ترجمة إنجليزية.'),
                            Forms\Components\TextInput::make('title.en')->label('Title'),
                            Forms\Components\Textarea::make('description.en')->label('Description')->rows(3),
                        ]),
                ])->columnSpanFull(),
            Forms\Components\Section::make('الفيديو')
                ->description('رابط الفيديو وصورة مصغرة واحدة — غير مرتبطين باللغة.')
                ->schema([
                    Forms\Components\TextInput::make('video_url')->label('رابط الفيديو (YouTube/Vimeo)')->url()->required()->columnSpanFull(),
                    Forms\Components\FileUpload::make('thumbnail')->label('صورة مصغرة')->image()->disk('public')->directory('videos'),
                ]),
            Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
            Forms\Components\Toggle::make('is_published')->label('منشور')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('thumbnail')
                ->label('صورة')
                ->disk('public'),
            Tables\Columns\TextColumn::make('title')
                ->label('العنوان')
                ->getStateUsing(fn (VideoItem $record): string => (string) ($record->getTranslation('title', 'ar') ?: $record->getTranslation('title', 'en'))),
            Tables\Columns\TextColumn::make('id')->label('الرابط')->formatStateUsing(fn (int $state): string => '/videos/'.$state),
            Tables\Columns\TextColumn::make('sort_order')->label('الترتيب')->sortable(),
            Tables\Columns\IconColumn::make('is_published')->label('منشور')->boolean(),
        ])->defaultSort('sort_order')->reorderable('sort_order')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideoItems::route('/'),
            'create' => Pages\CreateVideoItem::route('/create'),
            'edit' => Pages\EditVideoItem::route('/{record}/edit'),
        ];
    }
}
