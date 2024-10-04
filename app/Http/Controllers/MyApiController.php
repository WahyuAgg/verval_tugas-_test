<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyApiController extends Controller {
    public function getData()
    {
        $data = [
            ['id' => 1, 'name' => 'Item 1'],
            ['id' => 2, 'name' => 'Item 2'],
            ['id' => 3, 'name' => 'Item 3'],
        ];

        return response()->json($data); // Kembalikan data sebagai JSON
    }
}
