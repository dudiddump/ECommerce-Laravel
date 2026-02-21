<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // POST /api/orders (Public)
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'status' => 'pending',
                'total_price' => 0
            ]);
            
            $totalPrice = 0; 

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                if ($product->status !== 'active') {
                    DB::rollBack(); 
                    return response()->json([
                        'message' => 'Validation failed',
                        'errors' => ['items' => ["Product ID {$product->id} is not active."]]
                    ], 422);
                }

                $subtotal = $item['qty'] * $product->price;
                $totalPrice += $subtotal;

                OrderItem::create([
                    'order_id'  => $order->id,
                    'product_id'    => $product->id,
                    'qty'   => $item['qty'],
                    'price' => $product->price,
                    'subtotal'  => $subtotal,
                ]);
            } 
            
            $order->update(['total_price' => $totalPrice]);
            DB::commit();
            $order->load('items');
            return (new OrderResource($order))->response()->setStatusCode(201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to process order',
                'errors'  => ['server' => [$e->getMessage()]]
            ], 500);
        }
    }

    // GET /api/orders (Admin Only)
    public function index() {
        $orders = Order::with('items')->get();

        return OrderResource::collection($orders);
    }

    // GET /api/orders/{id} (Admin Only)
    public function show($id) {
        $order = Order::with('items')->find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        return new OrderResource($order);
    }
}