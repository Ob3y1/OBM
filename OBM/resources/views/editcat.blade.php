@extends('layouts.admin')

@section('title')
    Update Page
@endsection

@section('content')
<nav class="navbar bg-body-tertiary ">
        <div class="container-fluid  justify-content-md-between">
            <a class="navbar-brand fw-normal fs-4 mb-1 mb-md-0 d-none d-sm-block ">Edit Category</a>
            <div class="d-flex"><a href="{{ route('category') }}" class=" me-2 btn btn-outline-primary" data-bs-toggle="tooltip"
                data-bs-placement="bottom" data-bs-title="pre page"><i class="bi bi-arrow-90deg-left"></i></a>
            </div>
        </div>
    </nav>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card card-primary card-round w-50 ">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Edit Category</div>
                </div>
            </div>
            <div class="card-body pb-0">
                <form action="{{ route('updatecat', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label ">Name</label>
                        <input type="text" name="name" class="form-control text-primary border-primary" value="{{ $category->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label  ">Description</label>
                        <textarea name="description" class="form-control text-primary border-primary">{{ $category->description }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary mb-4">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection

