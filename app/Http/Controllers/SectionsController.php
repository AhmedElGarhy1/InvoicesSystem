<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{

    function __construct()
    {
        $this->middleware('perimission:الاقسام', ['only' => ['index']]);
        $this->middleware('perimission:اضافة قسم', ['only' => ['create', 'store']]);
        $this->middleware('perimission:تعديل قسم', ['only' => ['edit', 'update']]);
        $this->middleware('perimission:حذف قسم', ['only' => ['destroy']]);
    }

    public function index()
    {
        $sectionlist = Sections::all();
        return view('sections.sections',compact('sectionlist'));
    }

    public function create($id)
    {

    }

    public function store(Request $request)
    {

        $name=Auth::user()->name;
        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
        ]
        ,[
            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
        ]);
        $section = new Sections();
        $section->section_name =$request->section_name ;
        $section->description =$request->description ;
        $section->Created_by =$name;
        $section->save();
        session()->flash('Add', 'تم اضافة القسم بنجاح ');
        return redirect()->route('sectionslist');
    }

    public function show(Sections $sections)
    {
        //
    }

    public function edit(Sections $sections ,$id)
    {
        $sectionlist = Sections::find($id);
        return view('sections.formedit',compact('sectionlist'));
    }

    public function update(Request $request,$id)
    {
        $section = Sections::find($id);
        $section->section_name =$request->section_name ;
        $section->description =$request->description ;
        $section->save();
        session()->flash('Add', 'تم تعديل القسم بنجاح ');
        return redirect()->route('sectionslist');
    }

    public function destroy(Request $request)
    {
        $id= $request->id;
        $section = Sections::find($id);
        $section->delete();
        session()->flash('Add', 'تم حذف القسم بنجاح ');
        return redirect()->route('sectionslist');
    }
}
