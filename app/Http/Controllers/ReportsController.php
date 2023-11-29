<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function reportsInvoicesindex()
    {
        return view('reports.invoices_report');
    }

    public function reportsInvoicessearch(Request $request)
    {
        $radio = $request->rdio ;
        $type = $request->type;
        $start_at = $request->start_at;
        $end_at = $request->end_at;
        $number = $request->invoice_number;
        if($radio == 1){
            if($type && $start_at =='' && $end_at == ''){
                if($type == 'كل الفواتير'){
                    $invoices = Invoices::all();
                }else{
                    $invoices = Invoices::where('Status','=', $type)->get();
                }
                return view('reports.invoices_report', compact(['type','invoices']));
            }else{
                $invoices = Invoices::whereBetween('invoice_Date',[$start_at,$end_at])->
                where('Status','=', $type)->get();
                return view('reports.invoices_report', compact(['type','start_at','end_at','invoices']));
            }
        }else{
            $invoices = Invoices::where('invoice_number','=', $number)->get();
            return view('reports.invoices_report', compact(['number','invoices']));
        }
    }

    public function reportsCustomer()
    {

    }
}
