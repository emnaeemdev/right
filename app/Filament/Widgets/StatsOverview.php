<?php

namespace App\Filament\Widgets;

use App\Models\ConsultationRequest;
use App\Models\ContactMessage;
use App\Models\Expert;
use App\Models\Project;
use App\Models\QuoteRequest;
use App\Models\TrainingBag;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $pendingConsultations = ConsultationRequest::query()->where('status', 'new')->count();
        $pendingQuotes = QuoteRequest::query()->where('status', 'new')->count();
        $unreadMessages = ContactMessage::query()->where('is_read', false)->count();
        $pendingInquiries = $pendingConsultations + $pendingQuotes + $unreadMessages;

        return [
            Stat::make('Training Bags', TrainingBag::query()->count())
                ->description('Total training bags')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),
            Stat::make('Projects', Project::query()->count())
                ->description('Total projects')
                ->descriptionIcon('heroicon-m-folder')
                ->color('success'),
            Stat::make('Experts', Expert::query()->count())
                ->description('Total experts')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
            Stat::make('Pending Inquiries', $pendingInquiries)
                ->description("{$pendingConsultations} consultations · {$pendingQuotes} quotes · {$unreadMessages} messages")
                ->descriptionIcon('heroicon-m-inbox')
                ->color($pendingInquiries > 0 ? 'danger' : 'gray'),
        ];
    }
}
