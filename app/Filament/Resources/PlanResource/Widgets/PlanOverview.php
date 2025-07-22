<?php

namespace App\Filament\Resources\PlanResource\Widgets;

use App\Models\Plan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PlanOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = [];

        $plans = Plan::query()
            ->withCount(['users' => fn ($query) => $query->where('plan_user.active', true)])
            ->get();

        $stats[] = Stat::make( __('Todos los planes'), $plans->sum('users_count'));

        foreach ($plans as $plan)
        {
            $stats[] = Stat::make($plan->name, $plan->users_count);
        }

        return $stats;
    }
}
