@extends('layouts.dashboard')
@section('title','Edit profile')
@section('menu')
@include('layouts.partials.NavVendorAdmin')
@endsection
@section('content')											
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<!--begin::Container-->
							<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                
								<!--begin::Page title-->
								
								<!--end::Page title-->
								
							</div>
							<!--end::Container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">          
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
                            <x-alert type="success"/>
                            <form  action="{{ route('profile.update') }}" method="post"  enctype="multipart/form-data">
							  @csrf
							  @method('patch')
                           
                              <div class="form-row">
                                <div class="col-md-6">
                                  <x-form.input name="first_name" label="First Name" :value="$user->profile->first_name"/>
                                 </div>
                              <div class="col-md-6">
                                <x-form.input name="last_name" label="Last Name" :value="$user->profile->last_name"/>
                              </div>
                              </div>
                         
                         <div class="form-row">
                           <div class="col-md-6">
                             <x-form.input name="birthday" type="date" label="Birthday" :value="$user->profile->birthday"  />
                            </div>
                        <div class="col-md-6">
                        <x-form.radio name="gender" label="Gender" :options="['male'=>'Male', 'female'=>'Female']" :checked="$user->profile->gender" />
                        </div>
                         </div>
                     <div class="form-row">
                      <div class="col-md-4">
                        <x-form.input name="street_address" label="Street Address" :value="$user->profile->street_address" />
                      </div>
                    <div class="col-md-4">
                     <x-form.input name="city" label="City"  :value="$user->profile->city" />
                    </div>
                   <div class="col-md-4">
                    <x-form.input name="state" label="State"  :value="$user->profile->state"/>
                 </div>
               </div>
              <div class="form-row">
                 <div class="col-md-4">
                <x-form.input name="postal_code" label="Postal Code" :value="$user->profile->postal_code"/>
               </div>
            <div class="col-md-4">
             <x-form.select name="country" :options="$countries" label="Country" :selected="$user->profile->country" />
           </div>
            <div class="col-md-4">
              <x-form.select name="locale" :options="$locales" label="Locale" :selected="$user->profile->locale"/>
           </div>
       </div>
      <button type="submit" class="btn btn-primary">Save</button>
							   </form>
                        </div>
						
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->	
@endsection
