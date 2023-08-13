@extends('layouts.dashboard')
@section('title','reports')
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
                            <div class="col-xxl-12">
                        <!--begin::Mixed Widget 7-->
                        <div class="card card-xxl-stretch-50 mb-5 mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column p-0">
                                <!--begin::Stats-->
                                <div class="flex-grow-1 card-p pb-0">
                                    <div class="d-flex flex-stack flex-wrap">
                                        <div class="me-2">
                                            <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">Generate Reports</a>
                                            <div class="text-muted fs-7 fw-bold">Finance and accounting reports</div>
                                        </div>
                                        <div class="fw-bolder fs-3 text-primary">$24,500</div>
                                    </div>
                                </div>
                                <!--end::Stats-->
                                <!--begin::Chart-->
                                <div class="mixed-widget-7-chart card-rounded-bottom" data-kt-chart-color="primary" style="height: 150px"></div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Mixed Widget 7-->
                        <!--begin::Mixed Widget 10-->
                        <div class="card card-xxl-stretch-50 mb-5 mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
                                <!--begin::Hidden-->
                                <div class="d-flex flex-stack flex-wrap flex-grow-1 px-9 pt-9 pb-3">
                                    <div class="me-2">
                                        <span class="fw-bolder text-gray-800 d-block fs-3">Sales</span>
                                        <span class="text-gray-400 fw-bold">Oct 8 - Oct 26 21</span>
                                    </div>
                                    <div class="fw-bolder fs-3 text-primary">$15,300</div>
                                </div>
                                <!--end::Hidden-->
                                <!--begin::Chart-->
                                <div class="mixed-widget-10-chart" data-kt-color="primary" style="height: 175px"></div>
                                <!--end::Chart-->
                            </div>
                        </div>
                        <!--end::Mixed Widget 10-->
                    </div>                     
                            </div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->	
@endsection