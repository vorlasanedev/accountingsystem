<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class DonorAllocationChart extends ChartWidget
{
    protected ?string $heading = 'Donor Allocation Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
