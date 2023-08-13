@extends('layouts.dashboard')
@section('title','Categories')
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
                            <form  action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
							  @csrf
							  @include('dashboard.VendorAdmin.products._form')
							   </form>
                        </div>
						
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->	
@endsection