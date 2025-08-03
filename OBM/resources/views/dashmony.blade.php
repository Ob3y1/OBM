@extends('layouts.admin')

@section('content')
<div class="container mt-5">
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

 

    {{-- كروت إحصائية --}}
    <div class="row text-center mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm rounded-3 border-0 bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">رأس المال المتبقي</h5>
                    <p class="card-text fs-4">{{ $balance }} $</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm rounded-3 border-0 bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">مجموع المبيعات</h5>
                    <p class="card-text fs-4">{{ $totalSales }} $</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm rounded-3 border-0 bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">المنتجات المتوفرة</h5>
                    <p class="card-text fs-4">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm rounded-3 border-0 bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">المورد الأعلى</h5>
                    <p class="card-text fs-5">{{ $topSupplier->name ?? 'غير متوفر' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- رسم بياني --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">تحليل مالي</h5>
            <canvas id="financeChart" height="100"></canvas>
        </div>
    </div>
                        <div class="row my-4">
                            <div class="col-md-4">
                                <div class="card shadow rounded-4 p-3 text-center">
                                    <h5 class="text-muted">الطلبات المنتهية</h5>
                                    <h2 id="finished-count" class="text-success fw-bold">{{$finishedCount}}</h2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow rounded-4 p-3 text-center">
                                    <h5 class="text-muted">الطلبات المتاحة</h5>
                                    <h2 id="available-count" class="text-primary fw-bold">{{$availableCount}}</h2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow rounded-4 p-3 text-center">
                                    <h5 class="text-muted">أكثر موقع طلباً</h5>
                                    <h4 id="top-location" class="fw-bold text-success">{{$topLocation}}</h4>
                                    <small id="top-location-count" class="text-secondary">{{$topLocationCount}}</small>
                                </div>
                            </div>
                        </div>  
                        <div class="row my-4">
                            <div class="col-md-4">
                                <div class="card shadow rounded-4 p-3 text-center">
                                    <h5 class="text-muted"> مجموع التكلفة الحالية </h5>
                                    <h2 id="finished-count" class="text-success fw-bold">{{$totalAvailableProductsCost}}</h2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow rounded-4 p-3 text-center">
                                    <h5 class="text-muted">مجموع السعر الحالي </h5>
                                    <h2 id="available-count" class="text-primary fw-bold">{{$totalAvailableProductsPrice}}</h2>
                                </div>
                            </div>
                        </div>

                        {{-- المنتجات المميزة --}}
    <div class="row my-4">
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">أغلى منتج</h5>
                    @if($mostExpensiveProduct)
                        <p class="fs-5">{{ $mostExpensiveProduct->name }} - {{ $mostExpensiveProduct->price }} $</p>
                    @else
                        <p>لا يوجد</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">المنتج الأكثر مبيعًا</h5>
                    @if($mostSoldProduct)
                        <p class="fs-5">{{ $mostSoldProduct->name }} - {{ $mostSoldProduct->total_sold ?? 0 }} مبيعات</p>
                    @else
                        <p>لا يوجد</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">أقل المنتجات مبيعًا</h5>
                    <ul class="list-unstyled">
                        @foreach($leastSoldProducts as $prod)
                            <li>{{ $prod->name }} - {{ $prod->total_sold ?? 0 }} مبيعات</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- جدول آخر العمليات --}}
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"> العمليات المالية</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>النوع</th>
                                <th>المبلغ</th>
                                <th>الوصف</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Transactions as $trans)
                                <tr>
                                    <td>{{ $trans->type }}</td>
                                    <td>{{ $trans->amount }} $</td>
                                    <td>{{ $trans->description ?? '—' }}</td>
                                    <td>{{ $trans->status }}</td>
                                    <td>{{ $trans->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                                        {{ $Transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
    <div class="card card-primary card-round">
        <div class="card-header">
            <div class="card-head-row">
                <div class="card-title">إضافة عملية مالية</div>
            </div>
        </div>
        <div class="card-body pb-0">
            <form action="{{ route('transactions.store') }}" method="POST" class="mb-2">
                @csrf

                <div class="mb-2">
                    <label for="type" class="form-label">نوع العملية</label>
                    <select name="type" class="form-control" required>
                        <option value="">اختر النوع</option>
                        <option value="income">دخل</option>
                        <option value="expense">مصروف</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="amount" class="form-label">المبلغ</label>
                    <input type="number" step="0.01" min="0" name="amount" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label for="status" class="form-label">التصنيف</label>
                    <select name="status" class="form-control" required>
                        <option value="">اختر التصنيف</option>
                        <option value="materials">مواد</option>
                        <option value="accessories">اضافات</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-success">حفظ العملية</button>
            </form> 
        </div>
    </div>  
</div>
 
    </div>  
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('financeChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['رأس المال', 'المصروفات', 'المبيعات'],
            datasets: [{
                label: 'القيمة بالدولار',
                data: [
                    {{ $capitalFromPartners }},
                    {{ $totalExpenses }},
                    {{ $totalSales }}
                ],
                backgroundColor: ['#198754', '#dc3545', '#0d6efd'],
                borderRadius: 10,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

     
            document.getElementById('finished-count').textContent = data.finishedCount;
            document.getElementById('available-count').textContent = data.availableCount;
            document.getElementById('top-location').textContent = data.topLocation;
            document.getElementById('top-location-count').textContent = `عدد مرات التكرار: ${data.topLocationCount}`;
    

    });
</script>
@endsection
