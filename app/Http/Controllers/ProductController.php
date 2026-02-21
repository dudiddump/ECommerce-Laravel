<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // GET /api/products (Public)
    public function index() {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    // GET /api/products/{id} (Public)
    public function show($id) {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return new ProductResource($product);
    }

    // POST /api/products (Admin Only)
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required', 
            'price' => 'required|numeric|min:0',
            'status' => 'in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed', 
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::create($request->all());

        return response()->json([
            'data' => $product
        ], 201);
    }

    // PUT /api/products/{id} (Admin Only)
    public function update(Request $request, $id) {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'status' => 'in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($request->all());

        return response()->json([
            'data' => $product
        ], 200);
    }

    // DELETE /api/products/{id} (Admin Only)
    public function delete($id) {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json([
            'data' => ['message' => 'Product deleted successfully']
        ], 200);
    }
}