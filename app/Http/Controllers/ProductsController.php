<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json(['products' => $products]);
    }

    public function create(Request $request)
    {         
        $products = new Product;
        $products->name = $request['name'];
        $products->parent_id = $request['parent_id'];
        $products->save();     
        return response()->json(['message' => 'Inserted successfully']);
    }

    public function view(Request $request)
    {
        $categoryId = $request->input('id');
        if ($categoryId === 'null') 
        {
            $products = Product::all();
        } 
        else 
        {
            $childCategoryIds = Category::where('id', $categoryId)
            ->orWhere('parent_id', $categoryId)->pluck('id');
            $products = Product::whereHas('category', function ($query) use ($categoryId) {$query->where('parent_id', $categoryId);
            })->get();
        }
        return response()->json(['products' => $products]);
    }

    public function viewsubcategory($id)
{
    $categories = Category::where("parent_id", $id)->get();
    $subcategory_id = $id;

    $childCategoryIds = Category::where('parent_id', $id)->pluck('id');

    $products = Product::whereHas('category', function ($query) use ($id, $childCategoryIds) {
        $query->whereIn('id', $childCategoryIds);
    })->get();

    return response()->json(['categories' => $categories, 'subcategory_id' => $subcategory_id, 'products' => $products]);
}

public function viewsupplier($id)
{
    $categories = Category::where("parent_id", $id)->get();
    $supplier_id = $id;

    $childCategoryIds = Category::where('parent_id', $id)->pluck('id');

    $products = Product::whereHas('category', function ($query) use ($id, $childCategoryIds) {
        $query->whereIn('id', $childCategoryIds);
    })->get();

    return response()->json(['categories' => $categories, 'supplier_id' => $supplier_id, 'products' => $products]);
}

public function viewproduct($id)
{
    $categories = Category::where("parent_id", $id)->get();
    $product_id = $id;

    $childCategoryIds = Category::where('parent_id', $id)->pluck('id');

    $products = Product::whereHas('category', function ($query) use ($id, $childCategoryIds) {
        $query->whereIn('id', $childCategoryIds);
    })->get();

    return response()->json(['categories' => $categories, 'product_id' => $product_id, 'products' => $products]);
}

    public function delete($id){
        $products = Product::find($id);
        $products->delete();
        return response()->json(['message' => 'Data has been deleted successfully']);
    }
}
