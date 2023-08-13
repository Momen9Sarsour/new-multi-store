@extends('layouts.dashboard')
@section('title','Trashed products')
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
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">Back</a>
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
                            <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
                            <input name="name" placeholder="Name" type="text" class="form-control mx-2" :value="request('name')"
                            />
                             <button class="btn btn-dark mx-2">Filter</button>
                            </form>
                            <table class="table">
                                <thead>
                                   <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Name</th>         
                                    <th>Category</th>
                                    <th>Store</th>
                                    <th>Status</th>
                                    <th>Deleted At</th>
                                    <th colspan="2"></th>
                                    </tr>
                                 </thead>	
                                 <tbody>
                                 @forelse($products as $product)
                                    <tr>
								       <td><img src="{{asset('storage/'.$product->image)}}" alt="" height="50"></td>
                                        <td>{{$product->id}}</td>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->category->name}}</td>
                                        <td>{{$product->store->name}}</td>
                                        <td>{{$product->status}}</td>
                                        <td>{{$product->deleted_at}}</td>
                                        <td>
                                        <form action="{{ route('products.restore', $product->id) }}" method="post">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="btn btn-sm btn-outline-info ">Restore</button>
                                        </form>                         
                                        </td>
                                        <td>
                                        <form action="{{ route('products.force-delete', $product->id) }}" method="post">
                                         @csrf
                                         @method('delete')
                                         <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                       </form>
                                        </td>
                                    </tr>
                                    @empty
                                     <tr>
                                      <td colspan="7">No categories defined.</td>
                                     </tr>
                                     @endforelse
                                  </tbody>
                                </table>
                                {{$products->withQueryString()->appends(['search'=>1])->links()}}
                            </div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->	
@endsection