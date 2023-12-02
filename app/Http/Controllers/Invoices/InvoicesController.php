<?php

namespace App\Http\Controllers\Invoices;

use App\Models\User;
use App\Models\Invoices;
use App\Models\Sections;
use Illuminate\Http\Request;
use App\Models\Invoices_details;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Invoices_attachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddinvoicesNotification;

class InvoicesController extends Controller
{
    function __construct()
    {
        $this->middleware('perimission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('perimission:اضافة فاتورة', ['only' => ['create', 'store']]);
        $this->middleware('perimission:تعديل فاتورة', ['only' => ['edit', 'update']]);
        $this->middleware('perimission:الفواتير المدفوعة', ['only' => ['invoicepaid']]);
        $this->middleware('perimission:الفواتير المدفوعة جزئيا', ['only' => ['invoicepartpaid']]);
        $this->middleware('perimission:الفواتير الغير مدفوعة', ['only' => ['invoiceunpaid']]);
        $this->middleware('perimission:تغير حالة الدفع', ['only' => ['stateedit','stateupdate']]);
        $this->middleware('perimission:حذف فاتورة', ['only' => ['destroy']]);
        $this->middleware('perimission:طباعةالفاتورة', ['only' => ['PrintInvoice']]);
    }

    public function index()
    {
        $invoice = Invoices::all();
        return view('invoices.invoices_list', compact('invoice'));
    }

    public function create()
    {
        $sections = Sections::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    public function store(Request $request)
    {
        // $validation= $request->validate([
        //     "invoice_number" =>'required',
        //     "invoice_Date"=>'required',
        //     "Due_date"=>'required',
        //     "Section"=>'required',
        //     "product"=>'required',
        //     "Amount_collection"=>'required',
        //     "Amount_Commission"=>'required',
        //     "Discount"=>'required',
        //     "Rate_VAT"=>'required',
        //     "Value_VAT"=>'required',
        //     "Total"=>'required',
        //     "note"=>'required',
        // ]);
        // insert in table invoices
        // invoices::create([

        // ]);

        // insert in table invoices
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        // insert in table invoices_details
        $invoice_id = Invoices::latest()->first()->id;
        $section = Sections::where('id', $request->Section)->first()->section_name;
        Invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        // insert in table invoices_attachment
        $invoices = invoices::latest()->first();
        $image = $request->file('pic');
        $invoice_number = $request->invoice_number;
        if ($image) {
            $filename = $image->getClientOriginalName();
            Invoices_attachment::create([
                'file_name' => $filename,
                'invoice_number' => $request->invoice_number,
                'Created_by' => (Auth::user()->name),
                'invoice_id' => $invoices->id,
            ]);

            $image_name = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('invoices/'.$invoice_number),$image_name);

        }
        $user = User::get();
        Notification::send($user,new AddinvoicesNotification($invoices));

        session()->flash('Add', 'تم اضافة القسم بنجاح ');
        return redirect()->route('invoiceslist');
    }

    public function getproduct($id)
    {
        $product = DB::table('products')->where('section_id', $id)->pluck('Product_name', 'id');
        return json_encode($product);
    }

    public function edit($id)
    {
        $invoice = Invoices::where('id',$id)->first();
        $sections = Sections::all();
        return view('invoices.edit',compact('invoice','sections'));
    }

    public function update($id, Request $request)
    {
        $invoiceup = invoices::find($id);
        $invoiceup->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);
        $invoicedetaills = Invoices_details::where('id_Invoice',$id)->first();
        $section = Sections::where('id', $request->Section)->first()->section_name;
            $invoicedetaills->update([
            'id_Invoice' => $id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $section,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);
        $invoiceattach = Invoices_attachment::where('invoice_id',$id)->first();
        $name_file= $invoiceattach->invoice_number;
        $invoiceattach->update([
            'invoice_number' => $request->invoice_number,
        ]);
        $new_name = $request->invoice_number ;
        $oldFilePath = public_path('invoices/'.$name_file);
        $newFilePath = public_path('invoices/'.$new_name);
        File::move($oldFilePath, $newFilePath);
        // $request->session()->flash('update', 'تم التعديل علي الفاتوره بنجاج');
        return redirect()->back()->with('update', 'تم التعديل علي الفاتوره بنجاج');

    }

    public function destory(Request $request)
    {
        $id = $request->invoice_id;
        $invoice_detels = Invoices::where('id',$id)->first();
        $invoice_detels->Delete();
        // $path = public_path("invoices/$invoice_detels->invoice_number");
        // File::delete($path);
        session()->flash('delete','تم حذف الفاتوره بنجاح');
        return redirect()->route('invoiceslist');
    }

    public function stateedit($id)
    {
        $invoice = invoices::where('id',$id)->first();
        return view('invoices.status_update',compact('invoice'));
    }

    public function stateupdate($id,Request $request)
    {
        $invoice = Invoices::where('id',$id)->first();
        $section = Sections::where('id', $request->Section)->first()->section_name;
        if($request->Status == 'مدفوعه'){
            $invoice->update([
                'Value_Status' => 1,
                'Status' =>$request->Status ,
                'Payment_Date' =>$request->Payment_Date,
            ]);
            $new_state = Invoices_details::create([
                'id_Invoice' => $id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $section,
                'Status' => 'مدفوعه',
                'Payment_Date' => $request->Payment_Date,
                'Value_Status' => 1,
                'note' => $request->note,
                'user' => (Auth::user()->name),
            ]);
        }else{
            $invoice->update([
                'Value_Status' => 3,
                'Status' =>$request->Status ,
                'Payment_Date' =>$request->Payment_Date,
            ]);
            $new_state = Invoices_details::create([
                'id_Invoice' => $id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $section,
                'Status' => 'غير مدفوعه',
                'Payment_Date' => $request->Payment_Date,
                'Value_Status' => 3,
                'note' => $request->note,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update','تم تحديث الحاله بنجاح');
        return redirect()->route('invoiceslist');
    }

    public function invoicepaid()
    {
        $invoice = Invoices::where('Value_Status',1)->get();
        return view('invoices.invoices_paied' , compact('invoice'));
    }
    public function invoiceunpaid()
    {
        $invoice = Invoices::where('Value_Status',2)->get();
        return view('invoices.invoices_unpaied' , compact('invoice'));
    }
    public function invoicepartpaid()
    {
        $invoice = Invoices::where('Value_Status',3)->get();
        return view('invoices.invoices_partpaid' , compact('invoice'));
    }

    public function PrintInvoice($id)
    {
        // $invoice = invoices::with('section')->where('id',$id)->first();
        $invoice = DB::table('invoices')->join('sections','invoices.section_id','=','sections.id')
        ->select('invoices.*','sections.section_name as sectionName')
        ->where('invoices.id',$id)
        ->first();
        return view('invoices.print_invoice',compact('invoice'));
    }
}
