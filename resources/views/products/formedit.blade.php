@extends('layouts.master')
@section('content')
    <div class="container col-lg-6 mt-5">
        <div class="card">
            <div class="card-header pb-0">
                <h2>تعديل القسم</h2>
            </div>
            <div class="card-body">
                <form action="{{ Route('productupdate', $product->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم المنتج</label>
                        <input type="text" class="form-control" id="Product_name" name="Product_name"
                            value="{{ $product->Product_name }}">
                    </div>
                    <div class="form-group">
                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">
                            القسم   </label><span>({{ $sec_name->section_name}})</span>
                        <select name="section_id" id="section_id" class="form-control">
                            <option value="" selected disabled> --حدد القسم--</option>
                            @foreach ($section as $section)
                                <option value="{{ $section->section_id }}">{{ $section->section_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">ملاحظات</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">حفظ التغيرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection





