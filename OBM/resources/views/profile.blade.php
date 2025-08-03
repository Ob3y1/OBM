@extends('layouts.admin')

@section('title')
    Profile Page
@endsection

@section('content')
                <nav   nav class="navbar bg-body-tertiary">
                    <div class="container-fluid  justify-content-md-between">
                        <a class="navbar-brand fw-normal fs-4 mb-1 mb-md-0 d-none d-sm-block ">Admins Informations</a>
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
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card card-stats card-round">
                                    <div class="card-header">
                                    <div class="card-title">Edit informations</div>
                                    </div>
                                    <div class="card-body">
                                        <form class=""   method="POST" action="{{ route('updateProfile')}}">
                                            @csrf
                                            @method('PUT')
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <label for="name" class="form-label">Name </label>
                                                    <input type="text" aria-label="name"  class="form-control text-primary border-primary" required
                                                        id="name" name="name" value="{{$admin->name}}">
                                                        
                                                    <div class="invalid-feedback">
                                                        رجاءً ادخل الاسم الكامل
                                                    </div>
                                                </div>







                                                <div class="col-md-4">

                                                    <label for="inputnum" class="form-label">Phone Number</label>
                                                    <div class="input-group" dir="ltr">
                                                        <span class="input-group-text text-primary border-primary">+963</span>
                                                        <input type="tel"  maxlength="10" pattern="09+[0-9]{8}"
                                                            class="form-control rounded-end-2 text-primary border-primary" required id="inputnum" name="phone_number" value="{{$localNumber}}">
                                                        <div class="invalid-feedback" dir="rtl">
                                                            رجاء ادخل رقم صحيح
                                                        </div>
                                                    </div>

                                                </div>



                                                <div class="col-md-4">

                                                    <label for="inputPassword4" class="form-label">Password</label>
                                                    <input type="password" class="form-control text-primary border-primary" id="inputPassword4" maxlength="8"
                                                        pattern="(?=.*\d)(?=.*[a-z]).{4,8}" name="password"
                                                        title="Must contain at least one  number and lowercase letter, and between 4 - 8 characters">
                                                        <input type="checkbox" class="form-check-input text-primary border-primary mt-1" onclick="togglePasswordVisibility()" /> <div class="d-inline">Show Password</div>

                                                    <div class="invalid-feedback">
                                                        يجب أن يحتوي على رقم واحد وحرف صغير على الأقل، وبين 4 - 8 أحرف
                                                    </div>
                                                </div>



                                            </div>

                                
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-start  ">
                                                <button type="submit" class="btn btn-primary  me-md-2">Submit</button>
                                                <button type="reset" class="btn btn-primary ">Reset</button>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        



                        <div class="row mt-4 mb-4 ">
                            <div class="col-md-4">
                                <div class="card card-round">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title">Add New Admin</div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <form method="POST" action="{{ route('addadmin')}}">
                                            @csrf 
                                            <div class="fw-bold row">
                                                <div class="col-md-8  ">
                                                    <label class="card-title h5 ">Name :</label>
                                                    <input type="text" aria-label="name"  class="form-control text-primary border-primary" required
                                                        id="name" name="name">
                                                        
                                                    <div class="invalid-feedback">
                                                        رجاءً ادخل الاسم الكامل
                                                    </div>
                                                </div>
                                                <div class="col-md-4" dir="ltr">
                                                    <label for="Role" class="card-title h5">Role :</label>
                                                    <select class="form-select text-primary border-primary" name="role_id" id="Role" required>
                                                        @foreach ($roles as $role)
                                                            <option value="{{$role->id}}">{{$role->role}}</option>
                                                        @endforeach

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        رجاءً اختر البلد
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" fw-bold mt-4">
                                                <label class="card-title h5  ">Phone:</label>
                                                <div class="input-group" dir="ltr">
                                                    <span class="input-group-text text-primary border-primary">+963</span>
                                                    <input type="tel"  maxlength="10" pattern="09+[0-9]{8}"
                                                        class="form-control text-primary border-primary rounded-end-2" required id="inputnum" name="phone_number">
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
                                        <div class="card-head-row">
                                            <div class="card-title">Admins</div>
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
                                                        <th scope="col" class="text-end"> Phone</th>
                                                        <th scope="col" class="text-end">Delete</th>
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
                                                        <td class="text-end">{{ $admins->phone_number }}</td>
                                                        <td class="text-end">
                                                        <form action="{{ route('deleteadmin', $admins->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>  
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
