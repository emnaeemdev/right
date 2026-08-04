<?php

namespace App\Filament\Support;

class DocumentUpload
{
    public const MIME_TYPES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    public static function pdfField(string $name = 'pdf_path', string $directory = 'documents'): \Filament\Forms\Components\FileUpload
    {
        return \Filament\Forms\Components\FileUpload::make($name)
            ->label('ملف PDF')
            ->disk('public')
            ->directory($directory)
            ->acceptedFileTypes(['application/pdf'])
            ->downloadable()
            ->openable();
    }

    public static function wordField(string $name = 'word_path', string $directory = 'documents'): \Filament\Forms\Components\FileUpload
    {
        return \Filament\Forms\Components\FileUpload::make($name)
            ->label('ملف Word')
            ->disk('public')
            ->directory($directory)
            ->acceptedFileTypes([
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])
            ->downloadable()
            ->openable();
    }
}
