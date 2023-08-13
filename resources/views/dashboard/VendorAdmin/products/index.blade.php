@extends('layouts.dashboard')
@section('title','products')
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
                            <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
                            <a href="{{ route('products.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a>
                            </div>
                            <x-alert type="success"/>
                            <x-alert type="info"/>
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
                                    <th>Created At</th>
                                    <th colspan="2"></th>
                                    </tr>
                                 </thead>	
                                 <tbody>
                                 @forelse($products as $product)
                                    <tr>
								       <td><img src="{{asset('storage/'.$product->image)}}" alt="" height="50"></td>
                                        <td>{{$product->id}}</td>
                                        <td>{{$product->name}}</td>
                                        <td>
                                        @if ($product->category)
                                      {{ $product->category->name }}
                                        @else
                                     No category
                                     @endif
                                      </td>
                                          <td>{{$product->store->name}}</td>
                                        <td>{{$product->status}}</td>
                                        <td>{{$product->created_at}}</td>
                                        <td>
                                        <a href="{{ route('products.edit',$product->id)}}"class="btnbtn-smbtn-outline-success ">Edit     </a>                          
                                        </td>
                                        <td>
                                          <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                          @csrf
                                          @method('delete')
                                          <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                          </form>

                                        </td>
                                    </tr>
                                    @empty
                                     <tr>
                                      <td colspan="9">No products defined.</td>
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
