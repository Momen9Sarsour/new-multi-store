@extends('layouts.dashboard')
@section('title',$category->name)
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
                            <table class="table">
                              <thead>
                                <tr>
                                <th></th>
                               <th>Name</th>
                               <th>Store</th>
                              <th>Status</th>
                              <th>Created At</th>
                              </tr>
                             </thead>
                          <tboady>
      
                          @php 
                         $products = $category->products()->with('store')->paginate(5);
                         @endphp
                           @forelse($products as $product)
                          <tr>
                         <td><img src="{{asset('storage/'.$product->image)}}" alt="" height="50"></td>
                         <td>{{$product->name}}</td>
                         <td>{{$product->store->name}}</td>
                         <td>{{$product->status}}</td>
                         <td>{{$product->created_at}}</td>
                         </tr>
                         @empty
                         <tr>
                         <td colspan="5">No products defined.</td>
                        </tr>
                       @endforelse
                      </tboady>
                    </table> 
                    {{$products->links()}}
                        </div>
						
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->	
@endsection