<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\RichEditor;

class ContentRichEditor extends RichEditor
{
    protected string $view = 'filament.forms.components.content-rich-editor';

    protected function setUp(): void
    {
        parent::setUp();

        $this->toolbarButtons([
            'bold',
            'italic',
            'underline',
            'strike',
            'link',
            'h2',
            'h3',
            'blockquote',
            'bulletList',
            'orderedList',
            'attachFiles',
            'undo',
            'redo',
        ]);
    }
}
