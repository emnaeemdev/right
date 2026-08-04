<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ConsultingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TrainingBagController;
use App\Http\Controllers\VideoController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::middleware([SetLocale::class . ':ar'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/services', [PageController::class, 'services'])->name('services');
    Route::get('/experts', [PageController::class, 'experts'])->name('experts');
    Route::get('/partners', [PageController::class, 'partners'])->name('partners');
    Route::get('/projects', [PageController::class, 'projects'])->name('projects');
    Route::get('/projects/{project}', [PageController::class, 'projectShow'])->name('projects.show');
    Route::get('/training-bags', [TrainingBagController::class, 'index'])->name('training-bags.index');
    Route::get('/training-bags/{trainingBag}', [TrainingBagController::class, 'show'])->name('training-bags.show');
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
    Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
    Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
    Route::post('/quote-request', [QuoteRequestController::class, 'store'])->name('quote.store');
    Route::get('/quote-request', [QuoteRequestController::class, 'index'])->name('quote-request');
    Route::get('/consulting', [ConsultingController::class, 'index'])->name('consulting');
    Route::post('/consulting', [ConsultingController::class, 'store'])->name('consulting.store');
    Route::get('/papers', [PublicationController::class, 'index'])->name('papers.index');
    Route::get('/papers/{paper}', [PublicationController::class, 'show'])->name('papers.show');
    Route::redirect('/publications', '/papers');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});

Route::prefix('en')->middleware([SetLocale::class . ':en'])->name('en.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/services', [PageController::class, 'services'])->name('services');
    Route::get('/experts', [PageController::class, 'experts'])->name('experts');
    Route::get('/partners', [PageController::class, 'partners'])->name('partners');
    Route::get('/projects', [PageController::class, 'projects'])->name('projects');
    Route::get('/projects/{project}', [PageController::class, 'projectShow'])->name('projects.show');
    Route::get('/training-bags', [TrainingBagController::class, 'index'])->name('training-bags.index');
    Route::get('/training-bags/{trainingBag}', [TrainingBagController::class, 'show'])->name('training-bags.show');
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
    Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
    Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
    Route::post('/quote-request', [QuoteRequestController::class, 'store'])->name('quote.store');
    Route::get('/quote-request', [QuoteRequestController::class, 'index'])->name('quote-request');
    Route::get('/consulting', [ConsultingController::class, 'index'])->name('consulting');
    Route::post('/consulting', [ConsultingController::class, 'store'])->name('consulting.store');
    Route::get('/papers', [PublicationController::class, 'index'])->name('papers.index');
    Route::get('/papers/{paper}', [PublicationController::class, 'show'])->name('papers.show');
    Route::redirect('/publications', '/en/papers');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
