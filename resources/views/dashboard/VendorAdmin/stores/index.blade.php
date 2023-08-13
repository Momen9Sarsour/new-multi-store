@extends('layouts.dashboard')
@section('title','Stores')
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
                            <div class="mb-5">
                            <a href="{{ route('stores.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
                            </div>
							@if(session()->has('success'))
                             <div class="alert-alert-success">
								{{(session('success'))}}
							 </div>
							@endif

							@if(session()->has('info'))
                             <div class="alert-alert-info">
								{{(session('info'))}}
							 </div>
							@endif
                            <table class="table">
                                <thead>
                                   <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th colspan="2"></th>
                                    </tr>
                                 </thead>	
                                 <tbody>
                                 @forelse($stores as $store)
                                    <tr>
								       <td><img src="{{asset('storage/'.$store->image)}}" alt="" height="50"></td>
                                        <td>{{$store->id}}</td>
                                        <td>{{$store->name}}</td>
                                        <td>{{$store->status}}</td>
                                        <td>{{$store->created_at}}</td>
                                        <td>
                                        <a href="{{ route('stores.edit',$store->id)}}"class="btnbtn-smbtn-outline-success ">Edit     </a>                          
                                        </td>
                                        <td>
                                          <form action="{{ route('stores.destroy', $store->id) }}" method="post">
                                          @csrf
                                          @method('delete')
                                          <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                          </form>

                                        </td>
                                    </tr>
                                    @empty
                                     <tr>
                                      <td colspan="7">No stores defined.</td>
                                     </tr>
                                     @endforelse
                                  </tbody>
                                </table>
                              
                            </div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->	
@endsection
