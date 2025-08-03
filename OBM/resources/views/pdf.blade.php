<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Products PDF</title>
    <style>
        body {
            direction: rtl;
            font-family: 'Amiri', DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            direction: rtl;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: right;
        }

        tfoot td {
            font-weight: bold;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body dir="rtl" style="text-align: right; font-family: 'Amiri';">
    <h2>قائمة المنتجات</h2>

    @php
        $totalCostSum = 0;
        $totalPriceSum = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>الاسم</th>
                <th>التصنيف</th>
                <th>الوصف</th>
                <th>التكلفة</th>
                <th>السعر</th>
                <th>المخزون</th>
                <th>مجموع التكلفة</th>
                <th>مجموع السعر</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                @if($product->stock > 0)
                    @php
                        $suppliers = $product->purchaseItem->pluck('purchase.supplier.name')->filter()->unique()->implode('، ');
                        $costTotal = $product->cost * $product->stock;
                        $priceTotal = $product->price * $product->stock;
                        $totalCostSum += $costTotal;
                        $totalPriceSum += $priceTotal;
                    @endphp
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ number_format($product->cost, 2) }}</td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ number_format($costTotal, 2) }}</td>
                        <td>{{ number_format($priceTotal, 2) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: center;">الإجمالي</td>
                <td>{{ number_format($totalCostSum, 2) }}</td>
                <td>{{ number_format($totalPriceSum, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
