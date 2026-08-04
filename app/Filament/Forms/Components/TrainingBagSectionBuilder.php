<?php

namespace App\Filament\Forms\Components;

use Filament\Forms;
use Filament\Forms\Components\Builder;

class TrainingBagSectionBuilder
{
    public static function make(string $name = 'content_sections'): Builder
    {
        return Forms\Components\Builder::make($name)
            ->label('أقسام صفحة الحقيبة')
            ->helperText('أضف الأقسام التي تريد عرضها فقط. يمكنك الحذف وإعادة الترتيب في أي وقت.')
            ->blocks([
                static::listBlock(),
                static::textBlock(),
                static::richBlock(),
            ])
            ->blockNumbers(false)
            ->collapsible()
            ->collapsed()
            ->cloneable()
            ->reorderable()
            ->addActionLabel('إضافة قسم')
            ->columnSpanFull();
    }

    protected static function sectionTitleFields(): array
    {
        return [
            Forms\Components\TextInput::make('title.ar')
                ->label('عنوان القسم (عربي)')
                ->required()
                ->columnSpanFull(),
            Forms\Components\TextInput::make('title.en')
                ->label('عنوان القسم (English — اختياري)')
                ->columnSpanFull(),
        ];
    }

    protected static function listBlock(): Builder\Block
    {
        return Builder\Block::make('list')
            ->label('قائمة')
            ->icon('heroicon-o-list-bullet')
            ->schema([
                ...static::sectionTitleFields(),
                Forms\Components\Repeater::make('items')
                    ->label('عناصر القائمة')
                    ->schema([
                        Forms\Components\TextInput::make('ar')
                            ->label('بالعربية')
                            ->required(),
                        Forms\Components\TextInput::make('en')
                            ->label('English (اختياري)'),
                    ])
                    ->columns(2)
                    ->defaultItems(1)
                    ->addActionLabel('إضافة عنصر')
                    ->reorderable()
                    ->columnSpanFull(),
            ])
            ->label(function (?array $state): string {
                $title = trim((string) ($state['title']['ar'] ?? ''));

                return $title !== '' ? $title : 'قائمة';
            });
    }

    protected static function textBlock(): Builder\Block
    {
        return Builder\Block::make('text')
            ->label('نص')
            ->icon('heroicon-o-document-text')
            ->schema([
                ...static::sectionTitleFields(),
                Forms\Components\Textarea::make('body.ar')
                    ->label('المحتوى (عربي)')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('body.en')
                    ->label('Content (English — optional)')
                    ->rows(4)
                    ->columnSpanFull(),
            ])
            ->label(function (?array $state): string {
                $title = trim((string) ($state['title']['ar'] ?? ''));

                return $title !== '' ? $title : 'نص';
            });
    }

    protected static function richBlock(): Builder\Block
    {
        return Builder\Block::make('rich')
            ->label('محتوى منسق')
            ->icon('heroicon-o-bars-3-bottom-left')
            ->schema([
                ...static::sectionTitleFields(),
                ContentRichEditor::make('body_ar')
                    ->label('المحتوى (عربي)')
                    ->columnSpanFull(),
                ContentRichEditor::make('body_en')
                    ->label('Content (English — optional)')
                    ->columnSpanFull(),
            ])
            ->label(function (?array $state): string {
                $title = trim((string) ($state['title']['ar'] ?? ''));

                return $title !== '' ? $title : 'محتوى منسق';
            });
    }
}
