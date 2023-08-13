<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Exception;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $query = Employee::query();
        
        $name = $request->query('name');
        
        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }
        
        $user = Auth::user();
        $isAdmin = empty($user->store_id);
        
        if ($isAdmin) {
            $employees = $query->paginate(2); 
        } else {
            $employees = $user->employees()->where(function ($query) use ($name) {
                if ($name) {
                    $query->where('name', 'LIKE', "%{$name}%");
                }
            })->paginate(2); 
        }     
        return view('dashboard.VendorAdmin.employees.index', compact('employees'));
    }
    
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $employee= new Employee();   
        return view('dashboard.VendorAdmin.employees.create', compact( 'employee'));
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
        $request->validate(Employee::rules(),[
            'required'=>'This field(:attribute) is required',
            'name.unique'=>'This name is already exists!'
          ]);
        
          $data = $request->except('image');
          $data['image']= $this->uploadImage($request);  
          $user = Auth::user();
          $category = $user->employees()->create($data);
          return redirect()->route('employees.index')
         ->with('success','Employee created!');
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
            $employee = Employee::findorfail($id);      
            }catch(Exception $e){
                return redirect()->route('employees.index')
                ->with('info','Record not found');
              }
            return view('dashboard.VendorAdmin.employees.edit', compact('employee'));
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
        $request->validate(Employee::rules($id));
        $employee=Employee::findOrFail($id);   
        $old_image =$employee->image;
        $data = $request->except('image');
         $new_image= $this->uploadImage($request);   
         if($new_image){
            $data['image']=$new_image;
          }
          $employee->update($data);
          if($old_image && $new_image){
            Storage::disk('public')->delete($old_image);
    }
        return redirect()->route('employees.index')
          ->with('success','Employee updated!');
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
        $employee=Employee::findOrFail($id);      
        $employee->delete();
        /*if($category->image){
            Storage::disk('public')->delete($category->image);
          } */
        return redirect()->route('employees.index')
        ->with('success','Employee deleted!');
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
        $employees= Employee::onlyTrashed()->paginate();
        return view('dashboard.VendorAdmin.employees.trash',compact('employees'));
       }
   
       public function restore(Request $request,$id){
          $employee = Employee::onlyTrashed()->findOrfail($id);
          $employee->restore();
          return redirect()->route('employees.trash')
          ->with('success','employee restored!');
        }
   
        public function forceDelete($id){
         $employee = Employee::onlyTrashed()->findOrfail($id);
         $employee->forceDelete();
         if($employee->image){
           Storage::disk('public')->delete($employee->image);
         }
         return redirect()->route('employees.trash')
         ->with('success','employee deleted forever!');
       }
}
