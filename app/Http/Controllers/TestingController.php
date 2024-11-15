<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class TestingController extends Controller
{
// debug objek, attribut increment
public function testIncrement($id)
{
    $product = Produk::find($id);
    if ($product) {
        $product->search_point = $product->search_point + 1; 
        $product->save();
        return response()->json($product);
    }
    return response()->json(['message' => 'Product not found']);
}



}
