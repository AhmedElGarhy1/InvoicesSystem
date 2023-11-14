<?php

namespace App\Http\Controllers\Invoices;

use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class InvoicesArchiveController extends Controller
{

    public function index()
    {
        $invoice = Invoices::onlyTrashed()->get();
        return view('invoices.invoices_archave',compact('invoice'));
    }

    public function archiveinvoices(Request $request)
    {
        $archive_invoice = Invoices::where('id',$request->invoice_id)->first();
        $archive_invoice->delete();
        session()->flash('archive_invoice','تم ارشفه الفاتوره بنجاح');
        return redirect()->route('arachaeinvoices') ;
    }


    public function restoreinvoice(Request $request)
    {
        $restore = Invoices::withTrashed()->where('id',$request->invoice_id)->restore();
        session()->flash('restore_invoice','تم استرجاع الفاتوره بنجاح');
        return redirect()->route('invoiceslist') ;
    }

    public function destorearachive(Request $request)
    {
        $invoice = Invoices::withTrashed()->where('id',$request->invoice_id)->first();
        $path = public_path("invoices/$invoice->invoice_number");
        File::deleteDirectory($path);
        $invoice->forceDelete();
        session()->flash('delete','تم حذف الفاتوره بنجاح');
        return back() ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
