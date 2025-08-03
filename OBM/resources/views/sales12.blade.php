@extends('layouts.admin')

@section('title')
Category Management Page
@endsection

@section('content')

    <nav   nav class="navbar bg-body-tertiary">
        <div class="container-fluid  justify-content-md-between">
            <a class="navbar-brand fw-normal fs-4 mb-1 mb-md-0 d-none d-sm-block ">Shopping from here</a>
            <div class="text-end d-inline">
                <a href="/cartpur/{{$idp}}" class="btn btn-success">Cart</a>
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
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
 

            <div class="row my-4">
                <!-- الكاتيجوري ككاردات -->
                @foreach($category as $category)
                    <div class="col-md-3 my-2">
                        <div class="card category-card cursor-pointer" data-category-id="{{ $category->id }}">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $category->name }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr> 
            <div class="navbar">
                <h3 class="ms-2 ">Products</h3>
                <form id="search-form" class="d-flex" role="search">
                    @csrf
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="name" id="search-input">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

            </div>
            <hr>    
    
        <!-- المنتجات تظهر هنا -->
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered" id="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>supplier</th>
                            <th>Description</th>                          
                            <th>Cost</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th >Quantity</th>
                            <th>Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- المنتجات ستحقن هنا عبر JS -->
                    </tbody>
                </table>
                
            </div>
        </div>


        </div>   
    </div>   
<script>
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function () {
            let categoryId = this.dataset.categoryId;

            fetch(`/infocatsale/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    let tableBody = document.querySelector('#products-table tbody');
                    tableBody.innerHTML = '';

                    data.forEach(product => {
                        let row = `
                            <tr>
                                <td>${product.id}</td>
                                <td>${product.name}</td>
                                <td>${product.suppliers ?? 'غير متوفر'}</td>
                                <td>${product.description ?? ''}</td>
                                <td>${product.costs ?? 'غير متوفر'}</td>
                                <td>${product.price}</td>
                                <td>${product.stock ?? ''}</td>
                                <td>
                                    <input type="number"  class="form-control form-control-sm quantity-input "  value="1" min="1"  style="width: 50px;" 
                                    data-product-id="${product.id}" >
                                    <input type="number" class="form-control form-control-sm  cost-input mt-1" placeholder="تكلفة"  min="0" step="0.01" style="width: 70px;" 
                                 data-product-id="${product.id}" >
                                    <input type="hidden" id="order-id" value="{{ $idp }}">
                                </td>
                                <td>
                                        <button class="btn btn-sm btn-success order-btn" 
                                            data-product-id="${product.id}">
                                            شراء
                                        </button>
                                </td>
                            </tr>
                        `;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });

                    attachOrderEvents(); // ربط الأحداث بعد بناء الجدول
                });
        });
    });

    function attachOrderEvents() {
        document.querySelectorAll('.order-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const productId = this.dataset.productId;
                const quantity = document.querySelector(`.quantity-input[data-product-id="${productId}"]`).value;
                const cost = document.querySelector(`.cost-input[data-product-id="${productId}"]`).value;
                const orderId = document.getElementById('order-id').value;
                const row = this.closest('tr');
                const stockCell = row.querySelector('td:nth-child(7)');
                const costCell = row.querySelector('td:nth-child(5)');

                fetch(`/purchase-product/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity,
                        cost_per_one: parseFloat(cost)  // ← يجعلها رقم وليست نص
                    })
                })
                .then(async res => {
                    if (!res.ok) {
                        const error = await res.json();
                        throw new Error(error.message || 'خطأ');
                    }
                    return res.json();
                })
                .then(data => {
                showSuccess(`تم شراء المنتج: ${data.product} - الكمية: ${data.quantity}`);
                const newStock = parseInt(stockCell.textContent) + parseInt(data.quantity);
                stockCell.textContent = newStock;
                const newcost = data.cost;
                costCell.textContent = newcost;
            })
            .catch(error => {
                alert(error.message);
                });
            });
        });
    }

    function showSuccess(message) {
        const alertBox = document.createElement('div');
        alertBox.className = 'alert alert-success mt-3';
        alertBox.innerText = message;

        document.querySelector('.page-inner').prepend(alertBox);

        setTimeout(() => alertBox.remove(), 3000);
    }
    document.getElementById('search-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const searchValue = document.getElementById('search-input').value;

        fetch(`{{ route('searchpro2') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: searchValue })
        })
        .then(res => res.json())
        .then(data => {
            const tableBody = document.querySelector('#products-table tbody');
            tableBody.innerHTML = '';

            data.forEach(product => {
                let row = `
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.name}</td>
                        <td>${product.supplier ?? 'غير متوفر'}</td>
                        <td>${product.description ?? ''}</td>
                        <td>${product.costs ?? 'غير متوفر'}</td>
                        <td>${product.price}</td>
                        <td>${product.stock ?? ''}</td>
                        <td>
                            <input type="number" 
                                class="form-control form-control-sm quantity-input" 
                                value="1" min="1" 
                                style="width: 50px;" 
                                data-product-id="${product.id}" >

                            <input type="number" 
                                class="form-control form-control-sm mt-1 cost-input" 
                                placeholder="تكلفة" 
                                min="0"
                                step="0.01"
                                style="width: 70px;" 
                                data-product-id="${product.id}" >

                            <input type="hidden" id="order-id" value="{{ $idp }}">
                        </td>

                        <td>
                            <button class="btn btn-sm btn-success order-btn" data-product-id="${product.id}">شراء</button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });

            attachOrderEvents(); // تأكد أنك تنفذ دالة ربط الأزرار بعد التحديث
        })
        .catch(err => {
            alert('حدث خطأ أثناء البحث');
            console.error(err);
        });
    });
</script>
@endsection
