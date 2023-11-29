<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Product;
use App\Models\Sections;
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

    public function reportsCustomerindex()
    {
        $sections = Sections::all();
        $products = Product::all() ;
        return view('reports.customers_report',compact(['sections','products']));
    }

    public function reportsCustomersearch(Request $request)
    {
        $sections_id = $request->Section ;
        $product_name = $request->product;
        $start_at = $request->start_at ;
        $end_at = $request->end_at;

        $sections = Sections::all();
        $products = Product::all() ;

        if($sections_id && $product_name && $start_at == '' && $end_at == ''){
            $invoices = Invoices::where('section_id',$sections_id)->where('product',$product_name)->get();
            return view('reports.customers_report',compact(['sections','sections_id','product_name','products','invoices']));
        }else{
            $invoices = Invoices::whereBetween('invoice_Date',[$start_at,$end_at])
            ->where('section_id',$sections_id)->where('product',$product_name)->get();
            return view('reports.customers_report',compact(
                ['sections','sections_id','product_name','products','start_at','end_at','invoices']
            ));
        }
    }
}
