<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class DonorAllocationChart extends ChartWidget
{
    protected ?string $heading = 'Donor Allocation Chart';

    protected function getData(): array
    {
        $fundSources = \App\Models\FundSource::where('is_active', true)->get();

        return [
            'datasets' => [
                [
                    'label' => 'USD Commitment',
                    'data' => $fundSources->pluck('initial_usd_balance')->toArray(),
                    'backgroundColor' => [
                        '#3b82f6', // blue
                        '#10b981', // green
                        '#f59e0b', // amber
                        '#ef4444', // red
                        '#8b5cf6', // purple
                    ],
                ],
            ],
            'labels' => $fundSources->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
