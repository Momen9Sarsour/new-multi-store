@extends('layouts.dashboard')
@section('title','Employees')
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
                            <a href="{{ route('employees.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
                            <a href="{{ route('employees.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a>
                            </div>
                            <x-alert type="success"/>
                            <x-alert type="info"/>
                            <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4"> 
                                <input name="name" placeholder="Name" type="text" class="form-control mx-2" :value="request('name')"
                                />       
                                </select>
                             <button class="btn btn-dark mx-2">Filter</button>                           
                            </form>
                            <table class="table">
                                <thead>
                                   <tr>
                                    <th></th>
                                    <th>Name</th>         
                                    <th>Email</th>
                                    <th>phone</th>
                                    <th>Address</th>
                                    <th>Ipan</th>
                                    <th colspan="2"></th>
                                    </tr>
                                 </thead>	
                                 <tbody>
                                 @forelse($employees as $employee)
                                    <tr>
								        <td><img src="{{asset('storage/'.$employee->image)}}" alt="" height="50"></td>
                                        <td>{{$employee->name }}</td>
                                        <td>{{$employee->email }}</td> 
                                        <td>{{$employee->phone_number}}</td>
                                        <td>{{$employee->address}}</td>
                                        <td>{{$employee->ipan}}</td>
                                        <td>
                                        <a href="{{ route('employees.edit',$employee->id)}}"class="btn btn-sm btn-outline-success ">Edit     </a>                          
                                        </td>
                                        <td>
                                          <form action="{{ route('employees.destroy', $employee->id) }}" method="post">
                                          @csrf
                                          @method('delete')
                                          <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                          </form>

                                        </td>
                                    </tr>
                                    @empty
                                     <tr>
                                      <td colspan="7">No employees defined.</td>
                                     </tr>
                                     @endforelse
                                  </tbody>
                                </table>
                                {{$employees->withQueryString()->appends(['search'=>1])->links()}}
                            </div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->	
@endsection
