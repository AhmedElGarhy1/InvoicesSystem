<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $numberallInvoices = Invoices::count();
        $totalallInvoices = Invoices::sum('Total');
        $numberpaiedInvoices = Invoices::where('Value_Status',1)->count();
        $totalpaiedInvoices = Invoices::where('Value_Status',1)->sum('Total');
        $presentpaiedInvoices =  ($numberpaiedInvoices/$numberallInvoices)*100;
        $numberunpaiedInvoices = Invoices::where('Value_Status',2)->count();
        $totalunpaiedInvoices = Invoices::where('Value_Status',2)->sum('Total');
        $presentunpaiedInvoices =  ($numberunpaiedInvoices/$numberallInvoices)*100;
        $numberpartpaiedInvoices = Invoices::where('Value_Status',3)->count();
        $totalpartpaiedInvoices = Invoices::where('Value_Status',3)->sum('Total');
        $presentpartpaiedInvoices =  ($numberpartpaiedInvoices/$numberallInvoices)*100;
        return view('/dashboard',compact(
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
            'presentpartpaiedInvoices'
        ));
    }
}
