@extends('layouts.admin')

@section('title')
Partners Page
@endsection

@section('content')
                <nav   nav class="navbar bg-body-tertiary">
                    <div class="container-fluid  justify-content-md-between">
                        <a class="navbar-brand fw-normal fs-4 mb-1 mb-md-0 d-none d-sm-block ">Partners Informations</a>
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
                                            <div class="card-title">Add New Partner</div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <form method="POST" action="{{ route('addpartner')}}">
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
                                                    <label class="card-title h5 ">Capital :</label>
                                                    <input type="text" aria-label="capital"  class="form-control text-primary border-primary" required
                                                        id="capital" name="capital">
                                                        
                                                    <div class="invalid-feedback">
                                                        رجاءً ادخل المبلغ الكامل
                                                    </div>
                                                </div>
                          
                                                <div class="fw-bold mt-4 ">
                                                    <label class="card-title h5 ">Capital Percentage :</label>
                                                    <input type="text" aria-label="capital_percentage"  class="form-control text-primary border-primary" required
                                                        id="capital_percentage" name="capital_percentage">
                                                        
                                                    <div class="invalid-feedback">
                                                        رجاءً ادخل النسبة 
                                                    </div>
                                                </div>
                          
                                                            
                                                <div class="fw-bold my-4 ">
                                                    <label class="card-title h5 ">Profit Percentage :</label>
                                                    <input type="text" aria-label="profit_percentage"  class="form-control text-primary border-primary" required
                                                        id="profit_percentage" name="profit_percentage">
                                                        
                                                    <div class="invalid-feedback">
                                                        رجاءً ادخل النسبة 
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
                                            
                                        </div>
                                    </div>
      
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <!-- Projects table -->
                                            <table class="table align-items-center mb-0">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col" class="text-end">Name</th>
            <th scope="col" class="text-end">Capital</th>
            <th scope="col" class="text-end">Capital %</th>
            <th scope="col" class="text-end">Profit %</th>
            <th scope="col" class="text-end bg-success text-white">Capital Wallet</th>
            <th scope="col" class="text-end bg-primary text-white">Profit Wallet</th>
            <th scope="col" class="text-end bg-dark text-white">Total Wallet</th>
            <th scope="col" class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $admins)
        <tr>
            <th scope="row">{{ $admins->id ?? 'غير متوفر' }}</th>
            <td class="text-end">{{ $admins->name ?? 'غير متوفر' }}</td>
            <td class="text-end">{{ $admins->capital ?? 'غير متوفر' }}</td>
            <td class="text-end">{{ $admins->capital_percentage }}</td>
            <td class="text-end">{{ $admins->profit_percentage }}</td>
            <td class="text-end bg-success text-white">{{ $admins->capital_wallet}}</td>
            <td class="text-end bg-primary text-white">{{ $admins->profit_wallet }}</td>
            <td class="text-end bg-dark text-white">
                {{ $admins->capital_wallet + $admins->profit_wallet }}
            </td>
            <td class="text-end">
                <div class="d-flex justify-content-end flex-wrap gap-1">
                    <a href="{{ route('editpar', $admins->id) }}" class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('deletepar', $admins->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>

                    <a href="{{ route('partners.resetProfitWallet', $admins->id) }}" 
                       class="btn btn-outline-dark btn-sm"
                       onclick="return confirm('هل أنت متأكد من تصفير محفظة الأرباح؟');">
                        Reset Wallet
                    </a>
                </div>
            </td> 
        </tr>
        @endforeach
    </tbody>
</table>


                                           
                                       
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                         
                    </div>
                </div>
@endsection
