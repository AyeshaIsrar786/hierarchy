<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


class CategoriesController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('category', compact('categories'));
    }

    public function subcategory($id) {
        $categories = Category::where("parent_id", $id)->get();
        $subcategory_id = $id;
        if (request()->wantsJson()) {
            return response()->json(['categories' => $categories, 'subcategory_id' => $subcategory_id]);
        } else {
            return view('subcategory', compact('categories', 'subcategory_id'));
        }
    }
    
    public function supplier($id) {
        $categories = Category::where("parent_id", $id)->get();
        $supplier_id = $id;
        if (request()->wantsJson()) {
            return response()->json(['categories' => $categories, 'supplier_id' => $supplier_id]);
        } else {
            return view('supplier', compact('categories', 'supplier_id'));
        }
    }

    public function product($id) {
        $categories = Category::where("parent_id", $id)->get();
        $product_id = $id;
        if (request()->wantsJson()) {
            return response()->json(['categories' => $categories, 'product_id' => $product_id]);
        } else {
            return view('product', compact('categories', 'product_id'));
        }
    }

    public function create(Request $request)
    {      
        $categories = new Category;
        $categories->name=$request['name'];
        if ($request->has('parent_id')) {
            $categories->parent_id = $request['parent_id'];
        } else {
            $categories->parent_id = null;
        }
        $categories->save();     
        return response()->json(['message' => 'Inserted successfully']);
    }

    public function view(Request $request)
    {
        $parentId = $request['id'];

        if ($parentId === null) {
            $categories = Category::whereNull('parent_id')->get();
        } 
        else 
        {
            $parentCategory = Category::find($parentId);
            if ($parentCategory) {
                $categories = $parentCategory->children;
            } 
            else 
            {
                $categories = [];
            }
        } 
        return response()->json(['categories' => $categories]);
    }    

    public function delete($id){
        $categories = Category::find($id);
        $categories->delete();
        return response()->json(['message' => 'Data has been deleted successfully']);
    }
}

