<?php

namespace App\Http\Controllers\Invoices;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Invoices_attachment;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentController extends Controller
{
    public function addattachment(Request $request)
    {
        $invoice_number = $request->invoice_number;
        $image = $request->file('file_name');
        $filename = $image->getClientOriginalName();
        $newattach = new Invoices_attachment();
        $newattach->file_name = $filename ;
        $newattach->invoice_number = $request->invoice_number ;
        $newattach->invoice_id = $request->invoice_id ;
        $newattach->Created_by = (Auth::user()->name);
        $newattach->save();

        $image_name = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('invoices/'.$invoice_number),$image_name);

        // $request->session()->flash('Add', 'تم اضافه المرفق بنجاح');
        return redirect()->back()->with('Add', 'تم اضافه المرفق بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices_attachment $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices_attachment $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_attachment $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoices_attachment $invoice_attachments)
    {
        //
    }
}
