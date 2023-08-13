<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $request = request();
        $query = Product::query();     
        $name = $request->query('name');    
        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }      
        $user = Auth::user();
        $isAdmin = empty($user->store_id);
        
        if ($isAdmin) {
            $products = $query->paginate(3); 
        } else {
            $products = Product::with(['category','store'])->where(function ($query) use ($name) {
                if ($name) {
                    $query->where('name', 'LIKE', "%{$name}%");
                }
            })->paginate(3); 
        }     
        return view('dashboard.VendorAdmin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $product= new Product();   
        $user = Auth::user();
        $isAdmin = empty($user->store_id);
        
        if ($isAdmin) {
            $categories = Category::all();
        } else {
            $categories = $user->categories;
        }
        return view('dashboard.VendorAdmin.products.create', compact('product', 'categories', 'isAdmin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->store) {
            return redirect()->back()->with('error', 'You need to create a store first');
        }
    
        $baseSlug = Str::slug($request->post('name'));
        $uniqueSlug = $baseSlug;
        $i = 1;
    
        while (Product::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $baseSlug . '-' . $i;
            $i++;
        }
    
        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);
        $data['store_id'] = $user->store->id;
        $data['slug'] = $uniqueSlug;
    
        $product = Product::create($data);
        return redirect()->route('products.index')->with('success', 'Product created!');
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = Product::findOrfail($id);
        $user = Auth::user();
        $isAdmin = empty($user->store_id);
        
        if ($isAdmin) {
            $categories = Category::all();
        } else {
            $categories = $user->categories;
        }
        
        return view('dashboard.VendorAdmin.products.edit',compact('product','categories','isAdmin'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $product=Product::findOrFail($id);   
        $old_image =$product->image;
        $data = $request->except('image');
         $new_image= $this->uploadImage($request);   
         if($new_image){
            $data['image']=$new_image;
          }
          $product->update($data);
          if($old_image && $new_image){
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('products.index')
        ->with('success','Product updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product=Product::findOrFail($id);      
        $product->delete();
        if($product->image){
            Storage::disk('public')->delete($product->image);
        } 
        return redirect()->route('products.index')
        ->with('success','Product deleted!');
    }
    protected function uploadImage(Request $request){

        if(!$request->hasFile('image')){
          return;
        }
        $file =  $request->file('image');
        $path =  $file->store('uploads',[
              'disk'=>'public'
        ]);
        return $path;
        
    }


    public function trash(){
        $products= Product::onlyTrashed()->paginate();
        return view('dashboard.VendorAdmin.products.trash',compact('products'));
       }
   
       public function restore(Request $request,$id){
          $product= Product::onlyTrashed()->findOrfail($id);
          $product->restore();
          return redirect()->route('products.trash')
          ->with('success','product restored!');
        }
   
        public function forceDelete($id){
         $product = Product::onlyTrashed()->findOrfail($id);
         $product->forceDelete();
         if($product->image){
           Storage::disk('public')->delete($product->image);
         }
         return redirect()->route('products.trash')
         ->with('success','product deleted forever!');
       }
}
