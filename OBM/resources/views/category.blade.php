@extends('layouts.admin')

@section('title')
Category Management Page
@endsection

@section('content')
    <div class="container ">
        <div class="page-inner">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h3 class="ms-2 mt-2">Categories</h3>
            <hr> 
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row ">
                                <div class="card-title">Category</div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col" class="text-end">Name</th>
                                        <th scope="col" class="text-end">Description</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category as $category1)
                                        <tr>
                                            <td >{{ $category1->id }}</td>
                                            <td class="text-end">{{ $category1->name }}</td>
                                            <td class="text-end">{{ $category1->description }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('editcat', $category1->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    
                                                <a href="{{ route('infocat', $category1->id) }}" class="btn btn-success btn-sm" >Information</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- ✅ روابط التنقل بين الصفحات -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $category->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card card-primary card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Add Category</div>
                            </div>
                        </div>
                        <div class="card-body pb-0">
                            <form action="{{ route('addcat') }}" method="POST" class="mb-2">
                                @csrf
                                <div class="mb-2">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea type="text" name="description" class="form-control" ></textarea>
                                </div>

                                <button type="submit" class="btn btn-success">Save</button>
                            </form> 
                        </div>
                    </div>
                    
                </div>                
            </div>
            <hr> 
            <div class="navbar">
                <h3 class="ms-2 ">Products</h3>
                <form class="d-flex" role="search" action="{{ route('searchpro') }}" method="POST">
                @csrf

                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="name">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <hr>    
            
            <div class="row mt-4 mb-4 ">
                
                <div class="col-md-12">
                     
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title"> Products</div>
                            </div>
                            <a href="{{ route('products.pdf') }}" class="btn btn-primary mb-3">
                                <i class="fas fa-download"></i> تحميل كـ PDF
                            </a>

                        </div>
                        <div class="card-body p-0">
                        <table class="table mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col" class="text-end">Name</th>
                                        <th scope="col" class="text-end">Category</th>
                                        <th scope="col" class="text-end">supplier</th>
                                        <th scope="col" class="text-end">Description</th>
                                        <th scope="col" class="text-end">Cost</th>
                                        <th scope="col" class="text-end">Price</th>
                                        <th scope="col" class="text-end">Stock</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product as $specialization)
                                            @php
                                                $suppliers = $specialization->purchaseItem->pluck('purchase.supplier.name')->filter()->unique()->implode('، ');
                                            @endphp

                                            <tr>
                                                <td>{{ $specialization->id }}</td>
                                                <td class="text-end">{{ $specialization->name }}</td>
                                                <td class="text-end">{{ $specialization->category->name }}</td>
                                                <td class="text-end">{{ $suppliers ?: 'لا يوجد' }}</td>
                                                <td class="text-end">{{ $specialization->description }}</td>
                                                <td class="text-end">{{  $specialization->cost }}</td>
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

            </div> 
        </div>
    </div>   
@endsection
