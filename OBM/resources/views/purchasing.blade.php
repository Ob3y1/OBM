@extends('layouts.admin')

@section('title')
    Sales Page
@endsection

@section('content')
                <nav   nav class="navbar bg-body-tertiary">
                    <div class="container-fluid  justify-content-md-between">
                        <a class="navbar-brand fw-normal fs-4 mb-1 mb-md-0 d-none d-sm-block ">Purchasing Informations</a>
                    </div>
                </nav>
                <div class="container ">
                    <div class="page-inner">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if(session('errors'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('errors') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                   
                        



                        <div class="row my-4 ">
                            <div class="col-md-4">
                                <div class="card card-round">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title">Add New Supplier</div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <form method="POST" action="{{ route('addsupplier')}}">
                                            @csrf 
                                                <div class="fw-bold mt-4 ">
                                                    <label class="card-title h5 ">Name :</label>
                                                    <input type="text" aria-label="name"  class="form-control text-primary border-primary" required
                                                        id="name" name="name">
                                                        
                                                    <div class="invalid-feedback">
                                                        رجاءً ادخل الاسم الكامل
                                                    </div>
                                                </div>
                                                <div class="fw-bold mt-4 ">
                                                    <label class="card-title h5 ">Location :</label>
                                                    <input type="text" aria-label="location"  class="form-control text-primary border-primary" required
                                                        id="location" name="location">
                                                        
                                                    <div class="invalid-feedback">
                                                        رجاءً ادخل الموقع
                                                    </div>
                                                </div>
                                                <div class="fw-bold my-4 ">
                                                    <label class="card-title h5 ">Contact :</label>
                                                    <input type="text" aria-label="contact"  class="form-control text-primary border-primary" 
                                                        id="contact" name="contact">
                                                        
                                                    <div class="invalid-feedback">
                                                        رجاءً ادخل طريقة التواصل 
                                                    </div>
                                                </div>
                                           
                                           
                                            <div class="d-flex justify-content-between fw-bold my-4" dir='rtl'>
                                                    <button type="submit" class="btn btn-primary ">
                                                        <i class="fas fa-paper-plane me-1"></i> ADD
                                                    </button>
                                            </div>                                                  
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                
                                <div class="card card-round">
                                    <div class="card-header">
                                        <div class="navbar">
                                            <div class="card-title">Suppliers</div>
                                            
                                        </div>
                                    </div>
      
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <!-- Projects table -->
                                            <table class="table align-items-center mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col"> id</th>
                                                        <th scope="col" class="text-end"> Name</th>
                                                        <th scope="col" class="text-end"> Location</th>
                                                        <th scope="col" class="text-end"> Purchases</th>
                                                        <th scope="col" class="text-end"> Contact</th>
                                                        <th scope="col" class="text-end">Purchase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($suppliers as $admins)
                                                    <tr>
                                                        <th scope="row">
                                                            
                                                            {{ $admins->id ?? 'غير متوفر' }}
                                                        </th>
                                                        <td class="text-end">{{ $admins->name ?? 'غير متوفر' }}</td>
                                                        <td class="text-end">{{ $admins->location ?? 'غير متوفر' }}</td>
                                                        <td class="text-end">{{ $admins->purchase_count }}</td>
                                                        <td class="text-end">{{ $admins->contact }}</td>
                                                        <td class="text-end">
                                                        <a href="{{ route('purchase', $admins->id) }}"  style="display:inline-block;">
                                                            <button type="submit" class="btn btn-success btn-sm" >Purchase</button>
                                                        </a>  
                                                        </td>  
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-center mt-4">
                                                {{ $suppliers->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
    
                        

                        <div class="row my-4 ">
                         
                            <div class="col-md-12">
                                
                                <div class="card card-round">
                                    <div class="card-header">
                                        <div class="navbar">
                                            <div class="card-title"> Purchases </div>
                                            
                                        </div>
                                    </div>
      
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <!-- Projects table -->
                                            <table class="table align-items-center mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col"> id</th>
                                                        <th scope="col" class="text-end"> Name</th>
                                                        <th scope="col" class="text-end"> Items</th>
                                                        <th scope="col" class="text-end"> Total</th>
                                                        <th scope="col" class="text-end"> Date</th>
                                                        <th scope="col" class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($purchase as $order)
                                                    <tr>
                                                        <th scope="row">
                                                            
                                                            {{ $order->id ?? 'غير متوفر' }}
                                                        </th>
                                                        <td class="text-end">{{ $order->supplier->name ?? 'غير متوفر' }}</td>
                                                        <td class="text-end">{{ $order->purchaseItem_count }}</td>
                                                        <td class="text-end">{{ $order->total }}</td>
                                                        <td class="text-end">{{ $order->created_at->format('Y-m-d H:i') }}</td> <!-- التاريخ بشكل أنيق -->
                                                        <td class="text-end">
                                                            <a href="{{ route('infopurchase', $order->id) }}"  style="display:inline-block;">
                                                                <button type="submit" class="btn btn-success btn-sm" >Information</button>
                                                            </a>  
                                                        </td>  
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- ✅ روابط التنقل بين الصفحات -->
                                            <div class="d-flex justify-content-center mt-4">
                                                {{ $purchase->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
