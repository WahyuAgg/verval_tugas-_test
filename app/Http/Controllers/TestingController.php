<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class TestingController extends Controller
{
// Debugging example to test increment separately
public function testIncrement($id)
{
    $product = Produk::find($id);
    if ($product) {
        $product->search_point = $product->search_point + 1; // Manually increment search_point
        $product->save(); // Explicitly save the model after incrementing
        return response()->json($product);
    }
    return response()->json(['message' => 'Product not found']);
}



}
