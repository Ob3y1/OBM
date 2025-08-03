@extends('layouts.admin')

@section('title')
    Information Page
@endsection

@section('content')
    <nav class="navbar bg-body-tertiary ">
        <div class="container-fluid  justify-content-md-between">
            <a class="navbar-brand fw-normal fs-4 mb-1 mb-md-0 d-none d-sm-block ">Information for {{ $category->name }}</a>
            <div class="d-flex"><a href="{{ route('category') }}" class=" me-2 btn btn-outline-primary" data-bs-toggle="tooltip"
                data-bs-placement="bottom" data-bs-title="pre page"><i class="bi bi-arrow-90deg-left"></i></a>
            </div>
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

 
            <div class="row mt-4 mb-4 ">
                <div class="col-md-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row ">
                                <div class="card-title">Products IN {{ $category->name }}</div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col" class="text-end">Name</th>
                                        <th scope="col" class="text-end">supplier</th>
                                        <th scope="col" class="text-end">Description</th>
                                        <th scope="col" class="text-end">Cost</th>
                                        <th scope="col" class="text-end">Price</th>
                                        <th scope="col" class="text-end">Stock</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $specialization)
                                        @php
                                            $suppliers = $specialization->purchaseItem->pluck('purchase.supplier.name')->filter()->unique()->implode('، ');
                                        @endphp

                                        <tr>
                                            <td>{{ $specialization->id }}</td>
                                            <td class="text-end">{{ $specialization->name }}</td>
                                            <td class="text-end">{{ $suppliers ?: 'لا يوجد' }}</td>
                                            <td class="text-end">{{ $specialization->description }}</td>
                                            <td class="text-end">{{ $specialization->cost  }}</td>
                                            <td class="text-end">{{ $specialization->price }}</td>
                                            <td class="text-end">{{ $specialization->stock }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('editpro', $specialization->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card card-primary card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Add Products in this Category</div>
                            </div>
                        </div>
                        <div class="card-body pb-0">
                            <form action="{{ route('addpro') }}" method="POST">
                                @csrf
                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                
                        
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="text" name="price" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cost" class="form-label">Cost</label>
                                    <input type="text" name="cost" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea type="text" name="description" class="form-control" ></textarea>
                                </div>
                                
                
                                <button type="submit" class="btn btn-success w-100 mb-3">Save Product</button>
                            </form> 
                        </div>
                    </div>
                    
                </div>                
            </div>
               
 
        </div>
    </div>   
@endsection
