<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    /*
        This funtion will return all categories
    */
    public function index(){
        $categories = Categories::orderby('updated_at', 'DESC')->paginate(5);
        return view('category.index', compact('categories'));
    }

    /*
        This funtion will return to create from of category
    */
    public function create(){
        return view('category.create');
    }

    /*
        This funtion will recive request in parmeter
        and will redirect to categories list
    */
    public function store(Request $request){
        $category_data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
        ]);
   
         if ($validator->fails()) {
            return redirect('/add_category')
                        ->withErrors($validator)
                        ->withInput();
        }
        unset($category_data['_token']);
        Categories::create($category_data);


        return redirect('/list_category');

    }

    /*
        This funtion will recive category ID in parmeter
        and will redirect to category detalis of that ID
    */
    public function edit($id){

        $category = Categories::all()->where('id', $id)->first();
        return view('category.edit', compact('category'));
    }

    /*
        This funtion will recive request in parmeter
        and will return all categories list
    */
    public function update(Request $request){
        $category_data = $request->all();
        $id = $category_data['id'];
        unset($category_data['id']);
        unset($category_data['_token']);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect('/edit_category/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        Categories::where('id',$id)->update($category_data);
        return redirect('/list_category');

    }

    /*
        This funtion will recive category ID in parmeter
        and will return categories list
    */
    public function destroy($id){
        Products::where('category_id', $id)->delete();
        $category = Categories::findOrFail($id);
        $category->delete();

        return redirect('/list_category');        
    }

}
