@extends('layouts.master')
@section('content')
    <div class="container col-lg-6 mt-5">
        <div class="card">
            <div class="card-header pb-0">
                <h2>تعديل القسم</h2>
            </div>
            <div class="card-body">
                <form action="{{ Route('sectionupdate', $sectionlist->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم القسم</label>
                        <input type="text" class="form-control" id="section_name" name="section_name"
                            value="{{ $sectionlist->section_name }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">ملاحظات</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $sectionlist->description }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">حفظ التغيرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
