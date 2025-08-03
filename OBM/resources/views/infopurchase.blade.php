@extends('layouts.admin')

@section('title')
    Information Page
@endsection

@section('content')
    <nav class="navbar bg-body-tertiary ">
        <div class="container-fluid  justify-content-md-between">
            <a class="navbar-brand fw-normal fs-4 mb-1 mb-md-0 d-none d-sm-block ">Cart</a>
            <div class="d-flex"><a href="{{ route('purchasing') }}" class=" me-2 btn btn-outline-primary" data-bs-toggle="tooltip"
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
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
 
            <div class="row mt-4 mb-4 ">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row ">
                                <div class="card-title">Cart</div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-end">Product</th>
                                    <th scope="col" class="text-end">Supplier</th>
                                    <th scope="col" class="text-end">Description</th>
                                    <th scope="col" class="text-end">Cost</th>
                                    <th scope="col" class="text-end">Price</th>
                                    <th scope="col" class="text-end">Quantity</th>
                                    <th scope="col" class="text-end">Total Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1; @endphp
                                @foreach($orderItems as $item)
                                    @php
                                        $product = $item->product;
                                        $suppliers = $product->purchaseItem->pluck('purchase.supplier.name')->filter()->unique()->implode('، ');
                                    @endphp
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td class="text-end">{{ $product->name }}</td>
                                        <td class="text-end">{{ $suppliers ?: 'غير متوفر' }}</td>
                                        <td class="text-end">{{ $product->description ?? '' }}</td>
                                        <td class="text-end">{{ $item->cost_per_one}}</td>
                                        <td class="text-end">{{ $product->price }}</td>
                                        <td class="text-end">{{ $item->quantity }}</td>
                                        <td class="text-end">{{ $item->cost_total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>      
                                    <td colspan="7" class="text-end fw-bold">
                                   
                                    </td>
                                    <td class="text-end fw-bold">{{ $orderItems->sum('cost_total') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>
                </div>               
            </div>
               
 
        </div>
    </div>   
@endsection
