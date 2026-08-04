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
            Stat::make(__('admin.widgets.training_bags'), TrainingBag::query()->count())
                ->description(__('admin.widgets.training_bags_desc'))
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),
            Stat::make(__('admin.widgets.projects'), Project::query()->count())
                ->description(__('admin.widgets.projects_desc'))
                ->descriptionIcon('heroicon-m-folder')
                ->color('success'),
            Stat::make(__('admin.widgets.experts'), Expert::query()->count())
                ->description(__('admin.widgets.experts_desc'))
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
            Stat::make(__('admin.widgets.pending_inquiries'), $pendingInquiries)
                ->description(__('admin.widgets.pending_inquiries_desc', [
                    'consultations' => $pendingConsultations,
                    'quotes' => $pendingQuotes,
                    'messages' => $unreadMessages,
                ]))
                ->descriptionIcon('heroicon-m-inbox')
                ->color($pendingInquiries > 0 ? 'danger' : 'gray'),
        ];
    }
}
