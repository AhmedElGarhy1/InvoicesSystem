<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Sections;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $numberallInvoices = Invoices::count();
        $totalallInvoices = Invoices::sum('Total');
        $numberpaiedInvoices = Invoices::where('Value_Status', 1)->count();
        $totalpaiedInvoices = Invoices::where('Value_Status', 1)->sum('Total');
        $presentpaiedInvoices =  ($numberpaiedInvoices / $numberallInvoices) * 100;
        $numberunpaiedInvoices = Invoices::where('Value_Status', 2)->count();
        $totalunpaiedInvoices = Invoices::where('Value_Status', 2)->sum('Total');
        $presentunpaiedInvoices =  ($numberunpaiedInvoices / $numberallInvoices) * 100;
        $numberpartpaiedInvoices = Invoices::where('Value_Status', 3)->count();
        $totalpartpaiedInvoices = Invoices::where('Value_Status', 3)->sum('Total');
        $presentpartpaiedInvoices =  ($numberpartpaiedInvoices / $numberallInvoices) * 100;
        $barchart = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 300, 'height' => 200])
            ->labels(["الفواتير المدفوعه","الفواتير الغير مدفوعه","الفواتير المدفوعه جزئيا"])
            ->datasets([
                [
                    "label" => "الفواتير المدفوعه",
                    'backgroundColor' => ['#28a745'],
                    'data' => [$presentpaiedInvoices]
                ],
                [
                    "label" => "الفواتير الغير مدفوعه",
                    'backgroundColor' => ['#dc3545'],
                    'data' => [$presentunpaiedInvoices]
                ],
                [
                    "label" => "الفواتير المدفوعه جزئيا",
                    'backgroundColor' => ['#ffc107'],
                    'data' => [$presentpartpaiedInvoices]
                ]
            ])
            ->options([
                'scales' => [
                    'yAxes' => [
                        [
                            'ticks' => [
                                'beginAtZero' => true,
                                'min' => 0,
                                'max' => 100,
                                'stepSize'=>10,
                            ],
                        ],
                    ],
                ],
                'legend' => [
                    'display' => true,
                    'position' => 'left',
                    'labels' => [
                        'usePointStyle' => true,
                        'boxWidth' => 20,
                        'fontSize' => 12,
                    ],
                ],
            ]);
        $piechart = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 300, 'height' => 200])
            ->labels(["الفواتير المدفوعه","الفواتير الغير مدفوعه","الفواتير المدفوعه جزئيا"])
            ->datasets([
                [
                    'backgroundColor' => ['#28a745', '#dc3545','#ffc107'],
                    'hoverBackgroundColor' => ['#008000', '#FF0000','#FFFF00'],
                    'data' => [$presentpaiedInvoices, $presentunpaiedInvoices,$presentpartpaiedInvoices]
                ]
            ])
            ->options([
                'legend' => [
                    'display' => true,
                    'position' => 'left',
                    'labels' => [
                        'usePointStyle' => true,
                        'boxWidth' => 20,
                        'fontSize' => 12,
                    ],
                ],
            ]);
        return view('/dashboard', compact(
            'numberallInvoices',
            'totalallInvoices',
            'numberpaiedInvoices',
            'totalpaiedInvoices',
            'presentpaiedInvoices',
            'numberunpaiedInvoices',
            'totalunpaiedInvoices',
            'presentunpaiedInvoices',
            'numberpartpaiedInvoices',
            'totalpartpaiedInvoices',
            'presentpartpaiedInvoices',
            'barchart',
            'piechart'
        ));
    }
}
