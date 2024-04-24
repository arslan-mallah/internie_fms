<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\categories;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Auth;
class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:showcategories', ['only' => ['index']]);
        $this->middleware('role_or_permission:createcategories', ['only' => ['store']]);
        $this->middleware('role_or_permission:deletecategories', ['only' => ['destroy']]);
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data_general1=categories::all();
                         
        return view('categories.index',['data_general'=> $data_general1]);


    }


    public function store(Request $request)
    {

        // validation 

        $request->validate([
            'category'=>'required',
        ]);

        $permission = Permission::create(['name'=>$request->category]);

        $category = categories::create(['category'=>$request->category]);

        return redirect()->back()->withSuccess('category created !!!');

        
    }


    public function destroy(Permission $permission,Request $request)
    {

        $categories = categories::where('id', $request->id)->first();

if ($categories) {
    $categories->delete();
    $permission->delete();
    return redirect()->back()->withSuccess('Permission deleted !!!');

    // Deletion successful
} else {
    return redirect()->back()->withSuccess('Somethingwent wrong !!!');

    // User not found
}
     

    }
  
}