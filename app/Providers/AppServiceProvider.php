<?php

namespace App\Providers;

use App\Models\Publication;
use App\Models\VideoItem;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        FilamentAsset::register([
            AlpineComponent::make('rich-editor', asset('js/filament/forms/components/rich-editor.js')),
        ], 'filament/forms');

        FilamentView::registerRenderHook(
            'panels::head.end',
            fn (): string => '<style>
                .fi-fo-rich-editor-editor align-right,
                .fi-fo-rich-editor-editor align-left,
                .fi-fo-rich-editor-editor align-center,
                .fi-fo-rich-editor-editor align-justify {
                    display: block;
                    width: 100%;
                    margin-bottom: 0.75rem;
                }
                .fi-fo-rich-editor-editor align-right p,
                .fi-fo-rich-editor-editor align-left p,
                .fi-fo-rich-editor-editor align-center p,
                .fi-fo-rich-editor-editor align-justify p {
                    margin-bottom: 0.75rem;
                }
                .fi-fo-rich-editor-editor align-right p:last-child,
                .fi-fo-rich-editor-editor align-left p:last-child,
                .fi-fo-rich-editor-editor align-center p:last-child,
                .fi-fo-rich-editor-editor align-justify p:last-child {
                    margin-bottom: 0;
                }
                .fi-fo-rich-editor-editor align-right { text-align: right !important; }
                .fi-fo-rich-editor-editor align-center { text-align: center !important; }
                .fi-fo-rich-editor-editor align-left { text-align: left !important; }
                .fi-fo-rich-editor-editor align-justify { text-align: justify !important; }
            </style>',
        );

        Route::bind('video', fn (string $value) => (new VideoItem)->resolveRouteBinding($value));
        Route::bind('paper', fn (string $value) => (new Publication)->resolveRouteBinding($value));
        Route::bind('activity', fn (string $value) => (new \App\Models\TrainingActivity)->resolveRouteBinding($value));
        Route::bind('trainingBag', fn (string $value) => (new \App\Models\TrainingBag)->resolveRouteBinding($value));
    }
}
