<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', \App\Models\User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            
            Stat::make('Total Teams', \App\Models\Team::count())
                ->description('All organizations')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('primary'),

            Stat::make('Active Subscriptions', \Laravel\Cashier\Subscription::where('stripe_status', 'active')->count())
                ->description('Paying customers')
                ->descriptionIcon('heroicon-m-currency-euro')
                ->color('success'),

            Stat::make('Google API Calls (30d)', \App\Models\ApiUsageLog::where('created_at', '>=', now()->subDays(30))->count())
                ->description('Place Details requests')
                ->descriptionIcon('heroicon-m-signal')
                ->color('warning'),
        ];
    }
}
