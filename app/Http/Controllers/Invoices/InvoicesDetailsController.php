<?php

namespace App\Http\Controllers\Invoices;

use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Models\Invoices_details;
use Illuminate\Routing\Controller;
use App\Models\Invoices_attachment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    public function index($id)
    {
        $details = Invoices::find($id);
        $allstate = Invoices_details::where('id_Invoice',$id)->get();
        $attach = Invoices_attachment::where('invoice_id',$id)->get() ;
        return view('invoices.invoice_details',compact('details','allstate','attach'));
        // return $allstate;
    }

    public function viewfile($invoice_number,$file_name)
    {
        $filepath = public_path("invoices/$invoice_number/$file_name") ;
        return response()->file($filepath);
    }
    public function download($invoice_number,$file_name)
    {
        $filepath = public_path("invoices/$invoice_number/$file_name") ;
        return response()->download($filepath);
    }

    public function destroy(Request $request)
    {
        $file_name = $request->file_name;
        $invoice_number = $request->invoice_number;
        $attach_id = $request->id_file ;
        $file = Invoices_attachment::find($attach_id);
        $file->delete();
        $filepath = public_path("invoices/$invoice_number/$file_name");
        File::delete($filepath);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return redirect()->back();
    }
}
