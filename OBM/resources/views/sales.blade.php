@extends('layouts.admin')

@section('title')
    Sales Page
@endsection

@section('content')
                <nav   nav class="navbar bg-body-tertiary">
                    <div class="container-fluid  justify-content-md-between">
                        <a class="navbar-brand fw-normal fs-4 mb-1 mb-md-0 d-none d-sm-block ">Sales Informations</a>
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
                                            <div class="card-title">Add New User</div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <form method="POST" action="{{ route('adduser')}}">
                                            @csrf 
                                                <div class="fw-bold mt-4 ">
                                                    <label class="card-title h5 ">Name :</label>
                                                    <input type="text" aria-label="name"  class="form-control text-primary border-primary" required
                                                        id="name" name="name">
                                                        
                                                    <div class="invalid-feedback">
                                                        رجاءً ادخل الاسم الكامل
                                                    </div>
                                                </div>
                                            
                                            <div class=" fw-bold mt-4">
                                                <label class="card-title h5  ">Phone:</label>
                                                <div class="input-group" dir="ltr">
                                                    <span class="input-group-text text-primary border-primary">+963</span>
                                                    <input type="tel"  maxlength="10" pattern="09+[0-9]{8}"
                                                        class="form-control text-primary border-primary rounded-end-2"  id="inputnum" name="phone_number">
                                                    <div class="invalid-feedback" dir="rtl">
                                                        رجاء ادخل رقم صحيح
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" fw-bold mt-4">
                                                <label class="card-title h5  ">Password:</label>
                                                <input type="password" class="form-control text-primary border-primary" id="inputPassword4" maxlength="8"
                                                    pattern="(?=.*\d)(?=.*[a-z]).{4,8}" name="password"
                                                    title="Must contain at least one  number and lowercase letter, and between 4 - 8 characters">
                                                    <input type="checkbox" class="form-check-input text-primary border-primary mt-1" onclick="togglePasswordVisibility()" /> <div class="d-inline">Show Password</div>

                                                <div class="invalid-feedback ">
                                                    يجب أن يحتوي على رقم واحد وحرف صغير على الأقل، وبين 4 - 8 أحرف
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between fw-bold my-2" dir='rtl'>
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
                                            <div class="card-title">Users</div>
                                            <form class="d-flex" role="search" action="{{ route('searchuser') }}" method="POST">
                                                @csrf
                                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="name">
                                                <button class="btn btn-outline-success" type="submit">Search</button>
                                            </form>
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
                                                        <th scope="col" class="text-end"> Role</th>
                                                        <th scope="col" class="text-end"> Orders</th>
                                                        <th scope="col" class="text-end"> Phone</th>
                                                        <th scope="col" class="text-end">Order</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($users as $admins)
                                                    <tr>
                                                        <th scope="row">
                                                            
                                                            {{ $admins->id ?? 'غير متوفر' }}
                                                        </th>
                                                        <td class="text-end">{{ $admins->name ?? 'غير متوفر' }}</td>
                                                        <td class="text-end">{{ $admins->role->role ?? 'غير متوفر' }}</td>
                                                        <td class="text-end">{{ $admins->order_count }}</td>
                                                        <td class="text-end">{{ $admins->phone_number }}</td>
                                                        <td class="text-end">
                                                        <a href="{{ route('order', $admins->id) }}"  style="display:inline-block;">
                                                            <button type="submit" class="btn btn-success btn-sm" >Order</button>
                                                        </a>  
                                                        </td>  
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-center mt-4">
                                                {{ $users->links() }}
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
                                            <div class="card-title">Available Orders </div>
                                            
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
                                                        <th scope="col" class="text-end"> Products</th>
                                                        <th scope="col" class="text-end"> Cost</th>
                                                        <th scope="col" class="text-end"> Price</th>
                                                        <th scope="col" class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                    <tr>
                                                        <th scope="row">
                                                            
                                                            {{ $order->id ?? 'غير متوفر' }}
                                                        </th>
                                                        <td class="text-end">{{ $order->user->name ?? 'غير متوفر' }}</td>
                                                        <td class="text-end">{{ $order->location ?? '---' }}</td>
                                                        <td class="text-end">{{ $order->orderItem_count }}</td>
                                                        <td class="text-end">{{ $order->cost }}</td>
                                                        <td class="text-end">{{ $order->total }}</td>
                                                        <td class="text-end">
                                                            <a href="{{ route('infoorder', $order->id) }}"  style="display:inline-block;">
                                                                <button type="submit" class="btn btn-success btn-sm" >Information</button>
                                                            </a>  
                                                        </td>  
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- ✅ روابط التنقل بين الصفحات -->
                                            <div class="d-flex justify-content-center mt-4">
                                                {{ $orders->links() }}
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
                                            <div class="card-title">Finished Orders </div>
                                           
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
                                                        <th scope="col" class="text-end"> Products</th>
                                                        <th scope="col" class="text-end"> Cost</th>
                                                        <th scope="col" class="text-end"> Price</th>
                                                        <th scope="col" class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($finishedorders as $order)
                                                    <tr>
                                                        <th scope="row">
                                                            
                                                            {{ $order->id ?? 'غير متوفر' }}
                                                        </th>
                                                        <td class="text-end">{{ $order->user->name ?? 'غير متوفر' }}</td>
                                                        <td class="text-end">{{ $order->location ?? '---' }}</td>
                                                        <td class="text-end">{{ $order->orderItem_count }}</td>
                                                        <td class="text-end">{{ $order->cost }}</td>
                                                        <td class="text-end">{{ $order->total }}</td>
                                                        <td class="text-end">
                                                            <a href="{{ route('infofinishedorder', $order->id) }}"  style="display:inline-block;">
                                                                <button type="submit" class="btn btn-success btn-sm" >Information</button>
                                                            </a>  
                                                        </td>  
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- ✅ روابط التنقل بين الصفحات -->
                                            <div class="d-flex justify-content-center mt-4">
                                                {{ $finishedorders->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
