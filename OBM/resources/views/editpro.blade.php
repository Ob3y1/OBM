@extends('layouts.admin')

@section('title')
    Edit Page
@endsection
@section('content')
<nav class="navbar bg-body-tertiary ">
        <div class="container-fluid  justify-content-md-between">
            <a class="navbar-brand fw-normal fs-4 mb-1 mb-md-0 d-none d-sm-block ">Edit Product</a>
            <div class="d-flex"><a href="{{ route('category') }}" class=" me-2 btn btn-outline-primary" data-bs-toggle="tooltip"
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

    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card card-primary card-round w-50 ">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Edit Product</div>
                </div>
            </div>
            <div class="card-body pb-0">
                <form action="{{ route('updatepro', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label ">Name</label>
                        <input type="text" name="name" class="form-control text-primary border-primary" value="{{ $product->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label  ">Description</label>
                        <textarea name="description" class="form-control text-primary border-primary">{{ $product->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control  text-primary border-primary" required value="{{ $product->price }}">
                    </div>
                    <div class="mb-3">
                        <label for="cost" class="form-label">Cost</label>
                        <input type="text" name="cost" class="form-control  text-primary border-primary" required value="{{ $product->cost }}">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control text-primary border-primary" required value="{{ $product->stock }}">
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" class="form-control text-primary border-primary" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>  

                    <button type="submit" class="btn btn-primary mb-4">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection