@if($errors->any())
<div class="alert alert-danger">
  <h3>Error Occured</h3>
  <ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
  </ul>
</div>
@endif
                               <div class="form-group py-4">
                               <x-form.input label="Employee Name" class="form-control-lg" role="input" name="name" :value="$employee->name"/>       
                               </div>   
							   <div class="form-group">
                               <x-form.label id="image">Image</x-form.label>
                               <x-form.input type="file" name="image" class="form-control" accept="image/*"/>
                                @if($employee->image)
                                <img src="{{asset('storage/'.$employee->image)}}" alt="" height="60">
                                @endif
                              </div>
                              <div class="form-group py-4">
                               <x-form.input label="Employee Email" type="email" class="form-control-lg" role="input" name="email" :value="$employee->email"/>       
                               </div>  
                               <div class="form-group py-4">
                               <x-form.input label="phone_number" type="number" class="form-control-lg" role="input" name="phone_number" :value="$employee->phone_number"/>       
                               </div> 
                               <div class="form-group py-4">
                               <x-form.input label="Address" class="form-control-lg" role="input" name="address" :value="$employee->address"/>       
                               </div>  
                               <div class="form-group py-4">
                                <x-form.input label="Ipan" type="number" class="form-control-lg" role="input" name="ipan" :value="$employee->ipan"/>       
                               </div>  
							  <div class="form-group">
                               <button type="submit" class="btn btn-primary">Save</button>
                               </div>  
