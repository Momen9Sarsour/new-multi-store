<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Exception;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->store_id) {
            $stores = Store::where('id', $user->store_id)->get();
        } else {
            $stores = Store::all();
        }
        return view('dashboard.VendorAdmin.stores.index', compact('stores'));
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //$vendors=Vendor::all();
        $store=new Store();
        return view('dashboard.VendorAdmin.stores.create',compact('store'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //Request merge
         $request->merge([
            'slug'=> Str::slug($request->post('name'))
        ]);
        $data = $request->except('image');
        $data['image']= $this->uploadImage($request);          
        //mass assigment
        $store = Store::create($data);    
        //PRG
        return redirect()->route('stores.index')
        ->with('success','Store created!');

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
        try{
        $store = Store::findorfail($id);      
        }catch(Exception $e){
            return redirect()->route('stores.index')
            ->with('info','Record not found');
          }
        return view('dashboard.VendorAdmin.stores.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
       
        $store=Store::findOrFail($id);
        $old_image =$store->image;
        $data = $request->except('image');
         $new_image= $this->uploadImage($request); 
         if($new_image){
            $data['image']=$new_image;
          }
        $store->update($data);
        if($old_image && $new_image){
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('stores.index')
          ->with('success','Store updated!');
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
       /* $store=Store::findOrFail($id);    
        $store->delete();*/
        $store=Store::findOrFail($id);      
        $store->delete();
        if($store->image){
            Storage::disk('public')->delete($store->image);
          }
        return redirect()->route('stores.index')
        ->with('success','Store deleted!');
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
}
