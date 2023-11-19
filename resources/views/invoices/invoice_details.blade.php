@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('title')
    تفاصيل فاتورة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتوره</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body h-100">
                    <div class="row row-sm ">
                        <div class="panel panel-primary tabs-style-3">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu ">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li class=""><a href="#tab11" class="active" data-toggle="tab"><i
                                                    class="fa fa-laptop"></i> معلومات الفاتوره</a></li>
                                        <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i>حاله الدفع </a>
                                        </li>
                                        <li><a href="#tab13" data-toggle="tab"><i class="fa fa-cogs"></i> المرفقات</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab11">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-striped" style="text-align:center">
                                                <tbody>
                                                    <tr style="color: blue">
                                                        <th scope="row">#</th>
                                                        <th scope="row">رقم الفاتورة</th>
                                                        <th scope="row">تاريخ الاصدار</th>
                                                        <th scope="row">تاريخ الاستحقاق</th>
                                                        <th scope="row">القسم</th>
                                                        <th scope="row">المنتج</th>
                                                        <th scope="row">مبلغ التحصيل</th>
                                                        <th scope="row">مبلغ العمولة</th>
                                                        <th scope="row">الخصم</th>
                                                        <th scope="row">نسبة الضريبة</th>
                                                        <th scope="row">قيمة الضريبة</th>
                                                        <th scope="row">الاجمالي مع الضريبة</th>
                                                        <th scope="row">الحالة الحالية</th>
                                                        <th scope="row">ملاحظات</th>
                                                    </tr>
                                                    <tr>
                                                        <td>#</td>
                                                        <td>{{ $details->invoice_number }}</td>
                                                        <td>{{ $details->invoice_Date }}</td>
                                                        <td>{{ $details->Due_date }}</td>
                                                        <td>{{ $details->Section->section_name }}</td>
                                                        <td>{{ $details->product }}</td>
                                                        <td>{{ $details->Amount_collection }}</td>
                                                        <td>{{ $details->Amount_Commission }}</td>
                                                        <td>{{ $details->Discount }}</td>
                                                        <td>{{ $details->Rate_VAT }}</td>
                                                        <td>{{ $details->Value_VAT }}</td>
                                                        <td>{{ $details->Total }}</td>
                                                        @if ($details->Value_Status == 1)
                                                            <td><span
                                                                    class="badge badge-pill badge-success">{{ $details->Status }}</span>
                                                            </td>
                                                        @elseif($details->Value_Status == 2)
                                                            <td><span
                                                                    class="badge badge-pill badge-danger">{{ $details->Status }}</span>
                                                            </td>
                                                        @else
                                                            <td><span
                                                                    class="badge badge-pill badge-warning">{{ $details->Status }}</span>
                                                            </td>
                                                        @endif
                                                        <td>{{ $details->note }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab12">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-striped" style="text-align:center">
                                                <tbody>
                                                    <tr style="color: blue">
                                                        <th scope="row">#</th>
                                                        <th scope="row">رقم الفاتورة</th>
                                                        <th scope="row">القسم</th>
                                                        <th scope="row">المنتج</th>
                                                        <th scope="row">الحالة الحالية</th>
                                                        <th scope="row">تاريخ الدفع</th>
                                                        <th scope="row">تاريخ الاصافه</th>
                                                        <th scope="row">ملاحظات</th>
                                                        <th scope="row">المستخدم</th>
                                                    </tr>
                                                    @foreach ($allstate as $allstate)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $allstate->invoice_number }}</td>
                                                            <td>{{ $allstate->Section }}</td>
                                                            <td>{{ $allstate->product }}</td>

                                                            @if ($allstate->Value_Status == 1)
                                                                <td><span
                                                                        class="badge badge-pill badge-success">{{ $allstate->Status }}</span>
                                                                </td>
                                                            @elseif($allstate->Value_Status == 2)
                                                                <td><span
                                                                        class="badge badge-pill badge-danger">{{ $allstate->Status }}</span>
                                                                </td>
                                                            @else
                                                                <td><span
                                                                        class="badge badge-pill badge-warning">{{ $allstate->Status }}</span>
                                                                </td>
                                                            @endif
                                                            <td>{{ $allstate->Payment_Date }}</td>
                                                            <td>{{ $allstate->created_at }}</td>
                                                            <td>{{ $allstate->note }}</td>
                                                            <td>{{ $allstate->user }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab13">
                                        <div class="card card-statistics">
                                            <div class="card-body">
                                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                <h5 class="card-title">اضافة مرفقات</h5>
                                                <form method="POST" action="{{ route('addattachment') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile"
                                                            name="file_name" required>
                                                        <input type="hidden" id="customFile" name="invoice_number"
                                                            value="{{ $details->invoice_number }}">
                                                        <input type="hidden" id="invoice_id" name="invoice_id"
                                                            value="{{ $details->id }}">
                                                        <label class="custom-file-label" for="customFile">حدد
                                                            المرفق</label>
                                                    </div>
                                                    <br><br>
                                                    <button type="submit" class="btn btn-primary btn-sm "
                                                        name="uploadedFile">تاكيد</button>
                                                </form>
                                            </div>
                                            <br>
                                            <div class="table-responsive mt-15">
                                                <table class="table table-striped" style="text-align:center">
                                                    <tbody>
                                                        <tr style="color: blue">
                                                            <th scope="row">#</th>
                                                            <th scope="row">الفايل / الصوره</th>
                                                            <th scope="row">رقم الفاتورة</th>
                                                            <th scope="row">تاريخ الاصافه</th>
                                                            <th scope="row">المستخدم</th>
                                                            <th scope="row">العمليات</th>
                                                        </tr>
                                                        @foreach ($attach as $attach)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $attach->file_name }}</td>
                                                                <td>{{ $attach->invoice_number }}</td>
                                                                <td>{{ $attach->created_at }}</td>
                                                                <td>{{ $attach->Created_by }}</td>
                                                                <td colspan="2">
                                                                    <a class="btn btn-outline-success btn-sm"
                                                                        href="{{ url('invoices/View_file') }}/{{ $details->invoice_number }}/{{ $attach->file_name }}"
                                                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                        عرض
                                                                    </a>
                                                                    <a class="btn btn-outline-info btn-sm"
                                                                        href="{{ url('invoices/download') }}/{{ $attach->invoice_number }}/{{ $attach->file_name }}"
                                                                        role="button"><i
                                                                            class="fas fa-download"></i>&nbsp;
                                                                        تحميل
                                                                    </a>
                                                                    <button class="btn btn-outline-danger btn-sm"
                                                                        data-toggle="modal"
                                                                        data-file_name="{{ $attach->file_name }}"
                                                                        data-invoice_number="{{ $attach->invoice_number }}"
                                                                        data-id_file="{{ $attach->id }}"
                                                                        data-target="#delete_file">حذف
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- delete -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('invoicedelete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>
                        <input type="hidden" name="id_file" id="id_file" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>



@endsection
