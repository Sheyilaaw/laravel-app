<?php

namespace App\Http\Controllers;

use App\Product;
use http\Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public  function store (Request $request) {
        try {
            $contactInfo = Storage::disk('local')->exists('data.json')
                ? json_decode(Storage::disk('local')->get('data.json')) : [];

            $inputData = $request->only(['name', 'quantity', 'price']);
            $inputData['total_value'] = $inputData['quantity'] * $inputData['price'];
            $inputData['datetime_submitted'] = date('Y-m-d H:i:s');

            array_push($contactInfo, $inputData);
            Storage::disk('local')->put('data.json', json_encode($contactInfo));
            return  ['success' => true, 'message' =>  $inputData ];
        }catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
