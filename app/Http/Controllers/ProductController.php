<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /*
        This funtion will return all products with categories list
    */
    public function index(){
        $products = Products::orderby('updated_at', 'DESC')->paginate(5);
        $categories = Categories::all()->pluck('name', 'id');
        return view('products.index', compact('products', 'categories'));
    }

    /*
        This funtion will return to categories list
    */
    public function create(){
        $categories = Categories::all()->pluck('name', 'id');
        return view('products.create', compact('categories'));
    }

    /*
        This funtion will recive request in parmeter
        and will redirect to product list
    */
    public function store(Request $request){
        $product_data = $request->all();
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'category' => 'required|integer',
            'image' => 'mimes:jpeg,jpg,png|required|max:2000'
        ]);
   
         if ($validator->fails()) {
            return redirect('/add_product')
                        ->withErrors($validator)
                        ->withInput();
        }

        $image_name = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images/products'), $image_name);

        unset($product_data['_token']);

        unset($product_data['image']);
        $product_data['image'] = $image_name;

        $category_id = $product_data['category'];
        unset($product_data['category']);
        $product_data['category_id'] = $category_id;

        Products::create($product_data);


        return redirect('/list_product');

    }

    /*
        This funtion will recive product ID in parmeter
        and will return all products detalis of that ID with categories list
    */
    public function edit($id){
        $product = Products::all()->where('id', $id)->first();
        $categories = Categories::all()->pluck('name', 'id');
        return view('products.edit', compact('product', 'categories'));
    }

    /*
        This funtion will recive request in parmeter
        and will redirect to product list
    */
    public function update(Request $request){
        $product_data = $request->all();
        $id = $product_data['id'];
        unset($product_data['id']);
        unset($product_data['_token']);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'category' => 'required|integer',
            'image' => 'mimes:jpeg,jpg,png|required|max:2000'
        ]);
   
         if ($validator->fails()) {
            return redirect('/add_product')
                        ->withErrors($validator)
                        ->withInput();
        }

        $image_name = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images/products'), $image_name);

        unset($product_data['image']);
        $product_data['image'] = $image_name;

        $category_id = $product_data['category'];
        unset($product_data['category']);
        $product_data['category_id'] = $category_id;

        Products::where('id',$id)->update($product_data);
        return redirect('/list_product');
    }

    /*
        This funtion will recive product ID in parmeter
        and will return product list
    */
    public function destroy($id){
        $product = Products::findOrFail($id);
        $product->delete();

        return redirect('/list_product');        
    }
}
