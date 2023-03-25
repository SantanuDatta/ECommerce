<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class TopSale extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->options([
            'responsive' => true,
            'legend' => [
                'position' => 'bottom',
                'labels' => [
                    'fontColor' => '#ffffff',
                    'fontFamily' => 'Fira Sans',
                ],
            ],
            'scales' => [
                'yAxes' => [[
                    'ticks' => [
                        'beginAtZero' => true,
                        'fontColor' => '#ffffff'
                    ],
                    'gridLines' => [
                        'display' => true,
                        'color' => '#3e3e3e'
                    ]
                ]],
                'xAxes' => [[
                    'ticks' => [
                        'fontColor' => '#ffffff'
                    ],
                    'gridLines' => [
                        'display' => true,
                        'color' => '#3e3e3e'
                    ]
                ]]
            ],
            'hover' => [
                'mode' => 'point',
                'intersect' => true,
            ],
        ]);
    }
}
