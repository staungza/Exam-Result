<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ResultResource;
use Filament\Widgets\ChartWidget;

class StudentAdminChart extends ChartWidget
{
    protected static ?string $heading = 'Pass Rate by Region';
    protected static string $color = 'warning';

    protected function getData(): array
    {
        $resultResource = new ResultResource();
        $data = $resultResource->chart();

        return [
            'datasets' => [
                [
                    'label' => 'Pass Rate (%)',
                    'data' => array_column($data['datasets'], 'data'),
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Change to 'bar', 'line', or other valid chart type as needed
    }

    protected function style(): array
    {
        return [
            'widget' => [
                'width' => '100%', // Ensure widget spans full width
            ],
            'canvas' => [
                'position' => 'absolute',
                'top' => '0',
                'left' => '0',
                'width' => '100%',
                'height' => '100%',
            ],
        ];
    }
}
