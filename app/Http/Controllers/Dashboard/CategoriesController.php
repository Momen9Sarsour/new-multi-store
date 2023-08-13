<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Auth;
use Exception;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $user = Auth::user();
        $isAdmin = empty($user->store_id);
        $categories = Category::when(!$isAdmin, function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
        ->with('parent')
        ->select('categories.*')
        ->selectRaw('(SELECT count(*) FROM products WHERE status = "active" AND category_id=categories.id) as products_count')
        //->withCount('products as products_number')
        ->filter($request->query())->paginate(2);     
         return view('dashboard.VendorAdmin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $parents = Category::all();
        $category = new Category();   
        return view('dashboard.VendorAdmin.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate(Category::rules(),[
          'required'=>'This field(:attribute) is required',
          'name.unique'=>'This name is already exists!'
        ]);
        $request->merge([
            'slug'=> Str::slug($request->post('name'))
        ]);
        $data = $request->except('image');
        $data['image']= $this->uploadImage($request);    
        $user = Auth::user();
        $category = $user->categories()->create($data);
        //PRG
        return redirect()->route('categories.index')
       ->with('success','Category created!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        return view('dashboard.VendorAdmin.categories.show',[
          'category'=>$category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (Exception $e) {
            return redirect()->route('categories.index')
                ->with('info', 'Record not found');
        }
        
        $user = Auth::user();
        $isAdmin = empty($user->store_id);
        
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id, $user, $isAdmin) {
                $query->whereNull('parent_id')
                    ->orWhere(function ($subQuery) use ($id, $user, $isAdmin) {
                        $subQuery->where('parent_id', '<>', $id);
                        if (!$isAdmin) {
                            $subQuery->where('user_id', $user->id);
                        }
                    });
                
                if ($isAdmin) {
                    $query->orWhereNull('parent_id');
                }
            });
        
        if (!$isAdmin) {
            $parents->where('user_id', $user->id);
        }
        
        $parents = $parents->get();
        
        return view('dashboard.VendorAdmin.categories.edit', compact('category', 'parents'));
    }
    
    
        
         
            
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        //
        $request->validate(Category::rules($id));
        $category=Category::findOrFail($id);   
        $old_image =$category->image;
        $data = $request->except('image');
         $new_image= $this->uploadImage($request);   
         if($new_image){
            $data['image']=$new_image;
          }
          $category->update($data);
          if($old_image && $new_image){
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('categories.index')
          ->with('success','Category updated!');
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
        $category=Category::findOrFail($id);      
        $category->delete();
        /*if($category->image){
            Storage::disk('public')->delete($category->image);
          } */
        return redirect()->route('categories.index')
        ->with('success','Category deleted!');
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
      $categories= Category::onlyTrashed()->paginate();
      return view('dashboard.VendorAdmin.categories.trash',compact('categories'));
     }
 
     public function restore(Request $request,$id){
        $category = Category::onlyTrashed()->findOrfail($id);
        $category->restore();
        return redirect()->route('categories.trash')
        ->with('success','category restored!');
      }
 
      public function forceDelete($id){
       $category = Category::onlyTrashed()->findOrfail($id);
       $category->forceDelete();
       if($category->image){
         Storage::disk('public')->delete($category->image);
       }
       return redirect()->route('categories.trash')
       ->with('success','category deleted forever!');
     }
    }

