<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('perimission:المنتجات', ['only' => ['index']]);
        $this->middleware('perimission:اضافة منتج', ['only' => ['create', 'store']]);
        $this->middleware('perimission:تعديل منتج', ['only' => ['edit', 'update']]);
        $this->middleware('perimission:حذف منتج', ['only' => ['destroy']]);
    }

    public function index()
    {
        $product = DB::table('products')->join('sections','products.section_id','=','sections.id')
        ->select('products.*','sections.section_name')
        ->get();
        $section = Sections::all() ;
        return view('products.products',compact('product','section'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Product_name' => ['required','string','min:6'],
            'section_id' => ['required','exists:sections,id'],
            'description' =>['required','string']
        ]);
        $product = new Product();
        $product->Product_name=$request->Product_name;
        $product->section_id=$request->section_id;
        $product->description=$request->description;
        $product->save();
        // $request->session()->flash('Add', 'تم اضافه المنتج بنجاح');
        return redirect()->route('productlist')->with('Add', 'تم اضافه المنتج بنجاح');
    }

    public function show(product $products)
    {
        //
    }

    public function edit(Request $request,$id)
    {
        $product = Product::find($id);
        $sec_name = Sections::where('id',$product->section_id)->first();
        $section = Sections::all();
        return view('products.formedit',compact('product','section','sec_name')) ;
    }


    public function update(Request $request, Product $products,$id)
    {
        $product= Product::find($id);
        $product->Product_name=$request->Product_name;
        if($product->section_id == null){
            $product->section_id=$request->section_id;
        }
        $product->section_id = $product->section_id;
        $product->description=$request->description;
        $product->save();
        return redirect()->route('productlist')->with('Add', 'تم تعديل المنتج بنجاح');
    }


    public function destroy(Request $request)
    {
        $product = Product::find($request->pro_id);
        $product->delete();
        return redirect()->route('productlist')->with('delete', 'تم حذف المنتج بنجاح');
    }
}
