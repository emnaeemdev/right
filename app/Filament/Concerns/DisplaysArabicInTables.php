<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;

trait DisplaysArabicInTables
{
    protected static function arabicTitleColumn(string $name = 'title', string $label = 'العنوان'): \Filament\Tables\Columns\TextColumn
    {
        return \Filament\Tables\Columns\TextColumn::make($name)
            ->label($label)
            ->getStateUsing(fn (Model $record): string => (string) $record->getTranslation($name, 'ar'));
    }

    protected static function arabicTextColumn(string $field, string $label): \Filament\Tables\Columns\TextColumn
    {
        return \Filament\Tables\Columns\TextColumn::make($field)
            ->label($label)
            ->getStateUsing(fn (Model $record): string => (string) $record->getTranslation($field, 'ar'));
    }
}
