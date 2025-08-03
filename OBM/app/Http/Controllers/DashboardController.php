<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Partner;
use App\Models\Transaction;
use App\Models\Supplier;
use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Sitting;

use Mpdf\Mpdf;

class DashboardController extends Controller
{
    public function category()
    {
        $category = Category::paginate(3);
        $product = Product::with([
            'category:id,name', // جلب فقط اسم الفئة المرتبطة
            'purchaseItem.purchase:id,supplier_id', // ربط الشراء بالمورد
            'purchaseItem.purchase.supplier:id,name' // جلب فقط اسم المورد
        ])
        ->get();
    

        return view('category', compact('category','product'));        
    }   
    public function addcat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
        Category::create($request->all());
        return back()->with('success', 'Category created successfully');
    } 
    public function updatecat(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validatedData);
        return redirect('category')->with('success', 'Category Updated successfully');

    } 

    public function editcat($id)
    {
        $category = Category::findOrFail($id);
        return view('editcat', compact('category'));
    }
    public function infocat($id)
    {
        $products = Product::with([
            'category:name',
            'purchaseItem.purchase',
            'purchaseItem.purchase.supplier:id,name'  
        ])->where('category_id', $id)->get();
        $category = Category::findOrFail($id);

        return view('products', compact('products','category'));        
    }
    public function addpro(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // حفظ بيانات الاختصاص للجامعة
        $ss=Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'cost' => $validated['cost']
        ]);
        
        return redirect()->route('infocat', ['category' => $validated['category_id']])
                        ->with('success', 'Product added successfully.');
    }
    public function searchpro(Request $request)
    {
        $category = Category::paginate(3);
        $name = $request->input('name');

        $product = Product::with([
            'category:id,name',
            'purchaseItem.purchase:id,supplier_id',
            'purchaseItem.purchase.supplier:id,name'
        ])
        ->where('name', 'like', '%' . $name . '%')
        ->get(); 
    
        return view('category', compact('category','product'));        
    }  

    public function editpro($id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('editpro', compact('product','categories'));
    }
    
    public function updatepro(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $updated = false;

        // تحديث الاسم إذا تغير
        if ($request->name !== $product->name) {
            $product->name = $request->name;
            $updated = true;
        }

        // تحديث الوصف إذا تغير
        if ($request->description !== $product->description) {
            $product->description = $request->description;
            $updated = true;
        }

        // تحديث السعر إذا تغير
        if ($request->price != $product->price) {
            $product->price = $request->price;
            $updated = true;
        }

        // تحديث الكمية إذا تغيرت
        if ($request->stock != $product->stock) {
            $product->stock = $request->stock;
            $updated = true;
        }
        if ($request->cost != $product->cost) {
            $product->cost = $request->cost;
            $updated = true;
        }
        // تحديث التصنيف إذا تغير
        if ($request->category_id != $product->category_id) {
            $product->category_id = $request->category_id;
            $updated = true;
        }

        if ($updated) {
            $product->save();
            return redirect('category')->with('success', 'تم تحديث المنتج بنجاح');
        }

        return redirect()->back()->with('info', 'لم يتم تعديل أي بيانات');
    }
    public function sales()
    {
        $users = User::withCount('order')->paginate(5); // يعرض 5 في كل صفحة
        $orders = Order::with('user') // جلب اسم المستخدم
        ->withCount('orderItem as orderItem_count') // عدد العناصر المرتبطة بكل order
        ->where('status', 'available') // فقط الطلبات المتاحة
        ->paginate(5); // عدد النتائج في الصفحة
        $finishedorders = Order::with('user') // جلب اسم المستخدم
        ->withCount('orderItem as orderItem_count') // عدد العناصر المرتبطة بكل order
        ->where('status', 'finish') // فقط الطلبات المتاحة
        ->paginate(5);
        return view('sales', compact('users','orders','finishedorders'));
    }
    
    public function searchuser(Request $request)
    {
        $name = $request->input('name');

        $users = User::withCount('order')
        ->where('name', 'like', '%' . $name . '%')
        ->paginate(5); 
        $orders = Order::with('user') // جلب اسم المستخدم
        ->withCount('orderItem as orderItem_count') // عدد العناصر المرتبطة بكل order
        ->where('status', 'available') // فقط الطلبات المتاحة
        ->paginate(5); // عدد النتائج في الصفحة
        $finishedorders = Order::with('user') // جلب اسم المستخدم
        ->withCount('orderItem as orderItem_count') // عدد العناصر المرتبطة بكل order
        ->where('status', 'finish') // فقط الطلبات المتاحة
        ->paginate(5);
        return view('sales', compact('users','orders','finishedorders'));
    } 
    public function order($id)
    {
        $category = Category::all();
        $order = Order::where('user_id', $id)
        ->where('status', 'preparation')
        ->orderBy('created_at', 'asc')
        ->first();
        if ($order) {
            $ido=$order->id;
        } else {
            $newOrder = Order::create([
                'user_id'     => $id,
                'location' => '', 
                'cost'        => 0,
                'total'       => 0,
                'amount_received' => 0,
                'status'      => 'preparation',
            ]);
             $ido=$newOrder->id;
        }
        return view('sales1', compact('category','ido'));
    } 
    public function infocatsale($category_id)
    {
        $products = Product::with([
            'purchaseItem.purchase.supplier' // لتحميل العلاقات المطلوبة
        ])
        ->where('category_id', $category_id)
        ->get();
    
        $data = $products->map(function ($product) {
            $suppliers = $product->purchaseItem->pluck('purchase.supplier.name')->filter()->unique()->implode('، ');

            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'costs' => $product->cost,
                'suppliers' => $suppliers ?: 'لا يوجد'
            ];
        });
    
        return response()->json($data);
    }
    
    public function storeProduct(Request $request, $order_id)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
    
        // تحقق من توفر الكمية في المخزون
        if ($product->stock < $quantity) {
            return response()->json([
                'message' => 'الكمية المطلوبة غير متوفرة في المخزون',
                'available_stock' => $product->stock
            ], 400); // حالة خطأ 400
        }
    
        // حساب السعر والتكلفة
        $pricePerOne = $product->price;
        $priceTotal = $pricePerOne * $quantity;
    
        // في حال كان لديك تكلفة محفوظة
        $costPerOne = $product->cost;
        $costTotal = $costPerOne * $quantity;

        // إنشاء سطر الطلب
        $orderItem =OrderItem::create([
            'order_id'      => $order_id,
            'product_id'    => $product->id,
            'quantity'      => $quantity,
            'price_per_one' => $pricePerOne,
            'price_total'   => $priceTotal,
            'cost_per_one'  => $costPerOne,
            'cost_total'    => $costTotal,
        ]);
    
        // تقليل الكمية من المخزون
        $product->decrement('stock', $quantity);
    
        return response()->json([
            'message' => 'تم إرسال الطلب',
            'name'    => $product->name,
            'quantity'=> $quantity,
            'product_id' => $product->id,
            'stock' => $product->stock,

        ]);
    }
    public function cart($ido)
    {
        $orderItems = OrderItem::with([
            'product.purchaseItem.purchase.supplier' // ربط المورّد عن طريق العمليات الشرائية
        ])
        ->where('order_id', $ido)
        ->get();
        $user_id = Order::find($ido)->user_id;
        return view('sales2', compact('orderItems','ido','user_id'));
    }
    public function deleteprofromorder($id)
    {
        $orderItem = OrderItem::findOrFail($id);

        if ($orderItem) {
            // استرجاع المنتج المرتبط
            $product = $orderItem->product;

            // زيادة الكمية المحذوفة إلى مخزون المنتج
            if ($product) {
                $product->stock += $orderItem->quantity;
                $product->save();
            }

            // حذف عنصر الطلب
            $orderItem->delete();
        }

        return back()->with('success', 'Product deleted successfully and quantity returned to stock.');
    }


    public function searchpro2(Request $request)
    {
        $name = $request->input('name');

        $products = Product::with([
            'purchaseItem.purchase.supplier'
        ])
        ->where('name', 'like', '%' . $name . '%')
        ->get();

        $data = $products->map(function ($product) {
            return [
                'id'          => $product->id,
                'name'        => $product->name,
                'description' => $product->description,
                'price'       => $product->price,
                'stock'       => $product->stock,
                'costs'       => $product->cost,
                'supplier'    => $product->purchaseItem->pluck('purchase.supplier.name')->filter()->unique()->implode('، '),
            ];
        });

        return response()->json($data);
    }
    public function completeorder(Request $request)
    {
        $request->validate([
            'ido' => 'required|exists:orders,id',
            'location' => 'required|string|max:255',
            'total_cost' => 'required|numeric',
            'total_price' => 'required|numeric',
        ]);
    
        if ($request->total_price==0||$request->total_cost==0) {
            return back()->with('error', 'The Order is empty');
        }
        $order = Order::find($request->ido);
    
        if (!$order) {
            return back()->with('error', 'The Order Not Found');
        }
    
        $order->location = $request->location;
        $order->cost = $request->total_cost;
        $order->total = $request->total_price;
        $order->status = 'available'; // يمكنك تخصيص الحالة حسب نظامك
        $order->save();
        return redirect()->route('sales')->with('success', 'The request was completed successfully.');
    }
    public function infoorder($ido)
    {
        $orderItems = OrderItem::with([
            'product.purchaseItem.purchase.supplier' // ربط المورّد عن طريق العمليات الشرائية
        ])
        ->where('order_id', $ido)
        ->get();
        $order = Order::find($ido);
        return view('infoorder', compact('orderItems','order'));
    }
    public function finishorder(Request $request)
    {
        $request->validate([
            'ido' => 'required|exists:orders,id',
            'location' => 'required|string|max:255',
            'total_cost' => 'required|numeric',
            'total_price' => 'required|numeric',
            'received' => 'required|numeric',
        ]);
    
        if ($request->total_price == 0 || $request->total_cost == 0 || $request->received == 0) {
            return back()->with('error', 'The order is empty');
        }
    
        $order = Order::find($request->ido);
    
        if (!$order) {
            return back()->with('error', 'The order Not Found');
        }
    
        $received = $request->received;
        $originalCost = $request->total_cost;
        $price = $request->total_price;
    
        $profit = $received - $originalCost;
    
        // ✅ إن زاد الربح عن دولار أضف 0.5% من مصروفات الإكسسوارات إلى التكلفة
        $adjustedCost = $originalCost;
        if ($profit > 1) {
            $accessoryExpenses = Transaction::where('type', 'expense')
                ->where('status', 'accessories')
                ->sum('amount');
    
            $extraCost = ($accessoryExpenses * 0.5) / 100;
            $adjustedCost += $extraCost;
        }
    
        $finalProfit = $received - $adjustedCost;
    
        // تحديث بيانات الطلب
        $order->amount_received = $received;
        $order->location = $request->location;
        $order->cost = $adjustedCost;
        $order->total = $price;
        $order->status = 'finish';
        $order->save();
    
        // تحديث الرصيد
        $balance = Sitting::where('key', 'Balance')->first();
        $currentBalance = (float) str_replace(',', '', $balance->value);
        $newBalance = $currentBalance + $adjustedCost;
        $balance->value = number_format($newBalance, 3, '.', '');
        $balance->save();
    
        // توزيع الحصص على الشركاء
        $partners = Partner::all();
        foreach ($partners as $partner) {
            $cost_share = ($partner->capital_percentage / 100) * $adjustedCost;
            $profit_share = ($partner->profit_percentage / 100) * $finalProfit;
    
            $partner->capital_wallet += $cost_share;
            $partner->profit_wallet += $profit_share;
            $partner->save();
        }
    
        // تسجيل العملية
        Transaction::create([
            'type' => 'income',
            'amount' => $request->received,
            'description' => 'Order #' . $order->id . ' completed. Received amount: ' . $request->received,
            'status' => 'materials', // أو حسب نوع الطلب
        ]);
    
        return redirect()->route('sales')->with('success', 'The order was finished and distributed successfully.');
    }
    
    
    public function deleteorder($id)
    {
        // جلب الطلب
        $order = Order::findOrFail($id);
    
        // جلب العناصر المرتبطة بالطلب
        $orderItems = $order->orderItem;
    
        foreach ($orderItems as $item) {
            // استرجاع المنتج المرتبط بهذا العنصر
            $product = $item->product;
    
            // إعادة الكمية إلى المخزون
            $product->stock += $item->quantity;
            $product->save();
    
            // حذف السطر
            $item->delete();
        }
    
        // حذف الطلب
        $order->delete();
    
        return redirect()->route('sales')->with('success', 'Order and related items were deleted and quantities returned to stock.');
    }
    public function infofinishedorder($ido)
    {
        $orderItems = OrderItem::with([
            'product.purchaseItem.purchase.supplier' // ربط المورّد عن طريق العمليات الشرائية
        ])
        ->where('order_id', $ido)
        ->get();
        $order = Order::find($ido);
        return view('infofinishedorder', compact('orderItems','order'));
    }


    



    public function Partnerships()
    {
        $users = Partner::all(); // يعرض 5 في كل صفحة

        return view('partnerships', compact('users'));
    }


    public function addpartner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capital' => 'required|numeric|min:0',
            'capital_percentage' => 'required|numeric|min:0|max:100',
            'profit_percentage' => 'required|numeric|min:0|max:100',
        ]);
    
        // إنشاء الشريك
        $partner = new Partner();
        $partner->name = $request->input('name');
        $partner->capital = $request->input('capital');
        $partner->capital_percentage = $request->input('capital_percentage');
        $partner->profit_percentage = $request->input('profit_percentage');
        $partner->save();
    
        // إضافة سطر في جدول transactions
        Transaction::create([
            'type' => 'income',
            'amount' => $partner->capital,
            'description' => 'Capital contribution from partner: ' . $partner->name,
            'status' => 'materials', // يمكنك تغييره لو تحب استخدام 'accessories'
        ]);
    
        // تحديث الرصيد (Balance) في جدول sittings
        $balanceSetting = Sitting::where('key', 'Balance')->first();
    
        if ($balanceSetting) {
            $currentBalance = (float) str_replace(',', '', $balanceSetting->value);
            $newBalance = $currentBalance + $partner->capital;
            $balanceSetting->value = number_format($newBalance, 3, '.', ''); // حفظ الرصيد بتنسيق 3 فواصل عشرية
            $balanceSetting->save();
        } else {
            // لو لا يوجد Balance سابق، ننشئ واحد جديد
            Sitting::create([
                'key' => 'Balance',
                'value' => number_format($partner->capital, 3, '.', ''),
            ]);
        }
    
        return back()->with('success', 'Partner added successfully and capital recorded.');
    }
     

    public function deletepar($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();
        return back()->with('success', 'Partner deleted successfully');
    }
    public function editpar($id)
    {
        $partner = Partner::findOrFail($id);
        return view('editpar', compact('partner'));
    }
    
    public function updatepar(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $updated = false;

        // تحديث الاسم إذا تغير
        if ($request->name !== $partner->name) {
            $partner->name = $request->name;
            $updated = true;
        }

        // تحديث الوصف إذا تغير
        if ($request->capital !== $partner->capital) {
            $partner->capital = $request->capital;
            $updated = true;
        }

        // تحديث السعر إذا تغير
        if ($request->capital_percentage != $partner->capital_percentage) {
            $partner->capital_percentage = $request->capital_percentage;
            $updated = true;
        }

        // تحديث الكمية إذا تغيرت
        if ($request->profit_percentage != $partner->profit_percentage) {
            $partner->profit_percentage = $request->profit_percentage;
            $updated = true;
        }
        
        if ($updated) {
            $partner->save();
            return redirect('partnerships')->with('success', 'تم تحديث الشربك بنجاح');
        }

        return redirect()->back()->with('info', 'لم يتم تعديل أي بيانات');
    }


    public function purchasing()
    {
        $suppliers = Supplier::withCount('purchase')->paginate(5); // يعرض 5 في كل صفحة
        $purchase = Purchase::with('supplier') // جلب اسم المستخدم
        ->withCount('purchaseItem as purchaseItem_count') // عدد العناصر المرتبطة بكل order
        ->paginate(5); // عدد النتائج في الصفحة
        return view('purchasing', compact('purchase','suppliers'));
    }
    public function purchase($id)
    {
        $category = Category::all();
        $purchase = Purchase::where('supplier_id', $id)
        ->where('status', 'preparation')
        ->orderBy('created_at', 'asc')
        ->first();
        if ($purchase) {
            $idp=$purchase->id;
        } else {
            $newOrder = Purchase::create([
                'supplier_id' => $id,
                'total' => 0, 
                'status'=> 'preparation',
            ]);
             $idp=$newOrder->id;
        }
        return view('sales12', compact('category','idp'));
    }
    public function addsupplier(Request $request)
    {
        // تحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
        ]);
    
        // إنشاء مورد جديد
        Supplier::create([
            'name' => $request->name,
            'location' => $request->location,
            'contact' => $request->contact,
        ]);
    
        // العودة مع رسالة نجاح
        return redirect()->back()->with('success', 'Supplier added successfully!');
    }

    public function storeProduct1(Request $request, $purchase_id)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'cost_per_one' => 'required|numeric|min:0',
        ]);
    
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $costPerOne = $request->cost_per_one;
        $costTotal = $costPerOne * $quantity;
    
        // ✅ قراءة الرصيد الحالي
        $balanceSetting = Sitting::where('key', 'Balance')->first();
        $currentBalance = (float) str_replace(',', '', $balanceSetting->value);
    
        if ($currentBalance < $costTotal) {
            return response()->json([
                'message' => 'الرصيد غير كافٍ لإتمام عملية الشراء.',
            ], 400);
        }
    
        // إنشاء السطر في جدول purchase_items
        $purchaseItem = PurchaseItem::create([
            'purchase_id'   => $purchase_id,
            'product_id'    => $product->id,
            'quantity'      => $quantity,
            'cost_per_one'  => $costPerOne,
            'cost_total'    => $costTotal,
        ]);
    
        // زيادة الكمية في المخزون
        $product->increment('stock', $quantity);
        $product->cost = $costPerOne;
        $product->save();
    
        // تحديث إجمالي فاتورة الشراء
        $purchase = Purchase::findOrFail($purchase_id);
        $purchase->total += $costTotal;
        $purchase->save();
    
        return response()->json([
            'message' => 'تمت إضافة المنتج إلى فاتورة الشراء',
            'product' => $product->name,
            'quantity' => $quantity,
            'new_stock' => $product->stock,
            'purchase_total' => $purchase->total,
            'cost'=> $product->cost
        ]);
    }
    
    public function cartpur($idp)
    {
        $orderItems = PurchaseItem::with([
            'purchase.supplier' // ربط المورّد عن طريق العمليات الشرائية
        ])
        ->where('purchase_id', $idp)
        ->get();
        $user_id = Purchase::find($idp)->supplier_id;
        return view('sales22', compact('orderItems','idp','user_id'));
    }
    public function deleteitemfrompur($id)
    {
        $orderItem = PurchaseItem::findOrFail($id);

        if ($orderItem) {
            // استرجاع المنتج المرتبط
            $product = $orderItem->product;

            // زيادة الكمية المحذوفة إلى مخزون المنتج
            if ($product) {
                $product->stock -= $orderItem->quantity;
                $product->save();
            }

            // حذف عنصر الطلب
            $orderItem->delete();
        }

        return back()->with('success', 'Product deleted successfully and quantity returned to stock.');
    }

    public function deletepur($id)
    {
        // جلب الطلب
        $order = Purchase::findOrFail($id);
    
        // جلب العناصر المرتبطة بالطلب
        $orderItems = $order->purchaseItem;
    
        foreach ($orderItems as $item) {
            // استرجاع المنتج المرتبط بهذا العنصر
            $product = $item->product;
    
            // إعادة الكمية إلى المخزون
            $product->stock -= $item->quantity;
            $product->save();
    
            // حذف السطر
            $item->delete();
        }
    
        // حذف الطلب
        $order->delete();
    
        return redirect()->route('purchasing')->with('success', 'Purchase and related items were deleted and quantities.');
    }
    public function completepur(Request $request)
    {
        $request->validate([
            'idp' => 'required|exists:purchases,id',
            'total_cost' => 'required|numeric|min:1', // تأكد أن التكلفة أكبر من صفر
        ]);
    
        $order = Purchase::findOrFail($request->idp);
    
        $order->total = $request->total_cost;
        $order->status = 'finish';
        $order->save();

    
        $balanceSetting = Sitting::where('key', 'Balance')->first();

        if ($balanceSetting) {
            $currentBalance = (float) $balanceSetting->value;
            $totalCost = (float) $request->total_cost;
            
            $newBalance = $currentBalance - $totalCost;
            if ($newBalance < 0) {
                return back()->with('error', 'رصيد المال لا يكفي لإتمام العملية');
            }
            $balanceSetting->value = number_format($newBalance, 3, '.', ''); // يحفظ الرقم مثل 1234.50
            $balanceSetting->save();
        
           
        } else {
            return back()->with('error', 'Balance setting غير موجود');
        }
    
        // تسجيل العملية في transactions
        Transaction::create([
            'type' => 'expense',
            'amount' => $request->total_cost,
            'description' => 'Purchase #' . $order->id . ' completed. Paid amount: ' . $request->total_cost,
            'status' => 'materials', // أو حسب نوع الطلب إن كان مواد أو إكسسوارات
        ]);
    
        return redirect()->route('purchasing')->with('success', 'The request was completed successfully.');
    }
    
    public function infopurchase($idp)
    {
        $orderItems = PurchaseItem::with([
           'purchase.supplier' // ربط المورّد عن طريق العمليات الشرائية
        ])
        ->where('purchase_id', $idp)
        ->get();
        $order = Purchase::find($idp);
        return view('infopurchase', compact('orderItems','order'));
    }







    public function dashmony()
    {
        // مجموع رأس المال المدفوع من الشركاء
        $capitalFromPartners = Partner::sum('capital');

        // مجموع المصروفات
        $totalExpenses = Transaction::where('type', 'expense')->sum('amount');

        // رأس المال المتبقي = رأس المال - المصروفات
        $remainingCapital = $capitalFromPartners - $totalExpenses;

        $balanceSetting = Sitting::where('key', 'Balance')->first();

        // مجموع المبيعات = جمع كل income
        $totalSales1 = Transaction::where('type', 'income')->sum('amount');
        $totalSales = $totalSales1 - $capitalFromPartners ;

        //  5 عمليات
        $Transactions = Transaction::paginate(5);

        // أغلى منتج
        $mostExpensiveProduct = Product::orderByDesc('price')->first();

        // أكثر منتج مبيعاً (حسب مجموع الكمية)
        $mostSoldProduct = Product::withSum('orderItem as total_sold', 'quantity')
            ->orderByDesc('total_sold')
            ->first();

        // أقل المنتجات مبيعاً
        $leastSoldProducts = Product::withSum('orderItem as total_sold', 'quantity')
            ->orderBy('total_sold')
            ->take(5)
            ->get();

        // عدد المنتجات ذات الكمية فقط
        $totalProducts = Product::where('stock', '>', 0)->count();

        // أكثر مورد تم التعامل معه
        $topSupplier = Supplier::withCount('purchase')
            ->orderByDesc('purchase_count')
            ->first();

        // الطلبات المنتهية والمتاحة
        $finishedCount = Order::where('status', 'finish')->count();
        $availableCount = Order::where('status', 'available')->count();

        // أكثر location تكرر ضمن الطلبات المنتهية
        $topLocation = Order::where('status', 'finish')
            ->select('location', \DB::raw('COUNT(*) as count'))
            ->groupBy('location')
            ->orderByDesc('count')
            ->first();

        // ✅ إجمالي سعر المنتجات المتوفرة
        $totalAvailableProductsPrice = Product::where('stock', '>', 0)
            ->selectRaw('SUM(price * stock) as total_price')
            ->value('total_price');

        // ✅ إجمالي تكلفة المنتجات المتوفرة
        $totalAvailableProductsCost = Product::where('stock', '>', 0)
            ->selectRaw('SUM(cost * stock) as total_cost')
            ->value('total_cost');

        return view('dashmony', [
            'balance'               => $balanceSetting->value,
            'totalExpenses'         => $totalExpenses,
            'capitalFromPartners'   => $capitalFromPartners,
            'remainingCapital'      => $remainingCapital,
            'Transactions'          => $Transactions,
            'mostExpensiveProduct'  => $mostExpensiveProduct,
            'mostSoldProduct'       => $mostSoldProduct,
            'leastSoldProducts'     => $leastSoldProducts,
            'totalProducts'         => $totalProducts,
            'totalSales'            => $totalSales,
            'topSupplier'           => $topSupplier,
            'finishedCount'         => $finishedCount,
            'availableCount'        => $availableCount,
            'topLocation'           => $topLocation ? $topLocation->location : 'غير محدد',
            'topLocationCount'      => $topLocation ? $topLocation->count : 0,

            // ✅ القيم الجديدة
            'totalAvailableProductsPrice' => $totalAvailableProductsPrice,
            'totalAvailableProductsCost'  => $totalAvailableProductsCost,
        ]);
    }



    public function downloadPDF()
    {
        $products = Product::with(['category', 'purchaseItem.purchase.supplier'])->get();

        $html = view('pdf', compact('products'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'amiri',
            'default_font_size' => 12,
        ]);

        $mpdf->SetDirectionality('rtl'); // ضروري لليسار لليمين
        $mpdf->WriteHTML($html);
        return response($mpdf->Output('products.pdf', 'D'), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }




    public function storetransaction(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:materials,accessories',
            'description' => 'nullable|string',
        ]);

        $transactionAmount = $request->amount;
        $transactionType = $request->type;
        
        $balanceSetting = Sitting::where('key', 'Balance')->first();
        $currentBalance = (float) str_replace(',', '', $balanceSetting->value);
        
        if ($transactionType === 'expense') {
            $newBalance = $currentBalance - $transactionAmount;
            $balanceSetting->value = number_format($newBalance, 3, '.', '');
            $balanceSetting->save();
        } elseif ($transactionType === 'income') {
            return redirect()->back()->with('error', 'Cannot process income in this operation.');
        }
        Transaction::create([
            'type' => $request->type,
            'amount' => $request->amount,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة العملية المالية بنجاح');
    }
    
    public function resetProfitWallet($partnerId)
    {
        $partner = Partner::findOrFail($partnerId);
        $partner->profit_wallet = 0;
        $partner->save();

        return redirect()->back()->with('success', 'تم تصفير محفظة الأرباح بنجاح.');
    }
}
