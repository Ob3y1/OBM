@extends('layouts.admin')

@section('title')
    Edit Page
@endsection
@section('content')
<nav class="navbar bg-body-tertiary ">
        <div class="container-fluid  justify-content-md-between">
            <a class="navbar-brand fw-normal fs-4 mb-1 mb-md-0 d-none d-sm-block ">Edit Partner</a>
            <div class="d-flex"><a href="{{ route('partnerships') }}" class=" me-2 btn btn-outline-primary" data-bs-toggle="tooltip"
                data-bs-placement="bottom" data-bs-title="pre page"><i class="bi bi-arrow-90deg-left"></i></a>
            </div>
        </div>
    </nav>
@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <div class="d-flex justify-content-center align-items-center my-5">
        <div class="card card-primary card-round w-50 ">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Edit Partner</div>
                </div>
            </div>
            <div class="card-body pb-0">
                <form action="{{ route('updatepar', $partner->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="fw-bold mt-4 ">
                        <label class="card-title h5 ">Name :</label>
                        <input type="text" aria-label="name"  class="form-control text-primary border-primary" required
                            id="name" name="name" value="{{$partner->name}}">
                            
                        <div class="invalid-feedback">
                            رجاءً ادخل الاسم الكامل
                        </div>
                    </div>
                
                    <div class="fw-bold mt-4 ">
                        <label class="card-title h5 ">Capital :</label>
                        <input type="text" aria-label="capital"  class="form-control text-primary border-primary" required
                            id="capital" name="capital"  value="{{$partner->capital}}">
                            
                        <div class="invalid-feedback">
                            رجاءً ادخل المبلغ الكامل
                        </div>
                    </div>

                    <div class="fw-bold mt-4 ">
                        <label class="card-title h5 ">Capital Percentage :</label>
                        <input type="text" aria-label="capital_percentage"  class="form-control text-primary border-primary" required
                            id="capital_percentage" name="capital_percentage" value="{{$partner->capital_percentage}}">
                            
                        <div class="invalid-feedback">
                            رجاءً ادخل النسبة 
                        </div>
                    </div>

                                
                    <div class="fw-bold my-4 ">
                        <label class="card-title h5 ">Profit Percentage :</label>
                        <input type="text" aria-label="profit_percentage"  class="form-control text-primary border-primary" required
                            id="profit_percentage" name="profit_percentage" value="{{$partner->profit_percentage}}">
                            
                        <div class="invalid-feedback">
                            رجاءً ادخل النسبة 
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mb-4">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection